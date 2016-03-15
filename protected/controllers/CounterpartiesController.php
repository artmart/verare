<?php

class CounterpartiesController extends Controller
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
				'actions'=>array('create','update', 'counterparties'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
                'users'=>array('@'),
				//'users'=>array('admin'),
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
		$model=new Counterparties;
        $path = Yii::getPathOfAlias('webroot').'/uploads/';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Counterparties']))
		{
			$model->attributes=$_POST['Counterparties'];
			
            if($upload_file=self::uploadMultifile($model,'documents', $path))
               {$model->documents = implode(",", $upload_file);}
            
            if($model->save())
			$this->redirect(array('view','id'=>$model->id));
		}
  
		$this->render('create',['model'=>$model]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $path = Yii::getPathOfAlias('webroot').'/uploads/';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Counterparties']))
		{
			$model->attributes=$_POST['Counterparties'];
            if($upload_file=self::uploadMultifile($model,'documents', $path))
               {$model->documents = implode(",", $upload_file);}
            
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

        $mm = explode(",", $model->documents);
        $model->documents = $mm;
		$this->render('update',['model'=>$model]);
	}
    
    
    //Function for uploading and saving Multiple files
    public function uploadMultifile($model,$attr,$path)
    {
    /*
     * path when uploads folder is on site root.*/
    $path='../../uploads/';
     
    if($sfile=CUploadedFile::getInstances($model, $attr)){

      foreach ($sfile as $i=>$file){  

        $formatName=time().$i.'.'.$file->getExtensionName();
        $fileName = "{$sfile[$i]}";
         $formatName=time().$i.'_'.$fileName;
         //$formatName=$fileName;
         $file->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$formatName);
         $ffile[$i]=$formatName;
         }
        return ($ffile);
       }
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
		$dataProvider=new CActiveDataProvider('Counterparties');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 
	public function actionAdmin()
	{
		$model=new Counterparties('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Counterparties']))
			$model->attributes=$_GET['Counterparties'];

		$this->render('admin',array('model'=>$model,));
	}
    */
    
    public function actionCounterparties(){
           require_once(Yii::app()->basePath . '/extensions/editor_datatables/php/counterparties.php');
    }
    
    public function actionAdmin()
	{
		$this->render('admin_datatable');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Counterparties the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Counterparties::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Counterparties $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='counterparties-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
