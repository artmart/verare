<?php 
    $baseUrl = Yii::app()->baseUrl;
     
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}
    
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    $user_data->default_portfolio_id = $portfolio;
    $user_data->default_start_date = $start_date;
    $user_data->default_end_date = $end_date;
    $user_data->save();
    
    $portfolios = Yii::app()->db->createCommand("select * from portfolios where id = '$portfolio'")->queryAll(true);
    $portfolio_currency = $portfolios[0]['currency'];
?>

<h3><i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 class="span1">Overview
    <em><?php echo $portfolios[0]['portfolio']; ?> </em>
    <small><?php echo "   Currency -  " .  $portfolio_currency ; ?> </small>
  </h1>

<?php         
    $returns = Calculators::ReturnAllAndYTD($portfolio);

    ///pnl/////////////////////////////////////////////////////////
    $sql1 = "select trade_date, nominal*price*ledger.currency_rate/cr.{$portfolio_currency} nav from ledger
             inner join currency_rates cr on cr.day = ledger.trade_date             
                where ledger.portfolio_id = '$portfolio' and ledger.trade_date > '$start_date' and ledger.trade_date<'$end_date' and ledger.trade_status_id = 2 
                and ledger.client_id = '$client_id' and ledger.is_current = 1
                order by trade_date desc";
        $results1 = Yii::app()->db->createCommand($sql1)->queryAll(true);
        
        $nav_today = 0;
        $nav_yesterday = 0;
        $i = 0;
        foreach($results1 as $res1){
            $nav_today = $nav_today + $res1['nav'];
            if($i>0){
                $nav_yesterday = $nav_yesterday + $res1['nav'];
            }
            $i++;
        }
        $pnl = $nav_today - $nav_yesterday;
     ///////////////////////////////////////////////////////////////////////////////////   
        
    $portfolio_composition_sql = "select p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, sum(l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}) nav from ledger l
                                 inner join portfolios p on p.id = l.portfolio_id
                                 inner join currency_rates cr on cr.day = l.trade_date                                 
                                 where l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                                 and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id'
                                 group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
    $portfolio_composition = Yii::app()->db->createCommand($portfolio_composition_sql)->queryAll(true);
 
    $sub_portfolios_sql = "select p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, sum(l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}) nav from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join currency_rates cr on cr.day = l.trade_date                    
                    where l.trade_date > '$start_date' and l.trade_date<'$end_date' and p.parrent_portfolio = '$portfolio' 
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id'
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
                    
    $sub_portfolios = Yii::app()->db->createCommand($sub_portfolios_sql)->queryAll(true);
     
    $index_value = 0;

    $sub_port_data = ''; 
    $port_data_table = ''; 
    $level1 = [];
    
        foreach($portfolio_composition as $sp1){ 
                $value[$sp1['portfolio']] = 0; 
                $index_value = $index_value + $sp1['nav'];
             }
             
        foreach($sub_portfolios as $sp1){ 
            $value[$sp1['portfolio']] = 0; 
            $index_value = $index_value + $sp1['nav'];
         }
         
         //if($index_value == 0){$index_value = 1;}
    
    foreach($portfolio_composition as $sp2){        
                $port_data_table .= '<tr>
            						<td>Uncategorized</td>
            						<td>'.number_format($sp2['nav']).'</td>
            						<td>'.number_format($sp2['nav']*100/$index_value, 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal'], 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal']-$sp2['nav']*100/$index_value, 1).'%</td>
            						<td>'.number_format($sp2['allocation_min']).'-'.number_format($sp2['allocation_max']).'%</td>
            					  </tr>'; 
        
        $level1[] = array('name' => 'Uncategorized', 'y' => $sp2['nav']*100/$index_value);                            
  }
  
  ////////////////////////  
    foreach($sub_portfolios as $sp2){        
                $sub_port_data .= '<tr>
            						<td>'.$sp2['portfolio'].'</td>
            						<td>'.number_format($sp2['nav']).'</td>
            						<td>'.number_format($sp2['nav']*100/$index_value, 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal'], 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal']-$sp2['nav']*100/$index_value, 1).'%</td>
            						<td>'.number_format($sp2['allocation_min']).'-'.number_format($sp2['allocation_max']).'%</td>
            					  </tr>'; 
        
        $level1[] = array('name' => $sp2['portfolio'], 'y' => $sp2['nav']*100/$index_value);                           
  }
?>

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
                                  //$pnl = Calculators::PNL($start_date, $end_date, $portfolio);
                                  if($pnl >= 0)
                                  {
                                      echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'></i> " . number_format($pnl) . "</span>";
                                  }
                                  else
                                  {
                                      echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'></i> " . number_format($pnl) . "</span>";
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
						  <table id="example1" class="table table-bordered table-hover">
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
								<td><?php echo $portfolios[0]['portfolio']; ?></td>
								<td><?php echo number_format($index_value); ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							  </tr>

                              <?php echo $port_data_table . $sub_port_data; //$inst_data; ?>
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
        
    $sql_returns = "select * from portfolio_returns where portfolio_id = '$portfolio_id' and trade_date > '$start_date' and trade_date<'$end_date' order by trade_date";
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
                      
                      <?php 
                      
                        $cf_sql = "select distinct cf.cash_flow_date, i.instrument, cf.cash_flow, cft.cash_flow_type from cash_flows cf
                                inner join cash_flow_types cft on cf.`type` = cft.id
                                inner join instruments i on i.id = cf.instrument
                                inner join ledger l on l.instrument_id = i.id
                                where cf.cash_flow_date>='$end_date' and l.is_current = 1 and l.trade_status_id = 2 and l.portfolio_id = '$portfolio'
                                limit 5";
                        $cf_results = Yii::app()->db->createCommand($cf_sql)->queryAll(true);
                        foreach($cf_results as $cf){
                      ?>	  
					  <tr>
						<td><?php echo $cf['cash_flow_date']; ?></td>
						<td><?php echo $cf['instrument']; ?></td>
						<td><?php echo number_format($cf['cash_flow']); ?></td>
					  </tr>
                      <?php } ?>
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

  $(document).ready(function () {
    
    var table = $('#example').DataTable( {
    
        renderer: "bootstrap",
        //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
        //"Dom": '<"H"lfr>t<"F"ip>' ,
        //sDom: 'lfrtip',
        
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
        
        
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
            ],

        select: true,
    

        buttons: [
            /*{ extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },*/
            <?php //echo $access_buttons; ?>
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
    
    
        var table1 = $('#example1').DataTable( {
    
        renderer: "bootstrap",
        //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
        //"Dom": '<"H"lfr>t<"F"ip>' ,
        //sDom: 'lfrtip',
        
        dom: 'lBfrtip',
        displayLength: 10,
        filter: true,
        paginate: true,
        sort:false,
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
            /*{ extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },*/
            <?php //echo $access_buttons; ?>
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

