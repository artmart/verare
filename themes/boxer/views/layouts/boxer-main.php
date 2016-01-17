<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Verare</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="">
        <meta name="description" content="Verare">
        <meta name="author" content="Artak Martirosyan">
        
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  //$cs = Yii::app()->getClientScript();
	  //Yii::app()->clientScript->registerCoreScript('jquery');
	?>

		<!-- animate css -->
		<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/animate.min.css">
		<!-- bootstrap css -->
		<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/bootstrap.min.css">
		<!-- font-awesome -->
		<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/font-awesome.min.css">
		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css'>

		<!-- custom css -->
		<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/templatemo-style.css">
        
		<script src="<?php echo $baseUrl;?>/js/jquery.js"></script>
		<script src="<?php echo $baseUrl;?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $baseUrl;?>/js/wow.min.js"></script>
		<script src="<?php echo $baseUrl;?>/js/jquery.singlePageNav.min.js"></script>
		<script src="<?php echo $baseUrl;?>/js/custom.js"></script>

	</head>
	<body>
<?php echo $content; ?>
<!-- start footer -->
    	<footer>
			<div class="container">
				<div class="row">
                    <a href="http://www.verare.se" title="Verare" target="_new">Copyright &copy 2015 - <?php echo date("Y") ;?> Verare AB</a>
				</div>
			</div>
		</footer>
<!-- end footer -->
        
	</body>
</html>