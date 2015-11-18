<?php

class UploadsController extends Controller
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
			//	'users'=>array('*'),
            'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
			//	'users'=>array('@'),
                'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view', 'create', 'admin','delete'),
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
     /*
	public function actionCreate()
	{
		$model=new Uploads;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Uploads']))
		{
			$model->attributes=$_POST['Uploads'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    */
    
 	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Uploads;
        //$path = Yii::app()->basePath.'../../uploads/';
        $path = Yii::getPathOfAlias('webroot').'/uploads/';

		if(isset($_POST['Uploads']))
		{
            $model->attributes=$_POST['Uploads'];
            if($upload_file=self::uploadMultifile($model,'upload_file', $path))
               {$model->upload_file = implode(",", $upload_file);}
			
            $model->user_id = Yii::app()->user->id;
            $instrument_id = $model->instrument_id;
            //////////////////////////////////////////
            if($model->validate()){
                //Upload File // 
                if($model->save()){
                    $upload_file_id = Yii::app()->db->getLastInsertID();
                
                $csvFile=CUploadedFile::getInstance($model,'upload_file', '../../uploads/');  
                $tempLoc=Yii::getPathOfAlias('webroot').'/uploads/'.$model->upload_file;
                

                  $sql="LOAD DATA LOCAL INFILE '".$tempLoc."'
                        INTO TABLE `prices` FIELDS TERMINATED BY ';' ENCLOSED BY '' LINES TERMINATED BY '\n' IGNORE 0 LINES 
                        (`trade_date`, `price`)
                        SET `upload_file_id` = '$upload_file_id', `instrument_id` = '$instrument_id'";
                        
                    $connection=Yii::app()->db;
                    $transaction=$connection->beginTransaction();
                        try
                            {
                                $connection->createCommand($sql)->execute();
                                $transaction->commit();
                            }
                            catch(Exception $e) // an exception is raised if a query fails
                             {
                                print_r($e);
                                exit;
                                $transaction->rollBack();
                             }
                  unlink(Yii::getPathOfAlias('webroot').'/uploads/'.$model->upload_file); 
        
                  $this->redirect(array('view','id'=>$model->id)); 
                  }                
                }
            ///////////////////////////////////////////            	
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
    
    
    
     //Function for uploading and saving Multiple files
    public function uploadMultifile ($model,$attr,$path)
    {
    /*
     * path when uploads folder is on site root.*/
    $path='../../uploads/';
     
    if($sfile=CUploadedFile::getInstances($model, $attr)){

      foreach ($sfile as $i=>$file){  

        $formatName=time().$i.'.'.$file->getExtensionName();
        $fileName = "{$sfile[$i]}";
         $formatName=time().$i.'_'.$fileName;
         $formatName=$fileName;
         $file->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$formatName);
         $ffile[$i]=$formatName;
         }
        return ($ffile);
       }
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

		if(isset($_POST['Uploads']))
		{
			$model->attributes=$_POST['Uploads'];
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
	    $model=$this->loadModel($id);
        
            Prices::model()->deleteAll('upload_file_id =:upload_file_id', array('upload_file_id' => $id));
                
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
		$dataProvider=new CActiveDataProvider('Uploads');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Uploads('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Uploads']))
			$model->attributes=$_GET['Uploads'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Uploads the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Uploads::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Uploads $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='uploads-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
