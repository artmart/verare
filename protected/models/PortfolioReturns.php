<?php

/**
 * This is the model class for table "portfolio_returns".
 *
 * The followings are the available columns in table 'portfolio_returns':
 * @property integer $id
 * @property integer $portfolio_id
 * @property integer $is_prtfolio_or_group
 * @property string $trade_date
 * @property double $return
 * @property double $benchmark_return
 */
class PortfolioReturns extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PortfolioReturns the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'portfolio_returns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('portfolio_id, is_prtfolio_or_group, trade_date, return', 'required'),
			array('portfolio_id, is_prtfolio_or_group', 'numerical', 'integerOnly'=>true),
			array('return, benchmark_return', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, portfolio_id, is_prtfolio_or_group, trade_date, return, benchmark_return', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'portfolio_id' => 'Portfolio',
			'is_prtfolio_or_group' => 'Is Prtfolio Or Group',
			'trade_date' => 'Trade Date',
			'return' => 'Return',
            'benchmark_return' =>'Benchmark Return',
            
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('portfolio_id',$this->portfolio_id);
		$criteria->compare('is_prtfolio_or_group',$this->is_prtfolio_or_group);
		$criteria->compare('trade_date',$this->trade_date,true);
		$criteria->compare('return',$this->return);
        $criteria->compare('benchmark_return',$this->benchmark_return);
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
/////////////////////////
    public function PortfolioReturnsUpdate($portfolio_id, $client_id, $portfolio_currency)
	{  
        if($portfolio_id >0){
        ini_set('max_execution_time', 50000);
        $table_name = "client_".$client_id. "_inst_returns";
        //Trades
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     where l.is_current = 1 and i.is_current = 1 and l.trade_status_id = 2 and l.portfolio_id = $portfolio_id  and l.client_id = '$client_id' order by trade_date asc";
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
        
        foreach($trades as $trd){$ins_ids[] = $trd['instrument_id'];} 
        
        $insids = implode("','", array_unique($ins_ids));                         
                                
                                
        $portfolio_return_sql = "select p.trade_date,
                                sum((select sum(if(trade_date=p.trade_date, nominal*price*cr.{$portfolio_currency}/ledger.currency_rate, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = '$client_id')) pnl,
                                sum(p.price*cr.{$portfolio_currency}/curs.cur_rate * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = '$client_id')) top,
                                sum(p.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) sums
                                from prices p
                                inner join ledger ldg on ldg.instrument_id = p.instrument_id
                                inner join portfolios port on port.id = ldg.portfolio_id
                                inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
                                inner join currency_rates cr on cr.day = p.trade_date 
                                
                                inner join instruments i on i.id = p.instrument_id
                                inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                                
                                where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' and port.id = '$portfolio_id'
                                group by  p.trade_date
                                order by p.trade_date asc";
                                
                                //inner join benchmark_components bc on bc.instrument_id = p.instrument_id 
                                //inner join ledger l on l.instrument_id = p.instrument_id
                                //inner join benchmarks b on b.portfolio_id = l.portfolio_id
         Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $portfolio_returns = Yii::app()->db->createCommand($portfolio_return_sql)->queryAll(true);
        
        if(count($portfolio_returns)>0){
        $i = 0;
        
        //for benchmarks//
        $return1[0] = 1;
        $return_bench = 1;
        //$return_bench_daily[] = 1;
        ////////////////////////
        
        foreach($portfolio_returns as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $rawData[$i]['top'] = $price['top'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['return'] = 1;  
            
            ////For Benchmark///////
            $sums[$i] = $price['sums'];
            $rawData[$i]['benchmark_return'] = 1;
            ////////////////////////
                        
            if($i>0){ 
                    ////For Benchmark///////
                    if($sums[$i-1] !== 0){
                    $return1[$i] = $price['sums']/$sums[$i-1];
                    }else{$return1[$i] = 1;}
                    $return_bench = $return_bench * $return1[$i];
                    $rawData[$i]['benchmark_return'] = $return1[$i];
                    ////////////////////////
           
                    $div = $rawData[$i-1]['top'] + $rawData[$i]['pnl'];
                    
                    if($div>0){
                        $rawData[$i]['return'] = $rawData[$i]['top']/$div;
                    }
               }
         
              //checking if the return for current instrument is not exist and inserting the calculated return.//
               $existing_return  = PortfolioReturns::model()->findByAttributes([
                                                                                'portfolio_id'=>$portfolio_id, 
                                                                                'trade_date' =>$rawData[$i]['trade_date'], 
                                                                                //'is_prtfolio_or_group' =>1,
                                                                                //'return' =>$rawData[$i]['return'],
                                                                                //'benchmark_return' => $rawData[$i]['benchmark_return']
                                                                                ]);
               
                   if(count($existing_return)==0){
                       $return = new PortfolioReturns;
                       $return->portfolio_id = $portfolio_id;
                       $return->is_prtfolio_or_group = 1;
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['return'];
                       $return->benchmark_return = $rawData[$i]['benchmark_return'];
                       $return->save(); 
                   }else{
                           $existing_return->return = $rawData[$i]['return'];
                           $existing_return->benchmark_return = $rawData[$i]['benchmark_return'];
                           $existing_return->save(); 
                        }
               $i++;
               }     
          }else{
                ///portfolio return is empty////
                //Yii::app()->user->setFlash('notice', "There are not confirmed trades available aor prices not found.");
                //Yii::app()->user->setFlash('success', "Data1 saved!");
                //Yii::app()->user->setFlash('error', "Data2 failed!"); 
               // foreach(Yii::app()->user->getFlashes() as $key => $message) {
                //    echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
                //}
                //exit;       
              }  
        }else{
                ///treades are not found//
                Yii::app()->user->setFlash('notice', "Ledgar information not found.");
            }
        }    
        Yii::app()->user->setFlash('success', "Portfolio returns updated.");
        //$this->redirect('admin');       
    }
    
    
    
}