<?php 
    //$id = Yii::app()->user->id;
    //$user_data = Users::model()->findByPk($id);
    //$this->pageTitle=Yii::app()->name; 
    $baseUrl = Yii::app()->baseUrl;
    
    //$aa = json_decode($_REQUEST['user_data']);
    //var_dump($aa);
    //if(isset($user_data->default_portfolio_id)){$portfolio = $user_data->default_portfolio_id;}
    
   	//$end_date = Date('Y-m-d');
	//$start_date = date('Y-m-d', strtotime('-1 years'));
    //if(isset($user_data->default_start_date)){$start_date = $user_data->default_start_date;}
    //if(isset($user_data->default_end_date)){$end_date = $user_data->default_end_date;}
    //if(isset($_POST['start_date'])){$start_date = date_format(date_create($_POST['start_date']),"Y-m-d");}
    //if(isset($_POST['end_date'])){$end_date = date_format(date_create($_POST['end_date']),"Y-m-d");}
 
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    
    
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    $user_data->default_portfolio_id = $portfolio;
    $user_data->default_start_date = $start_date;
    $user_data->default_end_date = $end_date;
    $user_data->save();
    
    $portfolios = Yii::app()->db->createCommand("select * from portfolios where id = '$portfolio'")->queryAll(true);
?>

<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 class="span1">Overview
    <small>
        <?php echo $portfolios[0]['portfolio']; ?> 
    </small>
  </h1>


<?php        
    /*
    $sql_table1 = "select pt.portfolio_type, p.portfolio, i.instrument, pt.allocation_min, pt.allocation_max, pt.allocation_normal, l.nominal*l.price nav from ledger l
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios p on p.id = l.portfolio_id
                    left join portfolio_types pt on pt.id = p.type_id
                    where l.portfolio_id = 1 and l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                    group by pt.portfolio_type, p.portfolio, i.instrument, pt.allocation_min, pt.allocation_max, pt.allocation_normal";
    */
    
    $returns = Calculators::ReturnAllAndYTD($portfolio);
    $pnl = Calculators::PNL($start_date, $end_date, $portfolio);
    
    
    //left join instrument_groups ig on ig.id = i.instrument_group_id
    $portfolio_composition_sql = "select pt.portfolio_type group_name, pt.id instrument_group_id, p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, sum(l.nominal*l.price) nav  
                            from ledger l
                            inner join instruments i on i.id = l.instrument_id
                            inner join portfolios p on p.id = l.portfolio_id
                            left join portfolio_types pt on pt.id = p.type_id
                            where l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                            group by pt.portfolio_type, pt.id, p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
    $portfolio_composition = Yii::app()->db->createCommand($portfolio_composition_sql)->queryAll(true);
    
    
    //left join instrument_groups ig on ig.id = i.instrument_group_id
    $sql_table1 = "select pt.portfolio_type group_name, pt.id instrument_group_id, p.portfolio, i.instrument, p.allocation_min, p.allocation_max, p.allocation_normal, sum(l.nominal*l.price) nav from ledger l
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios p on p.id = l.portfolio_id
                    left join portfolio_types pt on pt.id = p.type_id
                    where l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                    group by pt.portfolio_type, pt.id, p.portfolio, i.instrument, p.allocation_min, p.allocation_max, p.allocation_normal";
    $table1_results = Yii::app()->db->createCommand($sql_table1)->queryAll(true);
    
    $inst_data = '';
    $index_value = 0;
    
    $table_head = "<thead><tr>
						<th>Name</th>
						<th>Value (SEK)</th>
						<th>Allocation</th>
						<th>Normal</th>
						<th>Diff</th>
						<th>Min-Max</th>
				  </tr></thead>";
        
    foreach($portfolio_composition as $pgc){ 
                $value[$pgc['instrument_group_id']] = 0; 
                $inst_data1[$pgc['instrument_group_id']] = '';
                $index_value = $index_value + $pgc['nav'];
             }
    
    foreach($table1_results as $pc){        
        foreach($portfolio_composition as $pgc){ 
             if($pc['instrument_group_id'] == $pgc['instrument_group_id']){
                $value[$pgc['instrument_group_id']] = $value[$pgc['instrument_group_id']] + $pc['nav'];
                $allocation[$pgc['instrument_group_id']][] = array($pc['instrument'],$pc['nav']*100/$index_value);
                $inst_data1[$pgc['instrument_group_id']] .= 
                					  '<tr>
                						<td>'.$pc['instrument'].'</td>
                						<td>'.number_format($pc['nav']).'</td>
                						<td>'.number_format($pc['nav']*100/$index_value, 1).'%</td>
                						<td>'.number_format($pc['allocation_normal'], 1).'%</td>
                						<td>'.number_format($pc['allocation_normal']-$pc['nav']*100/$index_value, 1).'%</td>
                						<td>'.number_format($pc['allocation_min']).'-'.number_format($pc['allocation_max']).'%</td>
                					  </tr>'; 
             }   
    
        }                            
  }
  
   $level1 = [];
  // $level2 = [];
  
    $i = 2;
    foreach($portfolio_composition as $pgc){ 
        $inst_data .= 
					  '<tr>
						<td>'.$pgc['group_name'].'</td>
						<td>'.number_format($value[$pgc['instrument_group_id']]).'</td>
						<td>'.number_format($value[$pgc['instrument_group_id']]*100/$index_value, 1).'%</td>
						<td>'.number_format($pgc['allocation_normal'], 1).'%</td>
						<td>'.number_format($pgc['allocation_normal']-$pc['nav']*100/$index_value, 1).'%</td>
						<td>'.number_format($pgc['allocation_min']).'-'.number_format($pc['allocation_max']).'%</td>
					  </tr>';
                      
    $level1[] = array('name' => $pgc['group_name'], 'y' => $value[$pgc['instrument_group_id']]*100/$index_value);   
    //$level1[] = array('name' => $pgc['group_name'], 'y' => $value[$pgc['instrument_group_id']]*100/$index_value, 'drilldown' => $pgc['instrument_group_id']);           
    //$level2[] = array('id' => $pgc['instrument_group_id'], 'data' => $allocation[$pgc['instrument_group_id']] /*array(array('Detail1', 1), array('Detail2', 2), array('Detail3', 4))*/);
?>
    
    <table id="exampleTable_<?php echo $i;?>" class="table table-bordered table-hover">
		<?php echo $table_head; ?>
		<tbody>
          <?php echo $inst_data1[$pgc['instrument_group_id']]; ?>
		<tbody>
	  </table>  
      <script>
      var TableHtml1_<?php echo $i;?> = $("#exampleTable_<?php echo $i;?>").html();
       $("#exampleTable_<?php echo $i;?>").hide();
      </script>   
    <?php $i++; } ?>
</section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
			  
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-text">MARKET VALUE</span><p>
                        <span class="description-percentage text-black"><b><?php echo number_format($index_value); ?></b></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-text">O/N P/L</span><p>
                              <?php
                                  $pnl = Calculators::PNL($start_date, $end_date, $portfolio);
                                  if($pnl >= 0)
                                  {
                                      echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'></i> " . number_format($pnl[0]) . "</span>";
                                  }
                                  else
                                  {
                                      echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'></i> " . number_format($pnl[0]) . "</span>";
                                  } 
                              ?>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-text">RETURN All Time</span><p>
                        <span class="description-percentage text-black"><?php echo number_format($returns[0], 2); ?>%</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-text">RETURN YTD</span><p>
                        <span class="description-percentage text-black"><?php echo number_format($returns[1], 2); ?>%</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
			  </div><!-- /.box -->
			</div><!-- /.col -->
		  </div><!-- /.row -->
			  
			  
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
                    <div class="col-md-8">
					
                      <div class="chart">
					       <div class="scrollit">
						  <table id="exampleTable" class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>Name</th>
								<th>Value (SEK)</th>
								<th>Allocation</th>
								<th>Normal</th>
								<th>Diff</th>
								<th>Min-Max</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>Portfolio</td>
								<td><?php echo number_format($index_value); ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							  </tr>
                              <?php echo $inst_data; ?>
							<tbody>
						  </table>
						</div>	  
                      </div><!-- /.chart-responsive -->
					  
                    </div><!-- /.col -->
					
                    <div class="col-md-4">    
                     
<?php

    //style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"
?>
<div id="container2" ></div>
<script>
$(function () {
    $('#container2').highcharts({
        colors: ['#FF2F2F', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5', '#0563FE',  '#6AC36A', '#FFD148'],
        chart: {
            //plotBackgroundColor: null,
            //plotBorderWidth: null,
            //plotShadow: false,
            type: 'pie',
            height: 300,
        },
        credits: {enabled: false},
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{name: '', colorByPoint: true, data: <?php echo json_encode($level1); ?>}],
    });
});

</script>
                    </div><!-- /.col -->
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
		  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolio Performance</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
					
                      <div class="table">
                      
<?php       
    $month_ytd_start = date('Y-01-01');
    $month3_start = date( "Y-m-d", strtotime( "-3 month" ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month" ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month" ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years" ));
    
     //$accessable_portfolios1 = Yii::app()->user->getState('accessable_portfolios');
     //$accessable_portfolios = implode("', '", explode(",", $accessable_portfolios1));
     //$portfolios = Yii::app()->db->createCommand("select * from portfolios where id in ('$accessable_portfolios')")->queryAll(true);
     
    $months = [];
    $series = [];  
    $tbl_rows = '';
    foreach($portfolios as $port){
        $portfolio_id = $port['id'];
        
    $sql_returns = "select * from portfolio_returns where portfolio_id = '$portfolio_id' order by trade_date";
    $portfolio_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
    if($portfolio_results){
        
        $port_chart_value = 1;
        $bench_chart_value = 1;
        
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_9m = 1;
        $return_1y = 1;
        
        $return_ytd_bench = 1;
        $return_3m_bench = 1;
        $return_6m_bench = 1;
        $return_9m_bench = 1;
        $return_1y_bench = 1;
        
        foreach($portfolio_results as $pr){
            
            $months[] = $pr['trade_date'];
            $port_ret[] = $pr['return'];
            $bench_ret[] = $pr['benchmark_return'];
            
            $port_chart_value = $port_chart_value * $pr['return'];
            $bench_chart_value = $bench_chart_value * $pr['benchmark_return'];          
            
            if(strtotime($pr['trade_date'])>= strtotime($month_ytd_start)){$return_ytd = $return_ytd * $pr['return']; $return_ytd_bench = $return_ytd_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month3_start)){$return_3m = $return_3m * $pr['return']; $return_3m_bench = $return_3m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month6_start)){$return_6m = $return_6m * $pr['return']; $return_6m_bench = $return_6m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month9_start)){$return_9m = $return_9m * $pr['return']; $return_9m_bench = $return_9m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month1y_start)){$return_1y = $return_1y * $pr['return']; $return_1y_bench = $return_1y_bench * $pr['benchmark_return'];}
                        
            $port_data[] = [$pr['trade_date'], floatval($port_chart_value)];
            $bench_data[] = [$pr['trade_date'], floatval($bench_chart_value)];   
        }
        
        $return_all_time = $port_chart_value;
        $return_all_time_bench = $bench_chart_value;
     
    $series[] = ['name'=> $port['portfolio'], 'data'=> $port_data];
    $series[] = ['name'=> $port['portfolio']."-benchmark", 'data'=> $bench_data]; 
    
    $allstats = Calculators::CalcAllStats1($port_ret, $bench_ret);
    $allstats_bench = Calculators::CalcAllStats_bench($bench_ret, $bench_ret);
    
    //$allstats_bench = Calculators::CalcAllStats1($bench_ret, $port_ret);
    
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'</td>
        <td>'. number_format(($return_all_time-1)*100, 1).'%</td>
        <td>'. number_format(($return_ytd-1)*100, 1).'%</td>
        <td>'. number_format(($return_3m-1)*100, 1).'%</td>
        <td>'. number_format(($return_6m-1)*100, 1).'%</td>
        <td>'. number_format(($return_9m-1)*100, 1).'%</td>
        <td>'. number_format(($return_1y-1)*100, 1).'%</td>
        <td>'. number_format($allstats[0]*100, 1).'%</td>
        <td>'. number_format($allstats[1], 3).'</td>
    </tr>';
    
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'-Benchmark</td>
        <td>'. number_format(($return_all_time_bench-1)*100, 1).'%</td>
        <td>'. number_format(($return_ytd_bench-1)*100, 1).'%</td>
        <td>'. number_format(($return_3m_bench-1)*100, 1).'%</td>
        <td>'. number_format(($return_6m_bench-1)*100, 1).'%</td>
        <td>'. number_format(($return_9m_bench-1)*100, 1).'%</td>
        <td>'. number_format(($return_1y_bench-1)*100, 1).'%</td>
        <td>'. number_format($allstats_bench[0]*100, 1).'%</td>
        <td>'. number_format($allstats_bench[1], 3).'</td>
    </tr>';

$months = array_unique($months);  
?> 
                   
                    <table id="tablePerformance" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>AllTime</th>
                                <th>YTD</th>
                                <th>3M</th>
                                <th>6M</th>
                                <th>9M</th>
                                <th>1Y</th>
                                <th>Vol</th>
                                <th>Sharpe</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $tbl_rows; ?>
                        <tbody>
                    </table>

        <div id="container1"></div>
<?php

}else{ ?>       
       
       <img style="height: 350px; margin: 0 auto; float: left; padding-left: 30%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
<?php } 
}?>       
                     
          </div><!-- /.chart-responsive -->
        </div><!-- /.col -->
		
      </div><!-- /.row -->
      <div class="row">
        <div class="col-md-12">
		  <!--<canvas id="areaChart" height="200"></canvas>-->






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
            min: 0.9,
            max: 1.35
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
          
                    </div><!-- /.col -->
                  </div><!-- /.row -->
					  
                </div><!-- ./box-body -->
				
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
		  	
          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
		  
                <div class="box-header with-border">
                  <h3 class="box-title">Cash Management</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
					
                      <div class="table">
					  
						  <table id="tableCashManagement" class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>Date</th>
								<th>Instrument</th>
								<th>Amount</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>12-Jun-2015</td>
								<td>BATSJ 13 06/12/17</td>
								<td>712,589</td>
							  </tr>
							  <tr>
								<td>26-Jun-2015</td>
								<td>STERV 5 3/4 06/26/17</td>
								<td>292,644</td>
							  </tr>
							  <tr>
								<td>27-Jun-2015</td>
								<td>SCANDA 8 1/2 06/27/18</td>
								<td>425,000</td>
							  </tr>
							  <tr>
								<td>28-Jun-2015</td>
								<td>OPM Listed Private Equity</td>
								<td>627,000</td>
							  </tr>
							<tbody>
						  </table>
						  
					  </div> <!-- /.table -->
                    </div><!-- class="col-md-6"> -->
                  </div><!-- class="row"> -->
                </div><!-- class="box-body"> -->
					  
              </div><!-- /.box -->
            </div><!-- /.col -->
			
			
			
            <div class="col-md-6">
              <div class="box box-info">
		  
                <div class="box-header with-border">
                  <h3 class="box-title">Winners/Losers</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
				
                      <div class="table">
						  <table id="tableWinners" class="table table-bordered table-hover">
							<thead>
							  <tr>
								<th>Instrument</th>
								<th>NAV</th>
								<th>Change</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td><span class="description-percentage text-green"><i class="fa fa-caret-up"></i> Swedbank Robur Penningmarknads</span></td>
								<td><span class="description-percentage text-green">64,047,833</span></td>
								<td><span class="description-percentage text-green">269,001</span></td>
							  </tr>
							  <tr>
								<td><span class="description-percentage text-green"><i class="fa fa-caret-up"></i> Swedbank Robur Penningmarknads</span></td>
								<td><span class="description-percentage text-green">16,104,449</span></td>
								<td><span class="description-percentage text-green">144,287</span></td>
							  </tr>
							  <tr>
								<td><span class="description-percentage text-red"><i class="fa fa-caret-down"></i> SEB Sverige Stiftelsefond</span></td>
								<td><span class="description-percentage text-red">63,194,905</span></td>
								<td><span class="description-percentage text-red">-97,952</span></td>
							  </tr>
							  <tr>
								<td><span class="description-percentage text-red"><i class="fa fa-caret-down"></i> SEB Foretagsobligationsfond Fl</span></td>
								<td><span class="description-percentage text-red">45,258,816</span></td>
								<td><span class="description-percentage text-red">-133,514</span></td>
							  </tr>
							<tbody>
						  </table>
					  </div> <!-- /.table -->
					  
                    </div><!-- class="col-md-6"> -->
                  </div><!-- class="row"> -->
                </div><!-- class="box-body"> -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
        </section>

		
<script>

function fnFormatDetails(table_id, html) {
    var sOut = "<table id=\"exampleTable_" + table_id + "\">";
    sOut += html;
    sOut += "</table>";
    return sOut;
}



var iTableCounter = 1;
    var oTable;
    var oInnerTable;
    var TableHtml;
    var TableHtml1;

    //Run On HTML Build
    $(document).ready(function () {
        TableHtml = $("#exampleTable").html();
        //TableHtml1 = $("#exampleTable_" + iTableCounter).html();


        //Insert a 'details' column to the table
        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<img src="http://i.imgur.com/SD7Dz.png">';
        nCloneTd.className = "center";

        $('#exampleTable thead tr').each(function () {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#exampleTable tbody tr').each(function () {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        //Initialse DataTables, with no sorting on the 'details' column
        var oTable = $('#exampleTable').dataTable({
            
            
            renderer: "bootstrap",
            //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
            //"Dom": '<"H"lfr>t<"F"ip>' ,
            //sDom: 'lfrtip',
            
            //dom: 'lBfrtip',
            //displayLength: 10,
            filter: true,
            paginate: true,
            sort:true,
            //bsort: true,
            //'bSortable' : true,
            info: true,
            //scrollX: '100%',
            //scrollCollapse: true,
            //paging:         false,
            //"bPaginate": true,
            //"bSort": true,
            //"bFilter": false,
            //bJQueryUI: false,
            //bProcessing: true,
            sScrollX: "100%",
            sScrollXInner: "110%",
            bScrollCollapse: true,
            
            
            "bJQueryUI": false,
            //"sPaginationType": "full_numbers",
            "aoColumnDefs": [
            { "bSortable": false, "aTargets": [0] }
        ],
           // "aaSorting": [[1, 'asc']]
        });

        /* Add event listener for opening and closing details
        * Note that the indicator for showing which row is open is not controlled by DataTables,
        * rather it is done here
        */
        $('#exampleTable tbody td img').on('click', function () {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                this.src = "http://i.imgur.com/SD7Dz.png";
                oTable.fnClose(nTr);
            }
            else {
                /* Open this row */
                var tab_num = $(this).closest("tr").index()+1;
                //alert($(this).closest("tr").index()+1);
                this.src = "http://i.imgur.com/d4ICC.png";
                oTable.fnOpen(nTr, fnFormatDetails(iTableCounter, $("#exampleTable_" + tab_num).html()), 'details');
                           
                oInnerTable = $("#exampleTable_" + iTableCounter).dataTable({
                    "bJQueryUI": false,
                    //"sPaginationType": "full_numbers"
                });
                //iTableCounter = iTableCounter + 1;
            }
        });

    });
</script>	

