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
        //$table_name = "client_".$client_id. "_inst_returns";
        
        $p_ids[] = $portfolio_id;
        
        $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio = $portfolio_id")->queryAll(true);
        
        while(count($all_portfolios)>0){
            $new_ids = [];
            foreach($all_portfolios as $ap){
                $p_ids[] = $ap['id'];
                $new_ids[] = $ap['id'];
            }
            $new_p_ids = implode("','", array_unique($new_ids));
            $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio in ('$new_p_ids')")->queryAll(true);
        }
        
        $all_p_ids = implode("','", array_unique($p_ids));
        
        Yii::app()->db->createCommand("delete from portfolio_returns where portfolio_id = '$portfolio_id'")->execute();

        //Trades // and (p.id = $portfolio_id or p.parrent_portfolio = $portfolio_id )
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     inner join portfolios p on p.id = l.portfolio_id
                     where l.is_current = 1 and i.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' 
                     and p.id in ('$all_p_ids')
                     order by trade_date asc";
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
        
        foreach($trades as $trd){$ins_ids[] = $trd['instrument_id'];} 
        
        $insids = implode("','", array_unique($ins_ids));                         
                                
         //(port.id = $portfolio_id  or port.parrent_portfolio = $portfolio_id ) 
         //sum(p.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) sums   
         //sum((select  sum(p1.price*cr.SEK/curs.cur_rate*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date)) sums     
         /*              
        $portfolio_return_sql = "select p.trade_date,
                                sum((select sum(if(trade_date=p.trade_date, nominal*price*cr.{$portfolio_currency}/ledger.currency_rate, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id )) pnl,
                                sum(p.price*cr.{$portfolio_currency}/curs.cur_rate * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id )) top, 
                                sum((select sum(p1.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date and bc.benchmark_id = port.benchmark_id))/sum(bc.weight) sums
                                from prices p
                                inner join ledger ldg on ldg.instrument_id = p.instrument_id
                                inner join portfolios port on port.id = ldg.portfolio_id
                                inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
                                inner join currency_rates cr on cr.day = p.trade_date 
                                
                                inner join benchmarks bench on bench.id = port.benchmark_id and bench.client_id = ldg.client_id
                                
                                inner join instruments i on i.id = p.instrument_id
                                inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                                
                                where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' 
                                and port.id in ('$all_p_ids') 
                                group by  p.trade_date
                                order by p.trade_date asc";
                               
                                
                                
       $portfolio_return_sql = "select p.trade_date,
                                sum((select sum(if(trade_date=p.trade_date, nominal*price*cr.{$portfolio_currency}/ledger.currency_rate, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id )) pnl,
                                sum(p.price*cr.{$portfolio_currency}/curs.cur_rate * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id )) top, 
                                sum((select sum(p1.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date and bc.benchmark_id = port.benchmark_id))/sum(bc.weight) sums
                                from prices p
                                inner join ledger ldg on ldg.instrument_id = p.instrument_id
                                inner join portfolios port on port.id = ldg.portfolio_id
                                inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
                                inner join currency_rates cr on cr.day = p.trade_date 
                                
                                inner join benchmarks bench on bench.id = port.benchmark_id and bench.client_id = ldg.client_id
                                
                                inner join instruments i on i.id = p.instrument_id
                                inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                                
                                where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' 
                                and port.id in ('$all_p_ids') 
                                group by  p.trade_date
                                order by p.trade_date asc";
       */ 
                                
$portfolio_return_sql = "select p.trade_date, 
                            if(c.trd is not NULL, c.trd, 0) pnl,  
                            if(sum(p.price * m.port_val) is not NULL, sum(p.price * m.port_val* cr.{$portfolio_currency}/curs.cur_rate), 0) top,
                            if(bc.weight is not NULL, sum(bc.ww)/sum(bc.weight), 0) sums,
                            if(c.coupon is not NULL, c.coupon, 0) coupon 
                            
                            from prices p 
                            inner join currency_rates cr on cr.day = p.trade_date
                            inner join instruments i on i.id = p.instrument_id
                            inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                                                        
                            left join
                            (select l.trade_date, sum(l.nominal*l.price * cr.{$portfolio_currency}/curs.cur_rate) trd,
                                if(l.trade_type in ('2'), l.nominal*l.price * cr.{$portfolio_currency}/curs.cur_rate, 0) coupon
                        		from ledger l
                                
                                inner join currency_rates cr on cr.day = l.trade_date
                            	inner join instruments i on i.id = l.instrument_id
                            	inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency
                                
                        		where l.is_current = 1 and l.trade_status_id = 2 
                        		and l.instrument_id in ('$insids') and l.client_id = '$client_id' and l.portfolio_id in ('$all_p_ids') 
                        		group by l.trade_date
                            ) c on c.trade_date = p.trade_date  
                            
                            left join
                            (
                                select  trade_date, instrument_id, sum(nominal) port_val 
                                from ledger 
                                where  is_current = 1 and trade_status_id = 2 
                                and instrument_id in ('$insids') and client_id = '$client_id' and portfolio_id in ('$all_p_ids') 
                                group by trade_date, instrument_id
                            ) m on m.trade_date <= p.trade_date and m.instrument_id = p.instrument_id
                                                        
                            left join
                            (
                            select bc.instrument_id, p.trade_date,  p.price* bc.weight * cr.{$portfolio_currency}/curs.cur_rate ww, bc.weight
                            from benchmark_components bc 
                            inner join benchmarks bench on bench.id = bc.benchmark_id 
                            inner join portfolios port on port.benchmark_id = bench.id
                            inner join prices p on p.instrument_id = bc.instrument_id
                            
                            inner join currency_rates cr on cr.day = p.trade_date
                        	inner join instruments i on i.id = p.instrument_id
                        	inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                            
                            where port.id ='$portfolio_id'
                            ) bc on  bc.trade_date = p.trade_date
                            
                            where p.instrument_id in ('$insids') 
                            group by p.trade_date order by p.trade_date asc";  
                            
//echo $portfolio_return_sql;
//exit;
                   
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $portfolio_returns = Yii::app()->db->createCommand($portfolio_return_sql)->queryAll(true);
      
        if(count($portfolio_returns)>0){
            
            //Yii::app()->db->createCommand("delete from portfolio_returns where portfolio_id = '$portfolio_id'")->execute();
        $i = 0;
        
        //for benchmarks//
        $return1[$i] = 1;
        //$return_bench = 1;
        //$return_bench_daily[] = 1;
        ////////////////////////
        
        foreach($portfolio_returns as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $rawData[$i]['top'] = $price['top'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['coupon'] = $price['coupon'];
              
            $rawData[$i]['return'] = 1;  
            
            ////For Benchmark///////
            $sums[$i] = $price['sums'];
            $rawData[$i]['benchmark_return'] = 1;
            ////////////////////////
            $return1[$i] = 1;
                        
            if($i>0){ 
                    ////For Benchmark///////
                    if($sums[$i-1]> 0){$return1[$i] = $price['sums']/$sums[$i-1];}
                    //$return_bench = $return_bench * $return1[$i];
                    $rawData[$i]['benchmark_return'] = $return1[$i];
                    ////////////////////////
                    
                    //Portfolio return//
                    $div = $rawData[$i-1]['top'] + $rawData[$i]['pnl'];
                    if($div>0){$rawData[$i]['return'] = ($rawData[$i]['top']+$rawData[$i]['coupon'])/$div;}
               }
         
              //checking if the return for current instrument is not exist and inserting the calculated return.//
              /*
               $existing_return  = PortfolioReturns::model()->findByAttributes([
                                                                                'portfolio_id'=>$portfolio_id, 
                                                                                'trade_date' =>$rawData[$i]['trade_date'], 
                                                                                //'is_prtfolio_or_group' =>1,
                                                                                //'return' =>$rawData[$i]['return'],
                                                                                //'benchmark_return' => $rawData[$i]['benchmark_return']
                                                                                ]);
               
                   if(count($existing_return)==0){
               */
                       $return = new PortfolioReturns;
                       $return->portfolio_id = $portfolio_id;
                       $return->is_prtfolio_or_group = 1;
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['return'];
                       $return->benchmark_return = $rawData[$i]['benchmark_return'];
                       $return->save(); 
                       /*
                   }else{
                           $existing_return->return = $rawData[$i]['return'];
                           $existing_return->benchmark_return = $rawData[$i]['benchmark_return'];
                           $existing_return->save(); 
                        }
                        */
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