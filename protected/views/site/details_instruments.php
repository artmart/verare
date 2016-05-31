<?php
    $this->pageTitle=Yii::app()->name; 
    $baseUrl = Yii::app()->baseUrl;
    $portfolio_id = $_REQUEST['portfolio'];
    $client_id = $_REQUEST['client_id'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
        
    $table_name = "client_".$client_id. "_inst_returns";
    $portfolios = Portfolios::model()->findByPk($portfolio_id);
    $portfolio_currency = $portfolios->currency;

    $month_ytd_start = date('Y-01-01');
    $month3_start = date( "Y-m-d", strtotime( "-3 month" ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month" ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month" ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years" ));
        
    $instruments_query = "select distinct i.id, i.instrument from instruments i inner join ledger l on l.instrument_id = i.id 
                          where l.is_current=1 and l.trade_status_id = 2 and l.portfolio_id = '$portfolio_id' and l.client_id = '$client_id'  ";
    $instruments = Yii::app()->db->createCommand($instruments_query)->queryAll(true);
       
    $tbl_rows = '';
    $inst_num = 0;
    $bench_chart_value = 1;
    $months = [];
    $series = [];
    
    foreach($instruments as $instrument){
            $instrument_id = $instrument['id'];
        
            $sql_returns = "select r.trade_date, r.{$portfolio_currency} `return`, pr.benchmark_return 
                            from {$table_name} r 
                            inner join portfolio_returns pr on pr.trade_date = r.trade_date
                            where r.instrument_id = '$instrument_id'
                            and pr.portfolio_id = '$portfolio_id'
                            and r.trade_date > '$start_date' and r.trade_date<'$end_date'
                            order by r.trade_date";
            $instrument_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
   
    if($instrument_results){
        
        $port_chart_value = 1;
        
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_9m = 1;
        $return_1y = 1;
        
        foreach($instrument_results as $ir){
            
            $months[] = $ir['trade_date'];
            $port_ret[] = $ir['return'];
            $bench_ret[] = $ir['benchmark_return'];
            
            $port_chart_value = $port_chart_value * $ir['return'];
            if($inst_num == 0){
                $bench_chart_value = $bench_chart_value * $ir['benchmark_return'];
            }          
            
            if(strtotime($ir['trade_date'])>= strtotime($month_ytd_start)){$return_ytd = $return_ytd * $ir['return'];}
            if(strtotime($ir['trade_date'])>= strtotime($month3_start)){$return_3m = $return_3m * $ir['return'];}
            if(strtotime($ir['trade_date'])>= strtotime($month6_start)){$return_6m = $return_6m * $ir['return'];}
            if(strtotime($ir['trade_date'])>= strtotime($month9_start)){$return_9m = $return_9m * $ir['return'];}
            if(strtotime($ir['trade_date'])>= strtotime($month1y_start)){$return_1y = $return_1y * $ir['return'];}
            
            $port_data[] = [$ir['trade_date'], floatval($port_chart_value)];
            if($inst_num == 0){
                $bench_data[] = [$ir['trade_date'], floatval($bench_chart_value)];  
            } 
        }
        
        $return_all_time = $port_chart_value;
    
    if($inst_num == 0){
        $series[] = ['name'=> "Benchmark", 'data'=> $bench_data]; 
    }
    $series[] = ['name'=> $instrument['instrument'], 'data'=> $port_data];
 
 
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
            min: 0.2,
            max: 1.9
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
        
        //colVis: { exclude: [ 1 ] },
        //dom: 'C&gt;"clear"&lt;lfrtip"clear"Bfrtip',
        //ajax: "ledger/ledger",
       // columns: [
        /*
            { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return data.first_name+' '+data.last_name;
            } },
        *//*
            { data: "ledger.trade_date" },
            //{ data: "ledger.instrument_id" },
            { data: "instruments.instrument" },
            //{ data: "ledger.portfolio_id" },
            { data: "portfolios.portfolio" },
            { data: "ledger.nominal" },
            { data: "ledger.price", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
            { data: "ledger.created_at" },
            { data: "prof1.firstname" },
            { data: "prof2.firstname" },
            { data: "ledger.confirmed_at" },
            //{ data: "ledger.document_id" },
            { data: "trade_status.trade_status", editField: "ledger.trade_status_id", className: 'editable'    },
           // { data: "documents.file" },
            { data: "ledger.note" },
            { data: "trade_code" },
            
            {
                data: "documents",
                defaultContent: '',
                render: function(data, type, row) {
                    if(data.document_name){
                       return "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>";
                    }else{
                        return null;
                    }
                 // return data.document_name ? "<a href='../uploads/"+data.file +"."+data.extension+"' target='_Blank'>"+ data.file+"."+data.extension+"</a>": null; // data.file +"."+data.extension: null; // '<a href="/uploads/' + data.file +"."+data.extension '" onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\'); return false;">' + data.document_name + '</a>' : null;
                
                }
              },
            
            /* 
            {
                data: "",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+table.file( 'documents', file_id ).web_path+'"/>' :
                        null;
                },
                defaultContent: "No Document",
                title: "Document"
            },
           */
            
       // ],
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

/*
      table.on( 'select', function ( e, dt, type, indexes ) {
		if ( type === 'row' ) {
			var data = table.cells(indexes,0).data(); // table.rows( indexes ).data().pluck( 'trade_status.trade_status' );            
		}
	} );
*/

</script>






