<?php

/**
 * This is the model class for table "returns".
 *
 * The followings are the available columns in table 'returns':
 * @property integer $id
 * @property integer $instrument_id
 * @property string $trade_date
 * @property double $return
 */
class Returns extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Returns the static model class
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
		return 'returns';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instrument_id, trade_date, return', 'required'),
			array('instrument_id', 'numerical', 'integerOnly'=>true),
			array('return', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, instrument_id, trade_date, return', 'safe', 'on'=>'search'),
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
			'instrument_id' => 'Instrument',
			'trade_date' => 'Trade Date',
			'return' => 'Return',
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
		$criteria->compare('instrument_id',$this->instrument_id);
		$criteria->compare('trade_date',$this->trade_date,true);
		$criteria->compare('return',$this->return);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
////////////////////////////////////////////////////////////////////////
    public function instrumnetReturnsUpdate($instrument_ids){
        
        if(count($instrument_ids)>0){
            ini_set('max_execution_time', 50000);
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $client_id = $user->client_id;
                         
        foreach($instrument_ids as $instrument_id){
            
            $portfolio_id = 0;
            
            $inst_sql = "select * from ledger l
                         inner join instruments i on l.instrument_id = i.id
                         where l.is_current = 1 and i.is_current = 1 and l.trade_status_id = 2 and i.id = $instrument_id and l.client_id = $client_id order by trade_date asc";
            $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
            foreach($trades as $trade){
        
            $portfolio_id = $trade['portfolio_id'];    
            //$instrument_id = $trade['instrument_id'];
            
            $portfolios = Portfolios::model()->findByPk($portfolio_id);
            $portfolio_currency = $portfolios->currency;
            
            Returns::model()->calculateIinstrumnetReturn($instrument_id, $portfolio_id = 0, $client_id, $portfolio_currency);
            }
            
            
        /*
        $portfolio_id = $trades[0]['portfolio_id'];
        //Prices and returns calculations            
            
        $prices_sql = "select distinct p.trade_date, p.price,
                        (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.trade_status_id = 2) nominal,
                        (select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id and ledger.trade_status_id = 2) pnl
                         from prices p
                        where p.is_current = 1 and p.instrument_id = $instrument_id   
                        order by p.trade_date asc";
                        
                        //and p.trade_date >='$dt'
        $prices = Yii::app()->db->createCommand($prices_sql)->queryAll(true);
        
        if(count($prices)>0){
        $i = 0;
        foreach($prices as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $rawData[$i]['price'] = $price['price'];
            $rawData[$i]['nominal'] = $price['nominal'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['return'] = 1;                          
            //$rawData[$i]['chart'] = 1;
             
            if($i>0 && $rawData[0]['price'] !== 0){
                   // $rawData[$i]['chart'] = $rawData[$i]['price']/$rawData[0]['price'];      
                
                    $div = $rawData[$i-1]['nominal'] * $rawData[$i-1]['price']+ $rawData[$i]['pnl'];
                    
                    if($div>0){
                        $rawData[$i]['return'] = ($rawData[$i]['nominal'] * $rawData[$i]['price'])/$div;
                    }else{
                        $rawData[$i]['return'] = 1;
                    }
                }
         
              //checking if the return for current instrument is not exist and inserting the calculated return.//
              
               $existing_return  = Returns::model()->findByAttributes(['instrument_id'=>$instrument_id, 'trade_date' =>$rawData[$i]['trade_date']]);
                   if(count($existing_return)==0){
                       $return = new Returns;
                       $return->instrument_id = $instrument_id;
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['return'];
                       $return->save(); 
                   }else{
                       $existing_return->return = $rawData[$i]['return'];
                       $existing_return->save(); 
                   }
               
               $i++;
               }
            }*/
            }   
            //PortfolioReturns::model()->PortfolioReturnsUpdate($portfolio_id);
        }
        }
    } 
    
//$trade_rate, $trade_currency, 
    public function calculateIinstrumnetReturn($instrument_id, $portfolio_id , $client_id, $portfolio_currency){
        
	   ini_set('max_execution_time', 500000);
                       
       $table_name = "client_".$client_id. "_inst_returns";
                                    
       $prices_sql = "select distinct p.trade_date, p.price*cr.{$portfolio_currency}/curs.cur_rate price, 
                        (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger 
                        	where instrument_id = p.instrument_id and ledger.trade_status_id = 2 and ledger.is_current = 1 and ledger.client_id = '$client_id') nominal,
                        (select sum(if(trade_date=p.trade_date, nominal*price*cr.{$portfolio_currency}/ledger.currency_rate, 0)) from ledger 
                        	where instrument_id = p.instrument_id and ledger.trade_status_id = 2 and ledger.is_current = 1 and ledger.client_id = '$client_id') pnl
                         from prices p
                         inner join currency_rates cr on cr.day = p.trade_date
                         
                         inner join instruments i on i.id = p.instrument_id
                         inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                          
                         where p.is_current = 1 and p.instrument_id = $instrument_id
                         order by p.trade_date asc";
                        
                        //and p.trade_date >='$dt'
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $prices = Yii::app()->db->createCommand($prices_sql)->queryAll(true);
        
        if(count($prices)>0){
            Yii::app()->db->createCommand("delete from {$table_name} where instrument_id = '$instrument_id'")->execute();
            
        $i = 0;
        foreach($prices as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $trade_date = $price['trade_date'];
            $rawData[$i]['price'] = $price['price'];
            $rawData[$i]['nominal'] = $price['nominal'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['return'] = 1;                          
             
             // && $rawData[0]['price'] !== 0
             
            if($i>0){                
                    $div = $rawData[$i-1]['nominal'] * $rawData[$i-1]['price']+ $rawData[$i]['pnl'];
                    
                    if($div>0){$rawData[$i]['return'] = ($rawData[$i]['nominal'] * $rawData[$i]['price'])/$div;
                                }else{$rawData[$i]['return'] = 1;}
                }
                
                $sql = "insert into {$table_name} ({$portfolio_currency}, instrument_id, trade_date) values (:return, :instrument_id, :trade_date)";
                        $parameters = array(":return"=>$rawData[$i]['return'], ':instrument_id' => $instrument_id, ':trade_date' => $rawData[$i]['trade_date']);
                        Yii::app()->db->createCommand($sql)->execute($parameters);
         
            //checking if the return for current instrument is not exist and inserting the calculated return.//
            /*  
            $raturn_sql = "select {$portfolio_currency} from {$table_name} where trade_date = '$trade_date' and instrument_id = '$instrument_id' ";
            $existing_return = Yii::app()->db->createCommand($raturn_sql)->queryAll(true);

                   if(count($existing_return)==0){
                        $sql = "insert into {$table_name} ({$portfolio_currency}, instrument_id, trade_date) values (:return, :instrument_id, :trade_date)";
                        $parameters = array(":return"=>$rawData[$i]['return'], ':instrument_id' => $instrument_id, ':trade_date' => $rawData[$i]['trade_date']);
                        Yii::app()->db->createCommand($sql)->execute($parameters);  
                   }else{ 
                        Yii::app()->db->createCommand()->update($table_name, array("{$portfolio_currency}"=>$rawData[$i]['return']), 'trade_date=:trade_date and instrument_id =:instrument_id',array(':trade_date'=>$rawData[$i]['trade_date'], ':instrument_id' => $instrument_id));
                   }
               */
               $i++;
               }
               //PortfolioReturns::model()->PortfolioReturnsUpdate($portfolio_id, $client_id, $portfolio_currency);
            }
            //if($portfolio_id!==0){
            //    PortfolioReturns::model()->PortfolioReturnsUpdate($portfolio_id, $client_id, $portfolio_currency);
           // }
        
    }  
    
    
}