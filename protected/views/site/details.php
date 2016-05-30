<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 class="span1">Details</h1>
</section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolios</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
				
                <div class="box-body">
                <div id="results-view"></div>
                <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo Yii::app()->theme->baseUrl;?>/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>

            
                 <!-- <div class="row">-->
                    <div class="col-md-12">
					

					  
                    </div><!-- /.col -->
       
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
    			//media_type:$('#media_type').val(),
                //supermarket_bar:$('#supermarket_bar').val(),
                //dt: n - $('#sel_Period1').val()+"-"+$('#sel_Period2').val(), 'show_queries':show_queries
    			},
    			success: function (response) {
    			     $( '#results-view' ).html(response);
    			}
    		   });
    }


    function instrumentsresultsload(){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/instrumentsresultsload'; ?>',
    			data: {
    			//media_type:$('#media_type').val(),
                //supermarket_bar:$('#supermarket_bar').val(),
                //dt: n - $('#sel_Period1').val()+"-"+$('#sel_Period2').val(), 'show_queries':show_queries
    			},
    			success: function (response) {
    			     $( '#results-view' ).html(response);
    			}
    		   });
    } 
</script>	

