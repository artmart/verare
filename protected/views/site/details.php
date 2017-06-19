<?php 
    $this->pageTitle='Details'; 
    $user_data = Users::model()->findByPk(Yii::app()->user->id);
    $client_id = $user_data->client_id;
    
    $portfolio = 0;
    
    $portfolio = $user_data->default_portfolio_id;
    
    /*
    if(isset($user_data->default_portfolio_id) && $user_data->default_portfolio_id>0)
    {
        $portfolio = $user_data->default_portfolio_id;
        }else{
            $accessable_portfolios1 = $user_data->accessable_portfolios;
                    $accessable_portfolios = implode("', '", explode(",", $accessable_portfolios1));
                    $portfolio = $accessable_portfolios[0];
            }
    */
    $accessable_portfolios2 = $user_data->accessable_portfolios;  
    $accessable_portfolios = implode("', '", explode(",", $accessable_portfolios2));  
            
    $end_date = Date('Y-m-d');
	$start_date = date('Y-m-d', strtotime('-1 years'));
    if(isset($user_data->default_start_date) && $user_data->default_start_date!=='0000-00-00'){$start_date = $user_data->default_start_date;}
    if(isset($user_data->default_end_date) && $user_data->default_end_date!=='0000-00-00'){$end_date = $user_data->default_end_date;}
?>
<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>
<!-- Content Header (Page header) -->
<form class="form-horizontal" id="form_id">
    <div class="row form-group">
    
        <div class="col-sm-2 control-label" style="margin-left: -70px;">Start Date:</div>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                'name'=>'start_date',
                'id'=>'start_date',
                'value' => $start_date,
                //'language'=>'nl',
                //'attribute'=>'SaleDate',
                //'model'=>$model,
                'options'=>['showAnim'=>'fold', 'dateFormat'=>'yy-mm-dd'],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control", 'onChange'=>'resultsload()'],
            ]);
        
        ?>
        </div>
         
        <div class="col-sm-2 control-label" style="margin-left: -70px;">End Date:</div>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                'name'=>'end_date',
                'id'=>'end_date',
                'value' =>$end_date,
                //'language'=>'nl',
                //'attribute'=>'SaleDate',
                //'model'=>$model,
                'options'=>['showAnim'=>'fold', 'dateFormat'=>'yy-mm-dd'],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control", 'onChange'=>'resultsload()'],
            ]);
        
        ?>
        </div>
       
        <div class="col-sm-2 control-label" style="margin-left: -70px;">Portfolio:</div>
        <div class="col-sm-3">
            <?php       
            //$ports = Portfolios::model()->findAll(['condition' => 'client_id = :client_id',  'params' => array(':client_id' => $client_id)]);            
            $ports_sql = "select id, portfolio from portfolios where id in ('$accessable_portfolios') and client_id = '$client_id'";
            $ports = Yii::app()->db->createCommand($ports_sql)->queryAll(true);
            
            $list = CHtml::listData($ports,'id','portfolio');
            echo CHtml::dropDownList('portfolio', $portfolio,  $list, [ 'id' => 'portfolio', 'empty' => '-- Select --',  'onchange'=>'resultsload()', 'class'=>"form-control"  /*'multiple' => true, 'size'=>'10'*/]);
            ?>
        </div>
</div>
</form>

<section class="content-header">
  <h1 class="span1">Details</h1>
</section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolios/Instruments</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
								
                <div class="box-body">
                
                <div id="results-view"></div>
                <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo Yii::app()->theme->baseUrl;?>/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>

                </div><!-- ./box-body -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>	
<script>
$(document).ready(function ($) {
    
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });
          
    resultsload();
});

function resultsload(){
$.ajax({
		type: 'post',
		url: '<?php echo Yii::app()->baseUrl.'/site/resultsload'; ?>',
		data: {
		     portfolio:$('#portfolio').val(),
             start_date:$('#start_date').val(),
             end_date:$('#end_date').val(),
             client_id: '<?php echo $client_id;?>',
             accessable_portfolios2: '<?php echo json_encode($accessable_portfolios2); ?>',
		},
		success: function (response) {
		     $( '#results-view' ).html(response);
		}
	   });
}
</script>	