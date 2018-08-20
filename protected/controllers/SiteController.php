<?php
class SiteController extends Controller
{
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
				'actions'=>array('index', 'error', 'login', 'logout'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'resultsload', 'instrumentsresultsload', 'overviewload', 'details', 'admin', 'repview', 'filteredrepview', 'pdf' ),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				//'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    //////////////////////////////////////////////////
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
	    Yii::app()->theme = 'boxer';
	    $this->layout='boxer-main';
		$this->render('index');
	}
    
    
    public function actionPdf()
    {
      //  echo "OK";
     //   exit;
             //   $user_data = Users::model()->findByPk(Yii::app()->user->id);
        
        $client_id = 0;// $user_data->client_id;
    
        $portfolio = 0;
       //  $accessable_portfolios2 = $user_data->accessable_portfolios;  
    //$accessable_portfolios = implode("', '", explode(",", $accessable_portfolios2));
    //     if(isset($user_data->default_portfolio_id) && $user_data->default_portfolio_id>0){ $portfolio = $user_data->default_portfolio_id;}else{$portfolio = $accessable_portfolios[0];}
   
        $end_date = Date('Y-m-d');
	    $start_date = date('Y-m-d', strtotime('-1 years'));
        $start_date = '2017-01-01';  $end_date = '2018-02-01'; 
        if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
        if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date']; }
        if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
        if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}

      $path = "http://verare.se/site/admin?start_date=$start_date&end_date=$end_date&portfolio=$portfolio&client_id=$client_id";
      
      $d =  str_replace('\\', '/', Yii::app()->basePath ).'/extensions/wkhtmltox';

      
        error_reporting(0);       
        
        $outfilename = '/uploads/' . uniqid(rand(), true) . '.pdf';
        
        //$cmd = 'c:\Winutil\wkhtmltopdf\bin\wkhtmltopdf.exe --viewport-size 1024x768 "file:///C:/proyectos/mortensen/globalCAD/web/tool_' . $tool . '.html?data=' . $data . '" "' . $outfilename . '"';
        //$cmd = '/var/www/knowledgeonlineplatform.com/wkhtmltox/bin/wkhtmltopdf --viewport-size 1024x768 --javascript-delay 800 "http://www.knowledgeonlineplatform.com/tool_' . $tool . '.php?tool=' . $tool . '&pages=' . $pages . '&data=' .$data . '" "' . $outfilename . '"';
        // nota: para dar más tiempo al javascript: --javascript-delay 400
        //$cmd = '/var/www/knowledgeonlineplatform.com/wkhtmltox/bin/wkhtmltopdf --zoom 0.6 --no-stop-slow-scripts --javascript-delay 800 "http://www.knowledgeonlineplatform.com/tool_' . $tool . '.php?tool=' . $tool . '&pages=' . $pages . '&data=' .$data . '" "' . $outfilename . '"';
        $cmd = 'xvfb-run '.$d.'/bin/wkhtmltopdf --use-xserver --no-stop-slow-scripts --javascript-delay 800 "'. $path . '" "' . $outfilename . '"';
        
        shell_exec($cmd);
        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=report.pdf");
        readfile($outfilename);
        unlink($outfilename);
        
        
        
        /*
        require_once 'vendor/autoload.php';
        
                $user_data = Users::model()->findByPk(Yii::app()->user->id);
        
            $client_id = 9;// $user_data->client_id;
    
        $portfolio = 48;
       //  $accessable_portfolios2 = $user_data->accessable_portfolios;  
    //$accessable_portfolios = implode("', '", explode(",", $accessable_portfolios2));
    //     if(isset($user_data->default_portfolio_id) && $user_data->default_portfolio_id>0){ $portfolio = $user_data->default_portfolio_id;}else{$portfolio = $accessable_portfolios[0];}
   
      //  $end_date = Date('Y-m-d');
	    //   $start_date = date('Y-m-d', strtotime('-1 years'));
        $start_date = '2017-01-01';  $end_date = '2018-02-01'; 
     //   if(isset($_REQUEST['start_date'])){$start_date = '2017-01-01'; //$_REQUEST['start_date'];
     //   }
      //  if(isset($_REQUEST['end_date'])){$end_date = '2018-02-01'; //$_REQUEST['end_date'];
     //   }
       // if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
      //  if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}
        
   
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($this->renderPartial('overview_filter', ['start_date'=>$start_date, 'end_date'=>$end_date, 'portfolio' =>$portfolio, 'client_id' =>$client_id ], true));
        $mpdf->Output();
                
/*        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
//        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

        # render (full page)
//        $mPDF1->WriteHTML($this->render('index', array(), true));

        # Load a stylesheet
//        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
//        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('overview_filter', array(), true));

        # Renders image
//        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));

        # Outputs ready PDF
        $mPDF1->Output();

        ////////////////////////////////////////////////////////////////////////////////////
/*
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('index', array(), true));
        $html2pdf->Output();

        ////////////////////////////////////////////////////////////////////////////////////

        # Example from HTML2PDF wiki: Send PDF by email
        $content_PDF = $html2pdf->Output('', EYiiPdf::OUTPUT_TO_STRING);
        require_once(dirname(__FILE__).'/pjmail/pjmail.class.php');
        $mail = new PJmail();
        $mail->setAllFrom('webmaster@my_site.net', "My personal site");
        $mail->addrecipient('mail_user@my_site.net');
        $mail->addsubject("Example sending PDF");
        $mail->text = "This is an example of sending a PDF file";
        $mail->addbinattachement("my_document.pdf", $content_PDF);
        $res = $mail->sendmail();
*/
    }
    
    
    
    
    public function actionResultsload()
	{
		$this->renderPartial('details_portfolio_types');
	}
    
    public function actionInstrumentsresultsload()
	{
		$this->renderPartial('details_instruments');
	}
    
    public function actionOverviewload()
	{
		$this->renderPartial('overview_filter');
	}
    
    public function actionRepview()
	{
	   $this->layout='main';

        $user_data = Users::model()->findByPk(Yii::app()->user->id);
        $step_completed = $user_data->step_completed;

        if($user_data->user_role == 2 && $step_completed < 5){
            $this->render('start', ['step_completed' =>$step_completed]);
        
        
        }else{ $this->render('rep_view', ['user_data' => $user_data]); }
       
       
		//$this->renderPartial('rep_view');
	}
    
    public function actionFilteredrepview()
	{
		$this->renderPartial('rep_view_filter');
	}
    
    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionDetails()
	{
	    $this->layout='main';
	    
        $user_data = Users::model()->findByPk(Yii::app()->user->id);
        $step_completed = $user_data->step_completed;

        if($user_data->user_role == 2 && $step_completed < 5){
            $this->render('start', ['step_completed' =>$step_completed]);
        }else{ $this->render('details'); }	
	} 
    
    public function actionAdmin()
	{
	    $this->layout='main';

        $user_data = Users::model()->findByPk(Yii::app()->user->id);
        $step_completed = $user_data->step_completed;

        if($user_data->user_role == 2 && $step_completed < 5){
            $this->render('start', ['step_completed' =>$step_completed]);
        }else{ $this->render('overview', ['user_data' => $user_data]); }
	} 
      
    public function actionOverviewLoad1()
	{
		$this->render('overview_load');
	} 
    
    public function my_date_format($tradeDate,$alpha)
    {
        $tmp=date_create($tradeDate);
        date_modify($tmp, $alpha);
        return date_format($tmp, "Y-m-d");
    }

    public function actionSparklines()
	{
		$this->render('sparklines');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
	   //Yii::app()->theme = 'abound';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}