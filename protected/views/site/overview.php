<?php 
    $this->pageTitle=Yii::app()->name; 
    $portfolio = 1;
    $start_date = '2015-01-01';
    $end_date = '2016-01-01';
?>

<h3> <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>

        <!-- Content Header (Page header) -->

        <section class="content-header">
          <h1 class="span1">Overview
            <small>
                <?php
                  //  echo $_SESSION["company"];
                ?> 
            </small>
          </h1>
<div class="span1">Start Date:</div>           
<div class="span2">
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker',[
        'name'=>'start_date',
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        //'cssFile' => 'jquery-ui-1.9.2.custom.css',
        'options'=>[
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            //'onselect'=>'loaddata()'
        ],
        'htmlOptions'=>['placeholder'=>'YYYY-MM-DD'],
    ]);

?>
</div>
<div class="span1">End Date:</div>           
<div class="span2">
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker',[
        'name'=>'end_date',
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        //'cssFile' => 'jquery-ui-1.9.2.custom.css',
        'options'=>[
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            //'onselect'=>'loaddata()'
        ],
        'htmlOptions'=>['placeholder'=>'YYYY-MM-DD'],
    ]);

?>
</div>
<div class="span1">Portfolio:</div>           
<div class="span2">
    <?php
    $list = CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio');
    echo CHtml::dropDownList('portfolio', $portfolio,  $list, ['empty' => '-- Select --',  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/]);
    
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    
    $sql_table1 = "select pt.portfolio_type, p.portfolio, i.instrument, pt.allocation_min, pt.allocation_max, pt.allocation_normal, l.nominal*l.price nav from ledger l
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios p on p.id = l.portfolio_id
                    left join portfolio_types pt on pt.id = p.type_id
                    where l.portfolio_id = 1 and l.trade_date > '$start_date' and l.trade_date<'$end_date' and l.portfolio_id = '$portfolio' 
                    group by pt.portfolio_type, p.portfolio, i.instrument, pt.allocation_min, pt.allocation_max, pt.allocation_normal";
    $table1_results = Yii::app()->db->createCommand($sql_table1)->queryAll(true);
    $returns = Calculators::ReturnAllAndYTD($portfolio);
    $pnl = Calculators::PNL($start_date, $end_date, $portfolio);
    
    
    $inst_data = '';
    $index_value = 0;
    
    foreach($table1_results as $pc){
        $index_value = $index_value + $pc['nav'];
        $inst_data .= 
							  '<tr>
								<td>'.$pc['instrument'].'</td>
								<td>'.number_format($pc['nav']).'</td>
								<td>'.number_format($pc['nav']/$pnl[1], 1).'%</td>
								<td>'.number_format($pc['allocation_normal'], 1).'%</td>
								<td>'.number_format($pc['allocation_normal']-$pc['nav']/$pnl[1], 1).'%</td>
								<td>'.number_format($pc['allocation_min']).'-'.number_format($pc['allocation_max']).'%</td>
							  </tr>';                         
  } ?>
</div>
             
            
            <!--
                    <ol class="breadcrumb">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                             //       echo $_SESSION["nowPort"];
                                ?>
                             <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                         //           foreach($_SESSION["portfolios"] as $p)
                         //           {
                          //              echo "<li><a href='#'>" . $p. "</a></li>";
                          //          }
                                ?> 
                                <li class="divider"></li>
                                <li><a href="#">Settings </a></li>
                                <li><a href="v_recalc.php">ReCalc</a></li>
                                <li class="divider"></li>
                                <li><a href="v_disconnect.php">Logout </a></li>
                            </ul>
                        </li>
                    </ol>
            -->
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
                                  //$pnl = GetPnL($dtmax,'Index',$_SESSION['company']);
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
					  
						  <table id="tableOverview" class="table table-bordered table-hover">
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
								<td>Index</td>
								<td><?php echo number_format($index_value); ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							  </tr>
                              <?php echo $inst_data; //$pdata=GetCompositionTable($dtmax, $_SESSION['company'], $index_nav_num); 
                              
                              ?>
							<tbody>
						  </table>
							  
                      </div><!-- /.chart-responsive -->
					  
                    </div><!-- /.col -->
					
                    <div class="col-md-4">
					  <!--<canvas id="pieChart" height="250"></canvas>-->
                      <?php
                      $data1 = [ ['Equities', 50],
                                  ['Rates', 40],
                                  ['Alternatives', 10]
                                ];
                      $this->Widget('ext.highcharts.HighchartsWidget', array(
                        'options' => [
                          'colors'=>['#6AC36A', '#FFD148', '#0563FE', '#FF2F2F', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
                          'gradient' => ['enabled'=> true],
                          'credits' => ['enabled' => false],
                          'exporting' => ['enabled' => false],
                          'chart' => ['plotBackgroundColor' => '#ffffff', 'plotBorderWidth' => null, 'plotShadow' => false, 'height' => 300],
                          'title' => false,
                          'tooltip' => [
                    		//'pointFormat' =>array('Value'=> 'point.y:,.0f'),
                            // 'pointFormat' => '{series.name}: <b>{point.percentage}%</b>',
                            //'percentageDecimals' => 1,
                            'formatter'=> 'js:function() { return this.point.name+":  <b>"+ this.y.toFixed(2).replace(/(\d)(?=(\d{3})+\b)/g,"$1,")+"</b><br/>percent: <b>" +this.point.percentage.toFixed(2)+"</b>%"; }',
                            //the reason it didnt work before was because you need to use javascript functions to round and refrence the JSON as this.<array>.<index> ~jeffrey
                          ],
                          'plotOptions' => [
                            'pie' => ['allowPointSelect' => true, 'cursor' => 'pointer', 
                    					   'dataLabels' => ['enabled' => true, 'color' => '#AAAAAA', 'connectorColor' => '#AAAAAA'],
                    					   'showInLegend'=>true,
                            ]
                          ],
                          'series' => [['type' => 'pie', 'name' => 'Percentage', 'data' => $data1]],
                        ]
                      ));
                      ?>
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
					            //echo GetDetailsTableSimple(array("Index", "Benchmark"), $dtmin, $dtmax);
					        ?>
					        
                      </div><!-- /.chart-responsive -->
                    </div><!-- /.col -->
					
					
                  </div><!-- /.row -->
                  <div class="row">
                    <div class="col-md-12">
					  <!--<canvas id="areaChart" height="200"></canvas>-->
                      	<?php 
                        
                          $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                          $series[] = ['name' => 'Index', 'data' => [5, 6, 7, 10, 20, 8, 3, 4, 9, 6, 11, 2]];
                          $series[] = ['name' => 'Benchmark', 'data' => [7, 4, 8, 2, 7, 6, 7, 1, 1, 2, 8, 9]]; 
                          $this->Widget('ext.highcharts.HighchartsWidget', [
                        		   'options'=>[
                        			  'title' => ['text' => ''],
                        			  'xAxis' => ['categories' => $months, 'type' => 'datetime', 'title' => ['text'=> null], 'labels' => ['enabled' => true]],
                        			  'yAxis' => ['title' => ['text' => ''], 'min' => 0],
                        			  'chart' => ['type'=>'spline', 'plotBackgroundColor' => '#ffffff', 'plotBorderWidth' => null, 'plotShadow' => false, 'height' => 300],
                        			  'colors'=> ['#6AC36A', '#FFD148', '#0563FE', '#FF2F2F', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
                        			  'credits' => ['enabled' => false],
                        			  'series' => $series,
                        		   ]
                        		]);
                        ?>
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
    /*
      $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         *//*
		 
		 
        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);
        

        <?php
            //echo GetDetailsChart("areaChartData", array("Index", "Benchmark"));
        ?>


        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: false,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: false,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: false,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true
        };

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions);

		 
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);

          <?php //echo $pdata; ?>

        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 30, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        //pieChart.Doughnut(PieData, pieOptions);
        pieChart.Pie(PieData, pieOptions);

      });
      */
    </script>
	

