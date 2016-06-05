<?php
    //$this->pageTitle=Yii::app()->name; 
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    
    $end_date = Date('Y-m-d');
	$start_date = date('Y-m-d', strtotime('-1 years'));
    if(isset($user_data->default_start_date) && $user_data->default_start_date!=='0000-00-00'){$start_date = $user_data->default_start_date;}
    if(isset($user_data->default_end_date) && $user_data->default_end_date!=='0000-00-00'){$end_date = $user_data->default_end_date;}
    
    $client_id = $user_data->client_id;
    $baseUrl = Yii::app()->baseUrl;
        
    $month_ytd_start = date('Y-01-01');
    $month3_start = date( "Y-m-d", strtotime( "-3 month" ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month" ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month" ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years" ));
    
     $accessable_portfolios1 = $user_data->accessable_portfolios;   
     $accessable_portfolios = implode("', '", explode(",", $accessable_portfolios1));
    
     $portfolios = Yii::app()->db->createCommand("select * from portfolios where id in ('$accessable_portfolios')")->queryAll(true);
        
    $months = [];  
    $series = []; 
    $tbl_rows = '';
    foreach($portfolios as $portfolio){
        $portfolio_id = $portfolio['id'];
        
    $sql_returns = "select * from portfolio_returns where portfolio_id = '$portfolio_id' and trade_date > '$start_date' and trade_date<'$end_date' order by trade_date";
    $portfolio_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
       
    if($portfolio_results){
        
        $port_chart_value = 1;
        $bench_chart_value = 1;
        
        $return_all_time = 1;
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_9m = 1;
        $return_1y = 1;
        
        foreach($portfolio_results as $pr){
            
            $months[] = $pr['trade_date'];
            $port_ret[] = $pr['return'];
            $bench_ret[] = $pr['benchmark_return'];
            
            $port_chart_value = $port_chart_value * $pr['return'];
            $bench_chart_value = $bench_chart_value * $pr['benchmark_return'];          
            
            if(strtotime($pr['trade_date'])>= strtotime($month_ytd_start)){$return_ytd = $return_ytd * $pr['return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month3_start)){$return_3m = $return_3m * $pr['return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month6_start)){$return_6m = $return_6m * $pr['return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month9_start)){$return_9m = $return_9m * $pr['return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month1y_start)){$return_1y = $return_1y * $pr['return'];}
            
            $port_data[] = [$pr['trade_date'], floatval($port_chart_value)];
            $bench_data[] = [$pr['trade_date'], floatval($bench_chart_value)];   
        }
        
        $return_all_time = $port_chart_value;
    
    $series[] = ['name'=> $portfolio['portfolio'], 'data'=> $port_data];
    $series[] = ['name'=> $portfolio['portfolio']."-benchmark", 'data'=> $bench_data]; 
 
    $allstats = Calculators::CalcAllStats1($port_ret, $bench_ret);
   
  $tbl_rows .=   
    '<tr>
        <td>'. $portfolio['id'].'</td>
        <td>'. $portfolio['portfolio'].'</td>
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
}
$months = array_unique($months);

?>
<div id="results-view1">
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
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
</div>
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

      table.on( 'select', function ( e, dt, type, indexes ) {
		if ( type === 'row' ) {
			var data = table.cells(indexes,0).data(); // table.rows( indexes ).data().pluck( 'trade_status.trade_status' );

            instrumentsresultsload(data[0]);
           
		}
	} );

    function instrumentsresultsload(port){
    	$.ajax({
    			type: 'post',
    			url: '<?php echo Yii::app()->baseUrl.'/site/instrumentsresultsload'; ?>',
    			data: {
        			 portfolio: port,
                     client_id: <?php echo $client_id;?>,
                     start_date: <?php echo json_encode($start_date); ?>,
                     end_date: <?php echo json_encode($end_date); ?>
    			},
    			success: function (response) {
    			     $( '#results-view1' ).html(response);
    			}
    		   });
    }
</script>





