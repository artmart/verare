<?php 
    $baseUrl = Yii::app()->baseUrl;
     
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}
    if(isset($_REQUEST['currency'])){$currency = $_REQUEST['currency'];}
    if(isset($_REQUEST['instrument'])){$instrument = $_REQUEST['instrument'];}
        
    $table_name = "client_".$client_id. "_inst_returns";
    
    $query = "select cr.day, cr.{$currency} currency, ir.{$currency} instrument_return, pr.`return` portfolio_return, pr.benchmark_return  from currency_rates cr
                left join {$table_name} ir on ir.trade_date = cr.day
                left join portfolio_returns pr on pr.trade_date = cr.day
                where cr.day >= '$start_date' and cr.day<='$end_date'
                and pr.portfolio_id = '$portfolio'";
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
    $results = Yii::app()->db->createCommand($query)->queryAll(true);
?>

<h3><i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->
<section class="content-header">
<?php     
    $table_rows = '';  
    $months = [];  
    $series = [];
    
        foreach($results as $res){
           $table_rows .= '<tr>
    						<td>'.$res['day'].'</td>
    						<td>'.number_format($res['currency'], 15).'</td>
    						<td>'.number_format($res['instrument_return'], 7).'</td>
    						<td>'.number_format($res['portfolio_return'], 7).'</td>
                            <td>'.number_format($res['benchmark_return'], 7).'</td>
    					  </tr>';
                           
           $months[] = $res['day'];               
           $currency_data[] = [$res['day'], floatval($res['currency'])];
           $instrument_return_data[] = [$res['day'], floatval($res['instrument_return'])];
           $portfolio_return_data[] = [$res['day'], floatval($res['portfolio_return'])];
        } 
     
    $series[] = ['name'=> 'Currency', 'data'=> $currency_data];
    $series[] = ['name'=> 'Instrument Return', 'data'=> $instrument_return_data]; 
    $series[] = ['name'=> 'Portfolio Return', 'data'=> $portfolio_return_data]; 
        
    //$level1[] = array('name' => $sp2['portfolio'], 'y' => $sp2['nav']*100/$index_value);  
?>
</section>

        <!-- Main content -->
        <section class="content">
			  
          <div class="row">
            <div class="col-md-12">
              <div class="box box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolio Composition</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                 <!-- <div class="row">-->
                    <div class="col-md-12">
					
                      <div class="chart">
					       <div class="scrollit">
						  <table id="example1" class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>Date</th>
								<th>Currency rate</th>
								<th>Instrument Return</th>
								<th>Portfolio Return</th>
                                <th>Benchmark Return</th>
							  </tr>
							</thead>
							<tbody>
                              <?php echo $table_rows;?>
							<tbody>
						  </table>
						</div>	  
                      </div><!-- /.chart-responsive -->
					  
                    </div><!-- /.col -->
					
          <!--          <div class="col-md-4">    -->          

<div id="container1" ></div>
<script>
$(function () {
    $('#container1').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: '' // 'Snow depth at Vikjafjellet, Norway'
        },
        subtitle: {
            text: '' // 'Irregular time data in Highcharts JS'
        },
        xAxis: {
            type: 'datetime',
            minTickInterval: 30,
            categories: <?php echo json_encode($months);?>,
            //dateTimeLabelFormats: { // don't display the dummy year
                //month: '%b \'%y', //'%e. %b', '%b \'%y'
               // year: '%b'
           // },
            title: {
                text: ''
            }
        },
        yAxis: {
            title: {
                text: ''// 'Snow depth (m)'
            },
            //min: 0.1,
            //max: 1.35
        },
        //tooltip: {
        //    headerFormat: '<b>{series.name}</b><br>',
        //    pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
        //},
        plotOptions: {
            spline: {
                lineWidth: 2,
                states: { hover: {lineWidth: 5}
                    },
                marker: {
                    enabled: false
                }
            }
        },   
        colors: ['#104E89', '#952C28', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
        credits: {enabled: false},

        series: <?php echo json_encode($series); ?>
    });
});

</script>
 <?php  ?>
                  <!-- </div>
                 -->  
                   <!-- /.col -->
					<!--
                    <div class="col-md-4">
                      <ul class="chart-legend clearfix">
                        <li><i class="fa fa-circle-o text-red"></i> Equities</li>
                        <li><i class="fa fa-circle-o text-light-blue"></i> Rates</li>
                        <li><i class="fa fa-circle-o text-green"></i> Alternatives</li>
                      </ul>
                    </div> /.col -->
					
                  <!--</div> /.row -->
                </div><!-- ./box-body -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                
<!-------------------------->
		  
</section>
	
<script>
  $(document).ready(function () {
    
        var table1 = $('#example1').DataTable({
    
        renderer: "bootstrap",        
        dom: 'lBfrtip',
        displayLength: 10,
        filter: true,
        paginate: true,
        sort:true,
        //bsort: true,
        //'bSortable' : true,
        info: false,
        //scrollX: '100%',
        //scrollCollapse: true,
        //paging:         false,
        //"bPaginate": true,
        //"bSort": true,
        //"bFilter": false,
        bJQueryUI: false,
        bProcessing: false,
        sScrollX: "100%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        
       /* 
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
            ],
        */
        select: true,
    
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            { extend: 'colvis', collectionLayout: 'fixed two-column',},  
        ],        
    } );
    });
</script>	

