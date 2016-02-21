<?php

class PortfolioReturnsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('create','update', 'portfolioReturnsCalc'),
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
    
    public function actionPortfolioReturnsCalc()
	{
	   $this->layout='column1';

        $portfolio_id = '';
        $dt = '';
        $where = ' 1 = 1 ';
    
        if(isset($_REQUEST['portfolio']) && !($_REQUEST['portfolio'] == '')){$portfolio_id = $_REQUEST['portfolio'];}
        if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and p.trade_date >='$dt' "; }
  
        if($portfolio_id >0){
            ini_set('max_execution_time', 50000);
        //Trades
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     where l.is_current = 1 and i.is_current = 1 and l.portfolio_id = $portfolio_id  order by trade_date asc";
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        if(count($trades)>0){
        
        foreach($trades as $trd){$ins_ids[] = $trd['instrument_id'];} 
        
        $insids = implode("','", array_unique($ins_ids));          
                        
        $portfolio_return_sql = "select p.trade_date,
                                sum((select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id)) pnl,
                                sum(p.price * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id)) top
                                from prices p
                                where p.is_current = 1 and instrument_id in ('$insids') and " . $where .  
                                " group by  p.trade_date
                                order by p.trade_date asc";
                                
        //echo $portfolio_return_sql;
        //exit;
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
                    }//else{
                       // $rawData[$i]['return'] = 1;
                   // }
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
            Yii::app()->user->setFlash('notice', "Prices not fount.");
            //Yii::app()->user->setFlash('success', "Data1 saved!");
            //Yii::app()->user->setFlash('error', "Data2 failed!");        
            
            
          }  
        }else{
            ///treades are not found//
            Yii::app()->user->setFlash('notice', "Ledgar information not found.");
        }
        }    
        Yii::app()->user->setFlash('success', "Portfolio returns updated.");
        $this->redirect('admin');       
    }
    
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PortfolioReturns;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PortfolioReturns']))
		{
			$model->attributes=$_POST['PortfolioReturns'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['PortfolioReturns']))
		{
			$model->attributes=$_POST['PortfolioReturns'];
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
		$dataProvider=new CActiveDataProvider('PortfolioReturns');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PortfolioReturns('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PortfolioReturns']))
			$model->attributes=$_GET['PortfolioReturns'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PortfolioReturns the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PortfolioReturns::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PortfolioReturns $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='portfolio-returns-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
