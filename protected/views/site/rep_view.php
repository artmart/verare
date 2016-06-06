<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>-->

<?php 
    $this->pageTitle=Yii::app()->name; 
    $baseUrl = Yii::app()->baseUrl;
    //$id = Yii::app()->user->id;
    //$user_data = Users::model()->findByPk(Yii::app()->user->id);

    $client_id = $user_data->client_id;
    
    $portfolio = 0;
    
    if(isset($user_data->default_portfolio_id) && $user_data->default_portfolio_id>0)
    {
        $portfolio = $user_data->default_portfolio_id;
        }else{
            $accessable_portfolios1 = $user_data->accessable_portfolios;
                    $accessable_portfolios = implode("', '", explode(",", $accessable_portfolios1));
                    $portfolio = $accessable_portfolios[0];
            }
    
   	$end_date = Date('Y-m-d');
	$start_date = date('Y-m-d', strtotime('-1 years'));
    if(isset($user_data->default_start_date) && $user_data->default_start_date!=='0000-00-00'){$start_date = $user_data->default_start_date;}
    if(isset($user_data->default_end_date) && $user_data->default_end_date!=='0000-00-00'){$end_date = $user_data->default_end_date;}
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
        <br />
        <div class="col-sm-2 control-label">Portfolio:</div>
        <div class="col-sm-2">
            <?php
            $ports = Portfolios::model()->findAll(['condition' => 'client_id = :client_id', 'params' => array(':client_id' => $client_id)]);
            
            $list = CHtml::listData($ports,'id','portfolio');
            echo CHtml::dropDownList('portfolio', $portfolio,  $list, [ 'id' => 'portfolio', 'empty' => '-- Select --',  'onchange'=>'overviewload()', 'class'=>"form-control"  /*'multiple' => true, 'size'=>'10'*/]);
            ?>
        </div>
        
        <div class="col-sm-2 control-label">Currency:</div>
        <div class="col-sm-2">
            <?php            
            echo CHtml::dropDownList('currency', 'USD',  CHtml::listData(Currencies::model()->findAll(),'currency','currency'), [ 'id' => 'currency', 'empty' => '-- Select --',  'onchange'=>'overviewload()', 'class'=>"form-control"  /*'multiple' => true, 'size'=>'10'*/]);
            ?>
        </div>
        
        <div class="col-sm-2 control-label">Instrument:</div>
        <div class="col-sm-2">
            <?php            
            echo CHtml::dropDownList('instrument', '',  CHtml::listData(Instruments::model()->findAll(),'id','instrument'), [ 'id' => 'instrument', 'empty' => '-- Select --',  'onchange'=>'overviewload()', 'class'=>"form-control"  /*'multiple' => true, 'size'=>'10'*/]);
            ?>
        </div>

</div>
</form>

<div id="overview-view"></div>
<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;">
    <img src='<?php echo Yii::app()->theme->baseUrl;?>/img/demo_wait.gif' width="64" height="64" /><br>Loading..
</div>

<script>
////////////////////////////////////////////////////
$(document).ready(function ($) {
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
    
        overviewload();
});
//'repview', 'filteredrepview'
    function overviewload(){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/filteredrepview'; ?>',
    			data: {
    			     portfolio:$('#portfolio').val(),
                     start_date:$('#start_date').val(),
                     end_date:$('#end_date').val(),
                     currency:$('#currency').val(),
                     instrument:$('#instrument').val(),
                     client_id: '<?php echo $client_id;?>',
    			},
    			success: function (response) {
    			     $( '#overview-view' ).html(response);
    			}
    		   });
    }
////////////////////////////////////////////////////
</script>	

