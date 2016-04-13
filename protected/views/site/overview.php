<!--
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
-->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>-->

<?php 
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    $this->pageTitle=Yii::app()->name; 
    $baseUrl = Yii::app()->baseUrl;
    
    if(isset($user_data->default_portfolio_id)){$portfolio = $user_data->default_portfolio_id;}
    //if(isset($_POST['portfolio'])){$portfolio = $_POST['portfolio'];}
    
   	$end_date = Date('Y-m-d');
	$start_date = date('Y-m-d', strtotime('-1 years'));
    if(isset($user_data->default_start_date)){$start_date = $user_data->default_start_date;}
    if(isset($user_data->default_end_date)){$end_date = $user_data->default_end_date;}
    //if(isset($_POST['start_date'])){$start_date = date_format(date_create($_POST['start_date']),"Y-m-d");}
    //if(isset($_POST['end_date'])){$end_date = date_format(date_create($_POST['end_date']),"Y-m-d");}
?>

<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->

<?php  ?>          
<form class="form-horizontal">
    <div class="row form-group">
    
        <div class="col-sm-2 control-label">Start Date:</div>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                'name'=>'start_date',
                'id'=>'start_date',
                'value' => $start_date,
                //'language'=>'nl',
                //'attribute'=>'SaleDate',
                //'model'=>$model,
                // additional javascript options for the date picker plugin
                //'cssFile' => 'jquery-ui-1.9.2.custom.css',
                'options'=>['showAnim'=>'fold', 'dateFormat'=>'yy-mm-dd'],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control", 'onChange'=>'overviewload()'],
            ]);
        
        ?>
        </div>
         
        <div class="col-sm-2 control-label">End Date:</div>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                'name'=>'end_date',
                'id'=>'end_date',
                'value' =>$end_date,
                //'language'=>'nl',
                //'attribute'=>'SaleDate',
                //'model'=>$model,
                // additional javascript options for the date picker plugin
                //'cssFile' => 'jquery-ui-1.9.2.custom.css',
                'options'=>['showAnim'=>'fold', 'dateFormat'=>'yy-mm-dd'],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control", 'onChange'=>'overviewload()'],
            ]);
        
        ?>
        </div>
        
        <div class="col-sm-2 control-label">Portfolio:</div>
        <div class="col-sm-2">
            <?php
            $list = CHtml::listData(Portfolios::model()->findAll(['select'=>'id, portfolio', 'order'=>'portfolio']),'id','portfolio');
            echo CHtml::dropDownList('portfolio', $portfolio,  $list, [ 'id' => 'portfolio', 'empty' => '-- Select --',  'onchange'=>'overviewload()', 'class'=>"form-control"  /*'multiple' => true, 'size'=>'10'*/]);
            ?>
        </div>

</div>
</form>

<div id="overview-view"></div>
	
<script>
////////////////////////////////////////////////////
$(document).ready(function ($) {
          overviewload();
          });

    function overviewload(){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/overviewload'; ?>',
    			data: {
    			     portfolio:$('#portfolio').val(),
                     start_date:$('#start_date').val(),
                     end_date:$('#end_date').val()
    			},
    			success: function (response) {
    			     $( '#overview-view' ).html(response);
    			}
    		   });
    }
////////////////////////////////////////////////////
</script>	

