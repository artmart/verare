<?php

class PricesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'allStats', 'return', 'returnCalculation', 'allReturns', 'instrumentReturnUpdate', 'portfolioReturns' ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Prices;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Prices']))
		{
			$model->attributes=$_POST['Prices'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
   	public function actionReturn()
	{
	    $this->layout='column1';
		$this->render('return');
	}
    
    
    public function actionAllStats()
	{
	    $this->layout='column1';
		$this->render('all_stats');
	}
    
    
    public function actionAllReturns()
	{
	   $this->layout='column1';
        
        
       // var_dump($_POST);
       // exit;
        $instrument = '';
        $dt = '';

        if(isset($_REQUEST['instrument']) && !($_REQUEST['instrument'] == '')){
            $instrument = $_REQUEST['instrument'];
            }
        if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){
            $dt = $_REQUEST['dt'];
            }
            
		$this->render('all_returns', ['instrument' => $instrument, 'dt' => $dt]);
       
    }
    
    
    public function actionPortfolioReturns()
	{
	   $this->layout='column1';

        $portfolio_id = '';
        $dt = '';
        $where = ' 1 = 1 ';
    
        if(isset($_REQUEST['portfolio']) && !($_REQUEST['portfolio'] == '')){$portfolio_id = $_REQUEST['portfolio'];}

        
        if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and p.trade_date >='$dt' "; }

        //if(isset($_REQUEST['portfolio']) && !($_REQUEST['portfolio'] == '')){$portfolio_id = $_REQUEST['portfolio'];}
        //if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt'];}
       ///////////////////////////////////////////////////////////////////////////////////     
        if($portfolio_id >0){
            ini_set('max_execution_time', 50000);
        //Trades
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     where l.is_current = 1 and i.is_current = 1 and l.portfolio_id = $portfolio_id  order by trade_date asc";
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
        
        foreach($trades as $trd){$ins_ids[] = $trd['instrument_id'];} 
        
        $insids = implode("','", $ins_ids);          
                        
        $portfolio_return_sql = "select p.trade_date,
                                sum((select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id)) pnl,
                                sum(p.price * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id)) top
                                from prices p
                                where p.is_current = 1 and instrument_id in ('$insids') and " . $where .  
                                " group by  p.trade_date
                                order by p.trade_date asc";
        $portfolio_returns = Yii::app()->db->createCommand($portfolio_return_sql)->queryAll(true);
        
        if(count($portfolio_returns)>0){
        $i = 0;
        foreach($portfolio_returns as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $rawData[$i]['top'] = $price['top'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['return'] = 1;                          
             
            if($i>0){        
                    $div = $rawData[$i-1]['top'] + $rawData[$i]['pnl'];
                    
                    if($div>0){
                        $rawData[$i]['return'] = $rawData[$i]['top']/$div;
                    }else{
                        $rawData[$i]['return'] = 1;
                    }
               }
         
              //checking if the return for current instrument is not exist and inserting the calculated return.//
               $existing_return  = PortfolioReturns::model()->findByAttributes(['portfolio_id'=>$portfolio_id, 'trade_date' =>$rawData[$i]['trade_date'], 'is_prtfolio_or_group' =>1]);
                   if(count($existing_return)==0){
                       $return = new PortfolioReturns;
                       $return->portfolio_id = $portfolio_id;
                       $return->is_prtfolio_or_group = 1;
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['return'];
                       $return->save(); 
                   }else{
                           $existing_return->return = $rawData[$i]['return'];
                           $existing_return->save(); 
                        }
               $i++;
               }     
          }else{
            ///portfolio return is empty////
          }  
        }else{
            ///treades are not found//
        }
        }    
        
        $this->redirect('portfolioReturns/admin');

             
            
        ///////////////////////////////////////////////////////////////////////////////////    
	//	$this->render('portfolio_returns', ['portfolio' => $portfolio, 'dt' => $dt]);
       
    }
    
    
    
    
    
    
    public function actionInstrumentReturnUpdate($id)
	{
	   $instrument_id = $id;
	   ini_set('max_execution_time', 50000);
       
        //Trades
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     where l.is_current = 1 and i.is_current = 1 and i.id = $instrument_id order by trade_date, l.instrument_id asc";
                     
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
            $prices = Yii::app()->db->createCommand("select trade_date, price from prices where is_current = 1 and instrument_id = $instrument_id order by trade_date asc")->queryAll(true);
        
        if(count($prices)>0){
        
        $i = 0;
        foreach($prices as $pr ){
            $td= $pr['trade_date'];
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $td;
            
            $amount_portfolio[$i] = 0; 
            $amount_traded[$i] = 0; 
            $amount_nominal[$i] = 0;
            $porfolio_amount[$i] = 0;
            
            foreach($trades as $trade){
                $rawData[$i]['nominal'] = 0;
                $rawData[$i]['pnl'] = 0;
                if($i==0){
                        $rawData[$i]['return'] = 1;
                        if(strtotime($trade['trade_date']) > strtotime($rawData[0]['trade_date'])){
                            $rawData[$i]['amount'] = $trade['nominal'] * $trade['price'];                    
                        }else{$rawData[$i]['amount'] = 0;}
                        }
                
                $nom_pl_sql = "select sum(if(trade_date<='$td', nominal, 0)) nominal, sum(if(trade_date='$td', nominal*price, 0)) pnl from ledger where instrument_id = '$instrument_id'";    
                $nom_pl = Yii::app()->db->createCommand($nom_pl_sql)->queryAll(true);
                
                $rawData[$i]['nominal'] = $nom_pl[0]['nominal'];
                $rawData[$i]['pnl'] = $nom_pl[0]['pnl'];
                
                $rawData[$i]['price'] = $pr['price'];
                $rawData[$i]['chart'] = 1;
                if($i>0 && !($rawData[0]['price'] == 0)){
                        $rawData[$i]['chart'] = $rawData[$i]['price']/$rawData[0]['price'];      
                    }
      
                if($i>0){ 
                    $div = $rawData[$i-1]['nominal'] * $rawData[$i-1]['price']+ $rawData[$i]['pnl'];
                    
                    if($div>0){
                        $rawData[$i]['return'] = ($rawData[$i]['nominal'] * $rawData[$i]['price'])/$div;
                    }else{
                        $rawData[$i]['return'] = 1;
                    }
                }
                        $porfolio_amount[$i] = $porfolio_amount[$i] + $rawData[$i]['nominal'] * $rawData[$i]['price'];
                        $amount_traded[$i] = $amount_traded[$i] + $rawData[$i]['pnl'];
        

               
               }
               
               
                      //checking if the return for current instrument is not exist and inserting the calculated return.//
              
              
              $existing_return  = Prices::model()->findByAttributes(['instrument_id'=>$instrument_id, 'trade_date' =>$td, 'nominal' => 0]);
                   if(!($existing_return->nominal >0)){
                    $existing_return->nominal = $rawData[$i]['nominal'];
                    $existing_return->pnl = $rawData[$i]['pnl'];
                    $existing_return->return = $rawData[$i]['return'];
                    $existing_return->chart_return = $rawData[$i]['chart'];
                   // $existing_return->save();

        echo " Nominal-> ". $existing_return->nominal . " - pnl -> " .  $existing_return->pnl . " -  Return -> " .  $existing_return->return . " - chart->  " . $existing_return->chart_return . "<br/>";
                  
               
                       //$return = new Returns;
                       /*
                       
                        Yii::app()->dbstore->createCommand()->update('oc_category', array('date_modified'=>$date_modified,'parent_id'=> $parent_id), 'category_id=:category_id',array(':category_id'=>$category_id));
    
                       $return->instrument_id = $trade['instrument_id'];
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['ret_'.$trade['instrument_id']];
                       $return->save(); 
                       */
                  }       
               
               
                
                //////////////////Portfolio calculation////////////////////
                /*
                    if($i == 0){
                        $rawData[$i]['portfolio'] = 1;
                    }else{   
                        //$dev1 = $amount_nominal[$i-1] * $rawData[$i-1][$column] + $amount_traded[$i];
                        $dev1 = $porfolio_amount[$i-1] + $amount_traded[$i];
                        if($dev1 >0){
                            $rawData[$i]['portfolio'] = ($porfolio_amount[$i])/$dev1;
                       // if(($amount_portfolio[$i-1]+$amount_traded[$i])>0){
                        //$rawData[$i]['portfolio'] = $amount_portfolio[$i]/($amount_portfolio[$i-1]+$amount_traded[$i]);                
                        }else{
                            $rawData[$i]['portfolio'] = 1;
                        }
                    }
                */
                //////////////////////////////////////////////////////////
            $i++;
        }
       
       
     }  
       
       
	//    $this->layout='column1';
	//	$this->render('all_returns');
	}
    }
    
        
    public function actionReturnCalculation()
	{
	    $this->layout='column1';
        
        $instrument = '';

        if(isset($_REQUEST['instrument']) && !($_REQUEST['instrument'] == '')){
            $instrument = $_REQUEST['instrument'];
            }
        
		$this->render('return_calculation', ['instrument' => $instrument]);
	}
    

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Prices']))
		{
			$model->attributes=$_POST['Prices'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Prices');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Prices('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prices']))
			$model->attributes=$_GET['Prices'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Prices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Prices::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Prices $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='prices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
