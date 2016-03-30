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
      //Yii::app()->clientScript->registerCoreScript('jquery.ui'); 
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	
    <?php   
	  //$cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
      $cs->registerCssFile($baseUrl.'/css/templatemo-style.css');
      $cs->registerCssFile($baseUrl.'/css/AdminLTE.min.css');
      $cs->registerCssFile($baseUrl.'/css/animate.min.css');
      $cs->registerCssFile($baseUrl.'/css/ionicons.min.css');
      $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  //$cs->registerCssFile($baseUrl.'/css/abound.css');
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
      $cs->registerCssFile($baseUrl.'/js/plugins/jQueryUI/jquery-ui.min.css');
      $cs->registerCssFile($baseUrl.'/css/tools/TableTools.css');
      $cs->registerCssFile($baseUrl.'/css/tools/buttons.dataTables.min.css');
      $cs->registerCssFile($baseUrl.'/css/tools/select.dataTables.min.css');
      $cs->registerCssFile($baseUrl.'/editor_datatables/css/editor.dataTables.min.css');
      $cs->registerCssFile($baseUrl.'/editor_datatables/examples/resources/syntax/shCore.css');
      $cs->registerCssFile($baseUrl.'/css/tools/dataTables.bootstrap.min.css');
      $cs->registerCssFile($baseUrl.'/css/tools/buttons.bootstrap.min.css');
      $cs->registerCssFile($baseUrl.'/css/tools/select.bootstrap.min.css');
      $cs->registerCssFile($baseUrl.'/css/editor.bootstrap.min.css');
      $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');
      $cs->registerCssFile($baseUrl.'/css/tools/dataTables.fontAwesome.css');
	  ?>
   
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
        

  
        
        
  	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    
    
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/js/TableTools.min.js"></script>
    
    
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.bootstrap.min.js"></script>
    
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.1.0/js/dataTables.select.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.editor.min.js"></script>

    
    
	<script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/examples/resources/syntax/shCore.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.colVis.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/dataTables.buttons.min.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/buttons.html5.min.js"></script>
    
    <script type="text/javascript" language="javascript" src="<?php echo $baseUrl;?>/editor_datatables/js/buttons.colVis.min.js"></script>
       
    <?php     
      $cs->registerScriptFile($baseUrl.'/js/plugins/highcharts.js');
      $cs->registerScriptFile($baseUrl.'/js/plugins/data.js');
      $cs->registerScriptFile($baseUrl.'/js/plugins/drilldown.js');
        
      //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.dataTables.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/plugins/drilldown.js');
      //$cs->registerScriptFile($baseUrl.'/js/plugins/drilldown.js');
      //$cs->registerScriptFile($baseUrl.'/js/plugins/drilldown.js');
      //$cs->registerScriptFile($baseUrl.'/js/plugins/drilldown.js');
        
      //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      //$cs->registerScriptFile($baseUrl.'/editor_datatables/js/buttons.colVis.min.js');
      
      $cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js');
      $cs->registerScriptFile($baseUrl.'/js/app.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/charts.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
      //$cs->registerScriptFile($baseUrl.'/datatables/media/js/jquery.dataTables.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/dataTables.foundation.min.js');
      $cs->registerScriptFile($baseUrl.'/js/plugins/dataTables.jqueryui.min.js');
	  //$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.dataTables.min.js');
      //$cs->registerScriptFile($baseUrl.'/js/plugins/dataTables.bootstrap.min.js');
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
<br />
<br />
<br />
<br />   
<section class="main-body">
<div class="row-fluid">
    <div class="container">
            <!-- Include content pages -->
            <?php echo $content; ?>
    </div>
</div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>

  </body>
</html>