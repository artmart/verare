<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>-->

<?php 
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    $this->pageTitle=Yii::app()->name; 
    $baseUrl = Yii::app()->baseUrl;
    
    if(isset($user_data->default_portfolio_id)){$portfolio = $user_data->default_portfolio_id;}
    //if(isset($_POST['portfolio'])){$portfolio = $_POST['portfolio'];}
    
   	$end_date = Date('Y-m-d');
	$start_date = date('Y-m-d', strtotime('-1 years'));
    if(isset($user_data->default_start_date)){$start_date = $user_data->default_start_date;}
    if(isset($user_data->default_end_date)){$end_date = $user_data->default_end_date;}
    //if(isset($_POST['start_date'])){$start_date = date_format(date_create($_POST['start_date']),"Y-m-d");}
    //if(isset($_POST['end_date'])){$end_date = date_format(date_create($_POST['end_date']),"Y-m-d");}
?>

<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 class="span1">Details</h1>


<?php     
    $returns = Calculators::ReturnAllAndYTD($portfolio);
    $pnl = Calculators::PNL($start_date, $end_date, $portfolio);
    
    $portfolio_composition_sql = "select ig.group_name, i.instrument_group_id, p.portfolio, ig.allocation_min, ig.allocation_max, ig.allocation_normal, sum(l.nominal*l.price) nav  from ledger l
                            inner join instruments i on i.id = l.instrument_id
                            inner join portfolios p on p.id = l.portfolio_id
                            left join instrument_groups ig on ig.id = i.instrument_group_id
                            where l.portfolio_id = 1 and l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                            group by ig.group_name, i.instrument_group_id, p.portfolio, ig.allocation_min, ig.allocation_max, ig.allocation_normal";
    $portfolio_composition = Yii::app()->db->createCommand($portfolio_composition_sql)->queryAll(true);
    
    $sql_table1 = "select ig.group_name, i.instrument_group_id, p.portfolio, i.instrument, ig.allocation_min, ig.allocation_max, ig.allocation_normal, sum(l.nominal*l.price) nav from ledger l
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios p on p.id = l.portfolio_id
                    left join instrument_groups ig on ig.id = i.instrument_group_id
                    where l.portfolio_id = 1 and l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                    group by ig.group_name, i.instrument_group_id, p.portfolio, i.instrument, ig.allocation_min, ig.allocation_max, ig.allocation_normal";
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
              <div class="box box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolio</h3>
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
                    
                    
 <?php       
        $return = 1;
        $months = [];
        $returns_portfolio_daily = [];
        $returns_portfolio = [];
        $sql_portfolio = " select * from portfolio_returns where portfolio_id = '$portfolio' and trade_date > '$start_date' and trade_date<'$end_date' order by trade_date asc";
        $portfolio_returns = Yii::app()->db->createCommand($sql_portfolio)->queryAll(true);
        foreach($portfolio_returns as $pr){
            $return = $return * $pr['return'];
            
            $returns_portfolio[] = floatval($return); 
            $returns_portfolio_daily[] = $pr['return'];
            $months[] = $pr['trade_date'];    
        }
        
       //Benchmark returns 
        $sql_benchmark = "select p.trade_date, sum(p.price*bc.weight) sums from benchmarks b
                            inner join benchmark_components bc on bc.benchmark_id = b.id
                            inner join instruments i on i.id = bc.instrument_id and bc.is_instrument_or_portfolio = 0
                            inner join prices p on p.instrument_id = i.id
                            where b.portfolio_id = '$portfolio' and p.trade_date > '$start_date' and p.trade_date<'$end_date'
                            group by p.trade_date asc";
        $benchmark_sums = Yii::app()->db->createCommand($sql_benchmark)->queryAll(true);

        $return1[0] = 1;
        $return_bench = 1;
        $return_bench_daily[] = 1;
        $p = 0;
        foreach($benchmark_sums as $bs){
            $sums[$p] = $bs['sums'];
            if($p>0){
                $return1[$p] = $bs['sums']/$sums[$p-1];
                $return_bench = $return_bench * $return1[$p];
                $return_bench_daily[] = floatval($return_bench * $return1[$p]);
            } 
            $p++;  
        }
        
        $enddate = min($end_date, end($months));
        $dttmp = date_parse($enddate);
        $dtytd = $dttmp['year'] . "-01-01";
        $dt3m=$this->my_date_format($enddate,"-3 months");
        $dt6m=$this->my_date_format($enddate,"-6 months");
        $dt9m=$this->my_date_format($enddate,"-9 months");
        $dt1y=$this->my_date_format($enddate,"-12 months");
        
        $portfolio_volatility = PHPExcel_Calculation_Statistical::STDEV($returns_portfolio_daily)*sqrt(240);
        $portfolio_avg = PHPExcel_Calculation_Statistical::AVERAGE($returns_portfolio_daily);
        
        $sql_1 = " select * from portfolio_returns where portfolio_id = '$portfolio' and 
                    (trade_date = '$dtytd' or trade_date = '$dt3m' or trade_date = '$dt6m' or trade_date = '$dt9m' or trade_date = '$dt1y' or trade_date = '$enddate' or trade_date = '$start_date')";
        $portfolio_1 = Yii::app()->db->createCommand($sql_1)->queryAll(true);
        
        $return_start = 1; //???
        $return_end = 1; //??
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_1y = 1;
        foreach($portfolio_1 as $p1){
            if($p1['trade_date'] == $dtytd){$return_ytd = $p1['return'];}
            if($p1['trade_date'] == $dt3m){$return_3m = $p1['return'];}
            if($p1['trade_date'] == $dt6m){$return_6m = $p1['return'];}
            if($p1['trade_date'] == $dt9m){$return_9m = $p1['return'];}
            if($p1['trade_date'] == $dt1y){$return_1y = $p1['return'];}
            if($p1['trade_date'] == $enddate){$return_end = $p1['return'];}
            if($p1['trade_date'] == $start_date){$return_start = $p1['return'];}
        }
        $xA=$return_end/$return_start-1;
        
        //$xB=$this->GetVolatility($dateStart, $dateEnd, $iN);      
 ?> 

<?php                                     
  //$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  $series[] = ['name' => 'Portfolio', 'data' => $returns_portfolio];
  $series[] = ['name' => 'Benchmark', 'data' => $return_bench_daily]; 
  $this->Widget('ext.highcharts.HighchartsWidget', [
       'options'=>[
    	  'title' => ['text' => ''],
    	  'xAxis' => ['categories' => $months, 'minTickInterval' =>30, 'type' => 'datetime', 'title' => ['text'=> null], 'labels' => ['enabled' => true]],
    	  'yAxis' => ['title' => ['text' => ''], 'min' => 0.9, 'max'=>1.35],
    	  'chart' => ['type'=>'spline', 'plotBackgroundColor' => '#ffffff', 'plotBorderWidth' => null, 'plotShadow' => false, 'height' => 300],
          'plotOptions'=> [
                'spline'=> [
                    'lineWidth'=> 2,
                    'states'=> [
                        'hover'=> [
                            'lineWidth'=> 5
                        ]
                    ],
                    'marker'=> [
                        'enabled'=> false
                    ],
                   // 'pointInterval'=> 3600000, // one hour
                   //'pointStart'=> Date.UTC(2015, 4, 31, 0, 0, 0)
                ]
            ],
    	  'colors'=> ['#104E89', '#952C28', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
    	  'credits' => ['enabled' => false],
    	  'series' => $series,
       ]
    ]);                                
?>
                </div><!-- ./box-body -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
<?php /*		  
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
                    
    <table id='tablePerformance' class='table table-bordered table-hover'>
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
            <tr> 
                <td>Portfolio</td>
                <td><?php echo number_format(($return_end/$return_start-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1);?>%</td>
                <td><?php echo number_format(($return_end/$return_3m-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php echo number_format($portfolio_volatility*100, 1); ?>%</td>
                <td><?php if(!($portfolio_volatility==0)){echo number_format(($portfolio_avg-1)*100/$portfolio_volatility, 1);}else{echo "N/A";} ?>%</td>
            </tr>
            <tr> 
                <td>Benchmark</td>
                <td><?php echo number_format($xA*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1);?>%</td>
                <td><?php echo number_format(($return_end/$return_3m-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php echo number_format(($return_end/$return_ytd-1)*100, 1); ?>%</td>
                <td><?php //echo number_format($xB*100, 1); ?>%</td>
                <td><?php //echo number_format($xA/$xB, 1); ?>%</td>
            </tr>

            </tbody>
            </table>
                                   
          </div><!-- /.chart-responsive -->
        </div><!-- /.col -->
		
      </div><!-- /.row -->
      <div class="row">
        <div class="col-md-12">
		  <!--<canvas id="areaChart" height="200"></canvas>-->

                    </div><!-- /.col -->
                  </div><!-- /.row -->
					  
                </div><!-- ./box-body -->
				
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
*/
?>		  	
         
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

