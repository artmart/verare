<?php
    $portfolio_id = $_REQUEST['portfolio'];
    $client_id = $_REQUEST['client_id'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
        
    $table_name = "client_".$client_id. "_inst_returns";
    //$portfolios = Portfolios::model()->findByPk($portfolio_id);
    $portfolio_currency = 'returns'; // $portfolios->currency;
    
    //$month_ytd_start = date('Y-01-01');
    $month_ytd_start = date("Y-m-d", mktime(0,0,0,1,1,date("Y", strtotime($end_date))));
    $month3_start = date( "Y-m-d", strtotime( "-3 month", strtotime($end_date) ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month", strtotime($end_date) ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month", strtotime($end_date) ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years", strtotime($end_date) ));
        
    /////////////////////////////////////////////////////////////////
     $p_ids[] = $portfolio_id;
        
        $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio = $portfolio_id")->queryAll(true);
        
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
    ////////////////////////////////////////////////////////////////  
    $instruments_query = "select distinct i.id, i.instrument, l.portfolio_id from instruments i inner join ledger l on l.instrument_id = i.id 
                          where l.is_current=1 and l.trade_status_id = 2 
                          and l.portfolio_id in ('$all_p_ids')
                          and l.client_id = '$client_id'  ";
    $instruments = Yii::app()->db->createCommand($instruments_query)->queryAll(true);
       
    $tbl_rows = '';
    $inst_num = 0;
    $bench_chart_value = 1;
    $months = [];
    $series = [];
    $onlyDoThisOnce = 0;
    
    foreach($instruments as $instrument){
        $instrument_id = $instrument['id'];
        $p_id = $instrument['portfolio_id'];
    
        $sql_returns = "select distinct r.trade_date, r.{$portfolio_currency} `return`, pr.benchmark_return 
                        from {$table_name} r 
                        inner join portfolio_returns pr on pr.trade_date = r.trade_date
                        where r.instrument_id = '$instrument_id'
                        and pr.portfolio_id = '$p_id'
                        and r.trade_date >= LEAST('$start_date','$month1y_start') and r.trade_date<='$end_date'
                        order by r.trade_date";
                        
        $sql_returns_josef_backup = "
            select ret.date_trade, 
            	(ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon as top, 
                    ret.nom_prev*ret.prc_prev + ret.val_trade as bot,
                    @ret2 := @ret2 * if(((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon = 0) or (ret.nom_prev*ret.prc_prev + ret.val_trade = 0), 1, ((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon) / (ret.nom_prev*ret.prc_prev + ret.val_trade)) as ret_series, 
                    @ret1 := if(((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon = 0) or (ret.nom_prev*ret.prc_prev + ret.val_trade = 0), 1, ((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon) / (ret.nom_prev*ret.prc_prev + ret.val_trade)) as ret_daily 
            
            from 
            
            (select dt.date_trade, dt.date_prev, @prc2 := @prc1 as prc_prev, @prc1 := prices.price as prc_trade, @nom2 := @nom1 as nom_prev, @nom1 := @nom1 + ifnull(trades.nom, 0) as nom_date, ifnull(trades.nom, 0) as nom_trade, ifnull(trades.trd, 0) as val_trade, ifnull(trades.cpn, 0) as val_coupon from
            
            (select dtTemp.trade_date as date_trade, (@dt2 := @dt1) as date_prev, (@dt1 := dtTemp.trade_date) as date_curr 
            from (select distinct trade_date from prices where trade_date<>'0000-00-00' and instrument_id = '$instrument_id' and is_current=1 order by trade_date) dtTemp) dt
            
            left join
            
            (select trade_date, 
            	sum(if(trade_type Not in ('2'), nominal*price, 0)) trd, 
            	sum(if(trade_type in ('2'), nominal*price, 0)) cpn, 
                    sum(if(trade_type Not in ('2'), nominal, 0)) nom 
            from ledger l
            where is_current = 1 and trade_status_id = 2 and instrument_id = '$instrument_id' and client_id = '$client_id' and portfolio_id in ('$all_p_ids') 
            group by trade_date) trades on trades.trade_date = dt.date_trade
            
            left join
            
            (select trade_date, price 
            from prices p
            where is_current = 1 and instrument_id = '$instrument_id'
            group by trade_date) prices on prices.trade_date = dt.date_trade) ret
        ";
        
        $sql_returns_josef = "
            select ret.date_trade, 
                    ret.nom_prev+ret.nom_trade as nom_test, 
            	    (ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon as top, 
                    ret.nom_prev*ret.prc_prev + ret.val_trade as bot,
                    @ret2 := @ret2 * if(((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon = 0) or (ret.nom_prev*ret.prc_prev + ret.val_trade = 0), 1, ((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon) / (ret.nom_prev*ret.prc_prev + ret.val_trade)) as ret_series, 
                    @ret1 := if(((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon = 0) or (ret.nom_prev*ret.prc_prev + ret.val_trade = 0), if(ret.nom_prev+ret.nom_trade=0 and ret.nom_prev<>0, ret.prc_trade/ret.prc_prev, 1), ((ret.nom_prev+ret.nom_trade)*ret.prc_trade + ret.val_coupon) / (ret.nom_prev*ret.prc_prev + ret.val_trade)) as ret_daily 
            
            from 
            
            (select dt.date_trade, dt.date_prev, @prc2 := @prc1 as prc_prev, @prc1 := prices.price as prc_trade, @nom2 := @nom1 as nom_prev, @nom1 := @nom1 + ifnull(trades.nom, 0) as nom_date, ifnull(trades.nom, 0) as nom_trade, ifnull(trades.trd, 0) as val_trade, ifnull(trades.cpn, 0) as val_coupon from
            
            (select dtTemp.trade_date as date_trade, (@dt2 := @dt1) as date_prev, (@dt1 := dtTemp.trade_date) as date_curr 
            from (select distinct trade_date from prices where trade_date<>'0000-00-00' and trade_date<='$end_date' and instrument_id = '$instrument_id' and is_current=1 order by trade_date) dtTemp) dt
            
            left join
            
            (select trade_date, 
            	sum(if(trade_type Not in ('2', '4'), nominal*price, 0)) trd, 
            	sum(if(trade_type in ('2'), nominal*price, 0)) cpn, 
                sum(if(trade_type Not in ('2'), nominal, 0)) nom 
            from ledger l
            where is_current = 1 and trade_status_id = 2 and instrument_id = '$instrument_id' and client_id = '$client_id' and portfolio_id in ('$all_p_ids') 
            group by trade_date) trades on trades.trade_date = dt.date_trade
            
            left join
            
            (select trade_date, price 
            from prices p
            where is_current = 1 and instrument_id = '$instrument_id'
            group by trade_date) prices on prices.trade_date = dt.date_trade) ret
        ";
        
        // Josef Apr2018
        //Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        //$instrument_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
        Yii::app()->db->createCommand("
	        SET SQL_BIG_SELECTS = 1;
	        set @dt1 = '-';
	        set @dt2 = '-';
            set @nom1 = 0.0;
            set @nom2 = 0.0;
            set @prc1 = 0.0;
            set @prc2 = 0.0;
            set @ret1 = 1.0;
            set @ret2 = 1.0;
		")->execute();
		$instrument_results = Yii::app()->db->createCommand($sql_returns_josef)->queryAll(true);
		
		//echo "<br>" . $sql_returns_josef . "<br>";
		
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $instrument_results_x = Yii::app()->db->createCommand($sql_returns)->queryAll(true);

        
        $sql_nav_nom = "SELECT sum(l.`nominal`) AS nom, sum(l.`nominal`) * p.`price` AS mv, p.`price` AS prc, if(sum(l.`nominal`)<>0,sum(l.`nominal`*l.`price`),0) as invested, sum(if(l.`nominal`<0,l.`nominal`*l.`price`,0)) as trdpls, sum(if(l.`nominal`>0,l.`nominal`*l.`price`,0)) as trdmin, sum(if(l.`nominal`<0,l.`nominal`,0)) as nompls, sum(if(l.`nominal`>0,l.`nominal`,0)) as nommin, sum(if(l.`trade_type`=2,l.`nominal`*l.`price`,0)) as cpnpmt FROM `ledger` l, `prices` p WHERE l.`instrument_id`='$instrument_id' AND l.`instrument_id`=p.`instrument_id` AND l.`client_id`='$client_id' AND l.`trade_status_id`=2 AND l.`trade_type`=1 AND l.`is_current`=1 AND p.`is_current`=1 AND p.`trade_date`='$end_date' AND l.`trade_date`<'$end_date' AND l.portfolio_id in ('$all_p_ids')";
        
        $sql_nav_nom = "SELECT 
                        	sum(if(l.`trade_type`=1,l.`nominal`,0)) AS nom, 
                                sum(if(l.`trade_type`=1,l.`nominal`,0)) * p.`price` AS mv, 
                                p.`price` AS prc, 
                                if(sum(if(l.`trade_type`=1,l.`nominal`,0))<>0,sum(if(l.`trade_type`=1,l.`nominal`,0)*l.`price`),0) as invested, 
                                sum(if(l.`nominal`<0 and l.`trade_type`=1,l.`nominal`*l.`price`,0)) as trdpls, 
                                sum(if(l.`nominal`>0 and l.`trade_type`=1,l.`nominal`*l.`price`,0)) as trdmin, 
                                sum(if(l.`nominal`<0 and l.`trade_type`=1,l.`nominal`,0)) as nompls, 
                                sum(if(l.`nominal`>0 and l.`trade_type`=1,l.`nominal`,0)) as nommin, 
                                sum(if(l.`trade_type`=2,l.`nominal`*l.`price`,0)) as cpnpmt 
                        FROM `ledger` l, `prices` p 
                        WHERE 
                        	l.`instrument_id`='$instrument_id' AND 
                                l.`instrument_id`=p.`instrument_id` AND 
                                l.`client_id`='$client_id' AND 
                                l.`trade_status_id`=2 AND 
                                l.`is_current`=1 AND 
                                p.`is_current`=1 AND 
                                p.`trade_date`='$end_date' AND 
                                l.`trade_date`<'$end_date' AND 
                                l.portfolio_id in ('$all_p_ids')";
        $instrument_nav_nom = Yii::app()->db->createCommand($sql_nav_nom)->queryAll(true);
        
        //echo $sql_returns_josef . "<p>";
        //echo $sql_nav_nom . '<p>';
        //echo $instrument_nav_nom[0]['nom'] . '<p>';
        //echo Yii::app()->baseUrl.'/portfolios/portfolios';
        //echo $start_date . " - " . $end_date;
        
        $i = 0;
        if($instrument_results){
            
            $port_data[$i] = [];
            $bench_data[$i] = [];
            
            $port_ret_x[$i] = [];
            $bench_ret_x[$i] = [];
        
            $port_chart_value = 1;
            
            $return_ytd = 1;
            $return_3m = 1;
            $return_6m = 1;
            $return_9m = 1;
            $return_1y = 1;
			
			/*
            foreach($instrument_results as $ir){
                if(strtotime($ir['trade_date'])>= strtotime($start_date)){
                    $months[] = $ir['trade_date'];
                    $bench_ret[] = $ir['benchmark_return'];
                    $port_ret[] = $ir['return'];
                    $port_chart_value = $port_chart_value * $ir['return'];
                    $port_data[$i][] = [$ir['trade_date'], floatval($port_chart_value)];
                    if($inst_num == 0){
                        $bench_chart_value = $bench_chart_value * $ir['benchmark_return'];
                        $bench_data[$i][] = [$ir['trade_date'], floatval($bench_chart_value)];  
                    }   
                }
                if(strtotime($ir['trade_date'])>= strtotime($month_ytd_start)){$return_ytd = $return_ytd * $ir['return'];}
                if(strtotime($ir['trade_date'])>= strtotime($month3_start)){$return_3m = $return_3m * $ir['return'];}
                if(strtotime($ir['trade_date'])>= strtotime($month6_start)){$return_6m = $return_6m * $ir['return'];}
                if(strtotime($ir['trade_date'])>= strtotime($month9_start)){$return_9m = $return_9m * $ir['return'];}
                if(strtotime($ir['trade_date'])>= strtotime($month1y_start)){$return_1y = $return_1y * $ir['return'];}
			}
			*/
			
            foreach($instrument_results as $ir){
                //$port_chart_value = $port_chart_value * $ir['ret_daily'];
                if(strtotime($ir['date_trade'])>=strtotime($start_date) && strtotime($ir['date_trade'])<=strtotime($end_date)){
                    $months[] = $ir['date_trade'];
                    
                    $ret_daily = 1.0;
                    if($ir['nom_test']<>0)
                        $ret_daily = $ir['ret_daily'];
                    
                    //$ret_daily = $ir['ret_daily'];
                    //if($ir['nom_test']=0)
                    //    $ret_daily = 1.0;
                    
                    //$port_ret[] = $ir['ret_daily'];
                    $port_ret[] = $ret_daily;
                    
                    $port_ret_x[$i][] = $ret_daily;
                    //$port_ret_x[$i][] = $ir['ret_daily'];
                    
                    //$port_chart_value = $port_chart_value * $ir['ret_daily'];
                    if($ret_daily>0.05&&$ret_daily<1.95)
                        $port_chart_value = $port_chart_value * $ret_daily;
                        
                    //if($ir['ret_daily']>0.05&&$ir['ret_daily']<1.95)
                    //    $port_chart_value = $port_chart_value * $ir['ret_daily'];
                        
                    $port_data[$i][] = [strtotime($ir['date_trade'])*1000, floatval($port_chart_value)];
                }
                if(strtotime($ir['date_trade'])<=strtotime($end_date))
                {
                    if(strtotime($ir['date_trade'])>=strtotime($month_ytd_start)){$return_ytd = $return_ytd * $ret_daily;}
                    if(strtotime($ir['date_trade'])>= strtotime($month3_start)){$return_3m = $return_3m * $ret_daily;}
                    if(strtotime($ir['date_trade'])>= strtotime($month6_start)){$return_6m = $return_6m * $ret_daily;}
                    if(strtotime($ir['date_trade'])>= strtotime($month9_start)){$return_9m = $return_9m * $ret_daily;}
                    if(strtotime($ir['date_trade'])>= strtotime($month1y_start)){$return_1y = $return_1y * $ret_daily;}
                    
                    //if(strtotime($ir['date_trade'])>=strtotime($month_ytd_start)){$return_ytd = $return_ytd * $ir['ret_daily'];}
                    //if(strtotime($ir['date_trade'])>= strtotime($month3_start)){$return_3m = $return_3m * $ir['ret_daily'];}
                    //if(strtotime($ir['date_trade'])>= strtotime($month6_start)){$return_6m = $return_6m * $ir['ret_daily'];}
                    //if(strtotime($ir['date_trade'])>= strtotime($month9_start)){$return_9m = $return_9m * $ir['ret_daily'];}
                    //if(strtotime($ir['date_trade'])>= strtotime($month1y_start)){$return_1y = $return_1y * $ir['ret_daily'];}   
                }
            }
            foreach($instrument_results_x as $irx){
                //$port_chart_value = $port_chart_value * $irx['return'];
                if(strtotime($irx['trade_date'])>=strtotime($start_date) && strtotime($irx['trade_date'])<=strtotime($end_date)){
                    //$months[] = $irx['trade_date'];
                    $bench_ret[] = $irx['benchmark_return'];
                    $bench_ret_x[$i][] = $irx['benchmark_return'];
                    //$port_ret[] = $irx['return'];
                    //$port_chart_value = $port_chart_value * $irx['return'];
                    //$port_data[$i][] = [$irx['trade_date'], floatval($port_chart_value)];
                    if($inst_num == 0){
                        $bench_chart_value = $bench_chart_value * $irx['benchmark_return'];
                        $bench_data[$i][] = [strtotime($irx['trade_date'])*1000, floatval($bench_chart_value)];  
                    }
                }
            }
        
			$return_all_time = $port_chart_value;
		
			if($inst_num == 0){
				$series[] = ['name'=> "Benchmark", 'data'=> $bench_data[$i]]; 
			}
			$series[] = ['name'=> $instrument['instrument'], 'data'=> $port_data[$i]];
			
			$allstats = Calculators::CalcAllStats1($port_ret_x[$i], $bench_ret_x[$i]);
			//$allstats = Calculators::CalcAllStats1($port_ret, $bench_ret);
	        
			$i++;
	        
	        if(strcmp($instrument['instrument'], "Carnegie Sverigefond") == 0 && $onlyDoThisOnce < 1)
	        {
	            /*
	            $onlyDoThisOnce++;
	            foreach($port_ret as $prrr)
	            {
	                echo $onlyDoThisOnce . "=" . $instrument['instrument'] . "=" . $prrr . "<br>";
	            }*/
	           // echo '<pre>'; print_r($port_ret); echo '</pre>';
	        }
              if($instrument_nav_nom[0]['nommin']<>0)
                $avgprc = $instrument_nav_nom[0]['trdmin']/$instrument_nav_nom[0]['nommin'];
              else
                $avgprc = 1.0;
            //echo $avgprc . "-" . $instrument_nav_nom[0]['trdmin'] . "-" . $instrument_nav_nom[0]['nompls'] . "<br>";
			  $tbl_rows .=   
				'<tr>
					<td>'. $instrument['instrument'].'</td>
					<td>'. number_format($instrument_nav_nom[0]['nom']).'</td>
					<td>'. number_format($instrument_nav_nom[0]['prc'], 3).'</td>
					<td>'. number_format($instrument_nav_nom[0]['mv']).'</td>
					<td>'. number_format($instrument_nav_nom[0]['trdmin']+$instrument_nav_nom[0]['trdpls']).'</td>
					<td>'. number_format($instrument_nav_nom[0]['mv']-$avgprc*$instrument_nav_nom[0]['nom']).'</td>
					<td>'. number_format($instrument_nav_nom[0]['nompls']*$avgprc-$instrument_nav_nom[0]['trdpls']).'</td>
					<td>'. number_format($instrument_nav_nom[0]['cpnpmt']).'</td>
					<td>'. number_format(($return_all_time-1)*100, 2).'%</td>
					<td>'. number_format(($return_ytd-1)*100, 2).'%</td>
					<td>'. number_format(($return_3m-1)*100, 2).'%</td>
					<td>'. number_format(($return_6m-1)*100, 2).'%</td>
					<td>'. number_format(($return_9m-1)*100, 2).'%</td>
					<td>'. number_format(($return_1y-1)*100, 2).'%</td>
					<td>'. number_format($allstats[0]*100, 2).'%</td>
					<td>'. number_format($allstats[1], 3).'</td>
					<td>'. number_format($allstats[2]*100, 2).'%</td>
					<td>'. number_format($allstats[4]*100, 2).'%</td>
					<td>'. number_format($allstats[13]*100, 2).'%</td>
					<td>'. number_format($allstats[14], 3).'</td>
					<td>'. number_format($allstats[3], 3).'</td>
                    <td>'. number_format($allstats[5]*100, 2).'%</td>
                    <td>'. number_format($allstats[6]*100, 2).'%</td>
                    <td>'. number_format($allstats[7]*100, 2).'%</td>
					<td>'. number_format($allstats[9]*100, 2).'%</td>
					<td>'. number_format($allstats[8]*100, 2).'%</td>
					<td>'. number_format($allstats[10]*100, 2).'%</td>
					<td>'. number_format($allstats[11]*100, 2).'%</td>
					<td>'. number_format($allstats[12]*100, 2).'%</td>
				</tr>';
		}
    
    $inst_num++;
}
$months = array_unique($months);
?>

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Name</th>
            <th>Nominal</th>
            <th>Price</th>
            <th>Value</th>
            <th>Invested</th>
            <th>Unrealized</th>
            <th>Realized</th>
            <th>Coupons</th>
            <th>AllTime</th>
            <th>YTD</th>
            <th>3M</th>
            <th>6M</th>
            <th>9M</th>
            <th>1Y</th>
            <th>Vol</th>
            <th>Sharpe</th>
            <th>Jensen</th>
            <th>Treynor</th>
            <th>Sortino</th>
            <th>Omega</th>
            <th>Beta</th>
            <th>TE</th>
            <th>IK</th>
            <th>K</th>
            <th>VaR</th> 
            <th>R2</th>
            <th>AvgR</th>
            <th>MaxR</th>
            <th>MinR</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $tbl_rows; ?>
        <?php //echo $month_ytd_start; ?>
    <tbody>
</table>
<div id="container1"></div>
<script>

$(function () {
    $('#container1').highcharts({
        chart: {type: 'spline'},
        title: { text: ''},
        subtitle: { text: '' },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%b/%Y',
                month: '%b/%Y',
                year: '%Y'
            },
            title: {text: ''}
        },
        yAxis: {
            title: {
                text: ''// 'Snow depth (m)'
            },
            //min: 0.2,
            //max: 1.9
        },

        plotOptions: {
            spline: {
                lineWidth: 2,
                states: { hover: {lineWidth: 5}
                    },
                marker: {enabled: false}
            }
        },   
        
        colors: ['#104E89', '#952C28', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
        credits: {enabled: false},

        series: <?php echo json_encode($series); ?>
    });
});

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
</script>