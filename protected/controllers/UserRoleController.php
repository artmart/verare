<?php

class UserRoleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

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
				'actions'=>array('create','update', 'userrole'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
                'users'=>array('@'),
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
		$model=new UserRole;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UserRole']))
		{
			$model->attributes=$_POST['UserRole'];
          
          //Ledger//   
          $ledger_create = 0; 
          $ledger_edit = 0; 
          $ledger_delete = 0; 
          $ledger_status_change = 0;
          if(isset($_REQUEST["ledger_create"])){$ledger_create = $_REQUEST["ledger_create"]; }
          if(isset($_REQUEST["ledger_edit"])){$ledger_edit = $_REQUEST["ledger_edit"]; }
          if(isset($_REQUEST["ledger_delete"])){$ledger_delete = $_REQUEST["ledger_delete"]; }
          if(isset($_REQUEST["ledger_status_change"])){$ledger_status_change = $_REQUEST["ledger_status_change"]; }
          
          $ledgar_access = ['create'=>$ledger_create, 'edit' =>$ledger_edit, 'delete' =>$ledger_delete, 'status_change'=>$ledger_status_change ];
		  $model->ledger_access_level = json_encode($ledgar_access);
            
          //counterparties// 
          $counterpart_create = 0; 
          $counterpart_edit = 0; 
          $counterpart_delete = 0; 
          //$counterpart_status_change = 0;
          if(isset($_REQUEST["counterpart_create"])){$counterpart_create = $_REQUEST["counterpart_create"]; }
          if(isset($_REQUEST["counterpart_edit"])){$counterpart_edit = $_REQUEST["counterpart_edit"]; }
          if(isset($_REQUEST["counterpart_delete"])){$counterpart_delete = $_REQUEST["counterpart_delete"]; }
          if(isset($_REQUEST["counterpart_status_change"])){$counterpart_status_change = $_REQUEST["counterpart_status_change"]; }
          
          $counterpart_access = ['create'=>$counterpart_create, 'edit' =>$counterpart_edit, 'delete' =>$counterpart_delete /*,  'status_change'=>$counterpart_status_change */];
		  $model->counterparties_access_level = json_encode($counterpart_access);   
            
            
            
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
                $this->redirect(['admin']);
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

		if(isset($_POST['UserRole']))
		{
		  $model->attributes=$_POST['UserRole'];
          
          //Ledger//
          $ledger_create = 0; 
          $ledger_edit = 0; 
          $ledger_delete = 0; 
          $ledger_status_change = 0;
          if(isset($_REQUEST["ledger_create"])){$ledger_create = $_REQUEST["ledger_create"]; }
          if(isset($_REQUEST["ledger_edit"])){$ledger_edit = $_REQUEST["ledger_edit"]; }
          if(isset($_REQUEST["ledger_delete"])){$ledger_delete = $_REQUEST["ledger_delete"]; }
          if(isset($_REQUEST["ledger_status_change"])){$ledger_status_change = $_REQUEST["ledger_status_change"]; }
          
          $ledgar_access = ['create'=>$ledger_create, 'edit' =>$ledger_edit, 'delete' =>$ledger_delete, 'status_change'=>$ledger_status_change ];
		  $model->ledger_access_level = json_encode($ledgar_access);
          
          //counterparties// 
          $counterpart_create = 0; 
          $counterpart_edit = 0; 
          $counterpart_delete = 0; 
          //$counterpart_status_change = 0;
          if(isset($_REQUEST["counterpart_create"])){$counterpart_create = $_REQUEST["counterpart_create"]; }
          if(isset($_REQUEST["counterpart_edit"])){$counterpart_edit = $_REQUEST["counterpart_edit"]; }
          if(isset($_REQUEST["counterpart_delete"])){$counterpart_delete = $_REQUEST["counterpart_delete"]; }
          if(isset($_REQUEST["counterpart_status_change"])){$counterpart_status_change = $_REQUEST["counterpart_status_change"]; }
          
          $counterpart_access = ['create'=>$counterpart_create, 'edit' =>$counterpart_edit, 'delete' =>$counterpart_delete /*,  'status_change'=>$counterpart_status_change */];
		  $model->counterparties_access_level = json_encode($counterpart_access);  
          
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
   	            $this->redirect(['admin']);
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
		$dataProvider=new CActiveDataProvider('UserRole');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UserRole('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserRole']))
			$model->attributes=$_GET['UserRole'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    public function actionUserrole(){
           require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/userrole.php');
    }
    
    

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UserRole the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserRole::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UserRole $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-role-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
