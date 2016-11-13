<?php      
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}
    
    $date = strtotime($end_date);
    $yesterday =  date('Y-m-d', strtotime("-1 day", $date));
     
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
    <small><?php echo "   (" . $portfolio_currency . ")" ; ?> </small>
  </h1>

<?php         
    //////////////////////////////////////////
    $p_ids = []; 
    $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio = $portfolio")->queryAll(true);
    
    while(count($all_portfolios)>0){
        $new_ids = [];
        foreach($all_portfolios as $ap){
            $p_ids[] = $ap['id'];
            $new_ids[] = $ap['id'];
        }
        $new_p_ids = implode("','", array_unique($new_ids));
        $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio in ('$new_p_ids')")->queryAll(true);
    }

    $all_p_ids = implode("','", array_unique($p_ids));
    ///////////////////////////////////////////////////////////////////////////////////   
        
    $portfolio_composition_sql = "select p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                                 sum(l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}) nav, 
                                 sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                                 sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade
                                 from ledger l
                                 inner join portfolios p on p.id = l.portfolio_id
                                 inner join currency_rates cr on cr.day = l.trade_date 
                                 inner join prices pr on pr.instrument_id = l.instrument_id  
                                 inner join instruments i on i.id = l.instrument_id
                                 inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                              
                                 where l.trade_date >= '$start_date' and l.trade_date<='$end_date' and l.portfolio_id = '$portfolio' 
                                 and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and pr.trade_date = '$end_date'
                                 group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
                                 
  
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
    $portfolio_composition = Yii::app()->db->createCommand($portfolio_composition_sql)->queryAll(true);
 
    $sub_portfolios_sql = "select portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join currency_rates cr on cr.day = l.trade_date 
                    inner join prices pr on pr.instrument_id = l.instrument_id
                    inner join instruments i on i.id = l.instrument_id
                    inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                   
                    where p.parrent_portfolio = $portfolio and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id'
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal
                    Union 
                    select p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav,
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade 
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join portfolios p2 on p2.id = p.parrent_portfolio
                    inner join currency_rates cr on cr.day = l.trade_date
                    inner join prices pr on pr.instrument_id = l.instrument_id  
                    inner join instruments i on i.id = l.instrument_id
                    inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                   
                    where p.parrent_portfolio in ('$all_p_ids') and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' 
                    group by p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal";
                        
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();                
    $sub_portfolios = Yii::app()->db->createCommand($sub_portfolios_sql)->queryAll(true);
     
    $index_value = 0;
    $yesterday_value1 = 0;
    $yesterday_value2 = 0;
    $trade = 0;

    $sub_port_data = ''; 
    $port_data_table = ''; 
    $level1 = [];

        foreach($portfolio_composition as $sp1){ 
                $value[$sp1['portfolio']] = 0; 
                $index_value = $index_value + $sp1['nav'];
                $yesterday_value1 = $yesterday_value1 + $sp1['nav_yest'];
                $trade = $trade + $sp1['trade'];
             }
             
        foreach($sub_portfolios as $sp1){ 
            $value[$sp1['portfolio']] = 0;
            $index_value = $index_value + $sp1['nav'];
            $yesterday_value2 = $yesterday_value2 + $sp1['nav_yest']; 
            $trade = $trade + $sp1['trade'];
         }
    $pnl =  $index_value - $yesterday_value1 - $yesterday_value2 - $trade;
            
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
                  if($pnl >= 0){echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'></i> " . number_format($pnl) . "</span>";
                  }else{echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'></i> " . number_format($pnl) . "</span>";} 
                  
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $sql_ret = "select pr.trade_date, 
                        if(pr.trade_date >= '$start_date' and pr.trade_date<='$end_date', pr.return, 1) `return`, 
                        if(pr.trade_date >= GREATEST(MAKEDATE(year(now()),1), '$start_date') and pr.trade_date<='$end_date', pr.return, 1) ytd  
                        from portfolio_returns pr where pr.portfolio_id = '$portfolio'";
                $results_ret = Yii::app()->db->createCommand($sql_ret)->queryAll(true);
                
                $product = 1;
                $all_time_return = 1;
                $year_to_date_return = 1;
                foreach($results_ret as $res){
                    $all_time_return = $all_time_return * $res['return'];
                    $year_to_date_return = $year_to_date_return * $res['ytd'];            
                }
              ?>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-text">RETURN All Time</span><p>
                <span class="description-percentage text-black"><?php echo number_format(($all_time_return - 1)*100, 2); ?>%</span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <span class="description-text">RETURN YTD</span><p>
                <span class="description-percentage text-black"><?php echo number_format(($year_to_date_return - 1)*100, 2); ?>%</span>
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
						<th>Value (<?php echo $portfolio_currency; ?>)</th>
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
        title: {text: ''},
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
    $month3_start = date( "Y-m-d", strtotime( "-3 month", strtotime($end_date) ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month", strtotime($end_date) ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month", strtotime($end_date) ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years", strtotime($end_date) ));
         
    $months = [];
    $series = [];  
    $tbl_rows = '';
    foreach($portfolios as $port){
        $portfolio_id = $port['id'];
        
    $sql_returns = "select * from portfolio_returns where portfolio_id = '$portfolio_id' and trade_date >= LEAST('$start_date','$month1y_start')  and trade_date<='$end_date' order by trade_date";
    
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
                     
            if(strtotime($pr['trade_date'])>= strtotime($start_date)){$port_chart_value = $port_chart_value * $pr['return']; $bench_chart_value = $bench_chart_value * $pr['benchmark_return'];}
           
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
   
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'</td>
        <td>'. number_format(($return_all_time-1)*100, 2).'%</td>
        <td>'. number_format(($return_ytd-1)*100, 2).'%</td>
        <td>'. number_format(($return_3m-1)*100, 2).'%</td>
        <td>'. number_format(($return_6m-1)*100, 2).'%</td>
        <td>'. number_format(($return_9m-1)*100, 2).'%</td>
        <td>'. number_format(($return_1y-1)*100, 2).'%</td>
        <td>'. number_format($allstats[0]*100, 2).'%</td>
        <td>'. number_format($allstats[1], 3).'</td>
    </tr>';
   
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'-Benchmark</td>
        <td>'. number_format(($return_all_time_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_ytd_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_3m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_6m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_9m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_1y_bench-1)*100, 2).'%</td>
        <td>'. number_format($allstats_bench[0]*100, 2).'%</td>
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
        chart: {type: 'spline'},
        title: { text: '' },
        subtitle: {  text: '' },
        xAxis: {
            type: 'datetime',
            minTickInterval: 30,
            categories: <?php echo json_encode($months);?>,
            //dateTimeLabelFormats: { // don't display the dummy year
                //month: '%b \'%y', //'%e. %b', '%b \'%y'
               // year: '%b'
           // },
            title: { text: '' }
        },
        yAxis: {
            title: { text: '' },
            //min: 0.1,
            //max: 1.35
        },
        
        plotOptions: {
            spline: {
                lineWidth: 2,
                states: { hover: {lineWidth: 5}
                    },
                
                marker: { enabled: false }
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
  <div class="box box-primary" style="height: 300px;">

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
      <?php 
        $rows = '';                      
        $cf_sql = "select cf.cash_flow_date, i.instrument, sum(cf.cash_flow * l.nominal*cr.{$portfolio_currency}/curs.cur_rate) cash_flow, cft.cash_flow_type from cash_flows cf
                inner join cash_flow_types cft on cf.`type` = cft.id
                inner join instruments i on i.id = cf.instrument
                inner join ledger l on l.instrument_id = i.id
                inner join currency_rates cr on cr.day = l.trade_date
                inner join cur_rates curs on curs.day = cf.cash_flow_date and curs.cur = i.currency
                inner join portfolios port on port.id = l.portfolio_id
                where cf.cash_flow_date>='$end_date' 
                and l.is_current = 1 and l.trade_status_id = 2
                and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                and l.client_id ='$client_id'
                group by cf.cash_flow_date, i.instrument
                limit 6";
                                               
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $cf_results = Yii::app()->db->createCommand($cf_sql)->queryAll(true);
        
        $rows = ''; 
        if($cf_results){
        foreach($cf_results as $cf){

              $rows .= 	  
				  "<tr>
					<td>" . $cf['cash_flow_date']. "</td>
					<td>". $cf['instrument']. "</td>
					<td>" .number_format($cf['cash_flow']). "</td>
				  </tr>";
        } ?>
          <table id="tableCashManagement" class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Date</th>
					<th>Instrument</th>
					<th>Amount</th>
				  </tr>
				</thead>
				<tbody>
                    <?php echo $rows; ?>
				<tbody>
			  </table>
		       <?php }else{ ?>
                    <img style="height: 100%; margin: 0 auto; padding-left: 25%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
           <?php } ?>
		  </div> <!-- /.table -->
        </div><!-- class="col-md-6"> -->
      </div><!-- class="row"> -->
    </div><!-- class="box-body"> -->
		  
  </div><!-- /.box -->
</div><!-- /.col -->
					
<div class="col-md-6">
  <div class="box box-info" style="height: 300px;">

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
	    <?php  
            $win_los_query = "select i.instrument,
                            sum( if(p.trade_date = '$end_date', p.price * l.nominal*cr.{$portfolio_currency}/curs.cur_rate, 0)) nav_today,
                            sum( if(p.trade_date = DATE_ADD('$end_date', INTERVAL -1 DAY), p.price * l.nominal*cr.{$portfolio_currency}/curs.cur_rate, 0)) nav_yesterday
                            from prices p
                            inner join ledger l on l.instrument_id = p.instrument_id
                            inner join currency_rates cr on cr.day = p.trade_date
                            inner join instruments i on i.id = p.instrument_id
                            inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                            inner join portfolios port on port.id = l.portfolio_id
                            where l.trade_status_id = 2 and l.is_current = 1 and l.client_id = '$client_id' 
                            and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                            and p.trade_date in(DATE_ADD('$end_date', INTERVAL -1 DAY), '$end_date')
                            group by i.instrument order by i.instrument, nav_today desc";
            Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
            $win_los = Yii::app()->db->createCommand($win_los_query)->queryAll(true);
               $wl_cnt = count($win_los);
               if($wl_cnt>0){
               $rows_wl = '';
               $wids = [];
               for($i = 0; $i<$wl_cnt; $i++){
                    if($i<3 || ($i>=$wl_cnt-3 && $i>3)){
                        $wids[] = $i;
                    }
               }   
               foreach($wids as $ii){
                if($ii <3){ 
                    $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-green'><i class='fa fa-caret-up'></i>" .$win_los[$ii]['instrument']."</span></td>
                        		<td><span class='description-percentage text-green'>" . number_format($win_los[$ii]['nav_today'])."</span></td>
                        		<td><span class='description-percentage text-green'>" . number_format($win_los[$ii]['nav_today'] - $win_los[$ii]['nav_yesterday']). "</span></td>
                                <td><span class='description-percentage text-green'>" . number_format($win_los[$ii]['nav_today']/$win_los[$ii]['nav_yesterday']-1, 2). "</span></td>
                        	  </tr>";  
                }else{
                    $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-red'><i class='fa fa-caret-down'></i>" . $win_los[$ii]['instrument']. "</span></td>
                        		<td><span class='description-percentage text-red'>" . number_format($win_los[$ii]['nav_today']) . "</span></td>
                        		<td><span class='description-percentage text-red'>" . number_format($win_los[$ii]['nav_today']-$win_los[$ii]['nav_yesterday']) . "</span></td>
                                <td><span class='description-percentage text-red'>" . number_format($win_los[$ii]['nav_today']/$win_los[$ii]['nav_yesterday']-1, 2) . "</span></td>
                        	  </tr>";   
               } }        
        ?>
          <div class="table">
			  <table id="tableWinners" class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Instrument</th>
					<th>NAV</th>
					<th>Change(abs)</th>
                    <th>Change(rel)</th>
				  </tr>
				</thead>
				<tbody>
                <?php echo $rows_wl; ?>
				<tbody>
			  </table>
              <?php }else{ ?>
                    <img style="height: 100%; margin: 0 auto; padding-left: 25%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
           <?php } ?>
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
        //paging: false,
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
            { extend: "edit", editor: editor },
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