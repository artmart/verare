
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Verare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verare">
    <meta name="author" content="Artak Martirosyan">
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	<?php  
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
      
      $cs->registerCssFile($baseUrl.'/css/animate.min.css');
      $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
      $cs->registerCssFile($baseUrl.'/css/templatemo-style.css');
      
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
	  ?>
      <!-- styles for style switcher -->
        <!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl;?>/datatables/media/css/jquery.dataTables.css" />-->
        <!--<link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />-->
        <!-- animate css 
		<link rel="stylesheet" href="<?php //echo $baseUrl;?>/css/animate.min.css">-->
		<!-- bootstrap css 
		<link rel="stylesheet" href="<?php //echo $baseUrl;?>/css/bootstrap.min.css">-->
		<!-- font-awesome 
		<link rel="stylesheet" href="<?php //echo $baseUrl;?>/css/font-awesome.min.css">-->
		<!-- google font 
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'>-->
		<!-- custom css 
		<link rel="stylesheet" href="<?php //echo $baseUrl;?>/css/templatemo-style.css">-->

	  <?php
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/charts.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
      //$cs->registerScriptFile($baseUrl.'/datatables/media/js/jquery.dataTables.min.js');
      $cs->registerScriptFile($baseUrl.'/js/wow.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/jquery.singlePageNav.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/custom.js');
	?>
  </head>
<body>

<section id="navigation-main">   
<!-- Require the navigation -->
<?php require_once('tpl_navigation.php')?>
</section><!-- /#navigation-main -->
    
<section class="main-body">
    <div class="container-fluid">
            <!-- Include content pages -->
            <?php echo $content; ?>
    </div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>

  </body>
</html>