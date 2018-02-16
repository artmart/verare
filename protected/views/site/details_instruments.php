<?php
    $portfolio_id = $_REQUEST['portfolio'];
    $client_id = $_REQUEST['client_id'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
        
    $table_name = "client_".$client_id. "_inst_returns";
    //$portfolios = Portfolios::model()->findByPk($portfolio_id);
    $portfolio_currency = 'returns'; // $portfolios->currency;
    
    $month_ytd_start = date('Y-01-01');
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
    
    foreach($instruments as $instrument){
            $instrument_id = $instrument['id'];
            $p_id = $instrument['portfolio_id'];
        
            $sql_returns = "select distinct r.trade_date, r.{$portfolio_currency} `return`, pr.benchmark_return 
                            from {$table_name} r 
                            inner join portfolio_returns pr on pr.trade_date = r.trade_date
                            where r.instrument_id = '$instrument_id'
                            and pr.portfolio_id = '$p_id'
                            and r.trade_date > LEAST('$start_date','$month1y_start') and r.trade_date<'$end_date'
                            order by r.trade_date";
            Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
            $instrument_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
    $i = 0;
    if($instrument_results){
     $port_data[$i] = [];
     $bench_data[$i] = [];
        
        $port_chart_value = 1;
        
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_9m = 1;
        $return_1y = 1;
        
        foreach($instrument_results as $ir){
        
            //$port_chart_value = $port_chart_value * $ir['return'];
            if(strtotime($ir['trade_date'])>= strtotime($start_date)){
                $months[] = $ir['trade_date'];
                $port_ret[] = $ir['return'];
                $bench_ret[] = $ir['benchmark_return'];
                
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
            
            
           //if($inst_num == 0){
                
            //} 
        }
        
        $return_all_time = $port_chart_value;
    
    if($inst_num == 0){
        $series[] = ['name'=> "Benchmark", 'data'=> $bench_data[$i]]; 
    }
    $series[] = ['name'=> $instrument['instrument'], 'data'=> $port_data[$i]];
    $i++;
 
    $allstats = Calculators::CalcAllStats1($port_ret, $bench_ret);
    
  $tbl_rows .=   
    '<tr>
        <td>'. $instrument['instrument'].'</td>
        <td>'. number_format(($return_all_time-1)*100, 1).'%</td>
        <td>'. number_format(($return_ytd-1)*100, 1).'%</td>
        <td>'. number_format(($return_3m-1)*100, 1).'%</td>
        <td>'. number_format(($return_6m-1)*100, 1).'%</td>
        <td>'. number_format(($return_9m-1)*100, 1).'%</td>
        <td>'. number_format(($return_1y-1)*100, 1).'%</td>
        <td>'. number_format($allstats[0]*100, 1).'%</td>
        <td>'. number_format($allstats[1], 3).'</td>
        <td>'. number_format($allstats[2], 3).'</td>
        <td>'. number_format($allstats[4], 3).'</td>
        <td>'. number_format($allstats[13], 3).'</td>
        <td>'. number_format($allstats[14], 3).'</td>
        <td>'. number_format($allstats[3], 3).'</td>
        <td>'. number_format($allstats[5], 3).'</td>
        <td>'. number_format($allstats[6], 3).'</td>
        <td>'. number_format($allstats[7], 3).'</td>
        <td>'. number_format($allstats[9], 3).'</td>
        <td>'. number_format($allstats[8], 3).'</td>
        <td>'. number_format($allstats[10], 3).'</td>
        <td>'. number_format($allstats[11], 3).'</td>
        <td>'. number_format($allstats[12], 3).'</td>
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
            minTickInterval: 30,
            categories: <?php echo json_encode($months);?>,
            //dateTimeLabelFormats: { // don't display the dummy year
                //month: '%b \'%y', //'%e. %b', '%b \'%y'
               // year: '%b'
           // },
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