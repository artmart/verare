<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<?php 
    $this->pageTitle=Yii::app()->name; 
    $portfolio = 1;
    $start_date = '2015-01-01';
    $end_date = '2016-01-01';
    $baseUrl = Yii::app()->baseUrl;
    //var_dump($baseUrl);
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
        'id'=>'start_date',
        'value' => $start_date,
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        //'cssFile' => 'jquery-ui-1.9.2.custom.css',
        'options'=>[
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            'onselect'=>'loaddata()',
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
        'id'=>'end_date',
        'value' =>$end_date,
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        //'cssFile' => 'jquery-ui-1.9.2.custom.css',
        'options'=>[
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            'onselect'=>'loaddata()',
        ],
        'htmlOptions'=>['placeholder'=>'YYYY-MM-DD'],
    ]);

?>
</div>
<div class="span1">Portfolio:</div>           
<div class="span2">
    <?php
    $list = CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio');
    echo CHtml::dropDownList('portfolio', $portfolio,  $list, [ 'id' => 'portfolio', 'empty' => '-- Select --',  'onchange'=>'loaddata()', /*'multiple' => true, 'size'=>'10'*/]);

   
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
  }
  
 ?>
</div>
<!--<div id="overview"></div>-->          
           
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
					       <div class="scrollit">
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
								<td>Portfolio</td>
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
						</div>	  
                      </div><!-- /.chart-responsive -->
					  
                    </div><!-- /.col -->
					
                    <div class="col-md-4">
					  <!--<canvas id="pieChart" height="250"></canvas>-->
                      <?php //$this->renderPartial('/site/pia_chart', []);?>                   
                     
                      <?php
                      
                    $level1 = array();
                    $level1[] = array('name' => 'GroupOne', 'y' => 11, 'drilldown' => 'dd1');
                    $level1[] = array('name' => 'GroupTwo', 'y' => 22, 'drilldown' => 'dd2');
                    $level1[] = array('name' => 'GroupThree', 'y' => 33, 'drilldown' => 'dd3');
                     
                    $level2 = array();
                    $level2[] = array('id' => 'dd1', 'data' => array(array('Detail1', 1), array('Detail2', 2), array('Detail3', 4)));
                    $level2[] = array('id' => 'dd2', 'data' => array(array('Detaila', 8), array('Detailb', 9), array('Detailc', 3)));
                    $level2[] = array('id' => 'dd3', 'data' => array(array('DetailX', 7), array('DetailY', 5), array('DetailZ', 6)));
                     
                    $this->Widget('ext.highcharts.HighchartsWidget', array(
                            'scripts' => array(
                            'modules/drilldown', // in fact, this is mandatory :)
                            ),
                        'options'=>array(
                            'colors'=>['#6AC36A', '#FFD148', '#0563FE', '#FF2F2F', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
                            'chart' => array('type' => 'pie'),
                            'title' => array('text' => 'Levels 1 and 2'),
                            'subtitle' => array('text' => 'Click the columns to view details.'),
                            'xAxis' => array('type' => 'category'),
                            'yAxis' => array('title' => array('text' => 'Vertical legend',)),
                            'legend' => array('enabled' => false),
                            'plotOptions' => array (
                                'series' => array (
                                                'borderWidth' => 0,
                                                'dataLabels' => array(
                                                    'enabled' => true,
                                                ),
                                            ),
                                        ),
                            'series' => array (array(
                                            'name' => 'MyData',
                                            'colorByPoint' => true,
                                            'data' => $level1,
                                        )),
                            'drilldown' => array(
                                            'series' => $level2,
                                        ),
                        ),
                    ));
                 
                      
                      /*
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
                      */
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
$(document).ready(function ($) {loaddata();})

    function loaddata(){
    	$.ajax({
    			type: 'post',
    			url: '<?php //echo $baseUrl;?>/site/overviewLoad', 
    			data: {
                start_date: $('#start_date').val(), 
                end_date: $('#end_date').val(),
                portfolio: $('#portfolio').val(),
    			},
    			success: function (response) {
    			// We get the element having id of display_info and put the response inside it
    			$( '#overview' ).html(response);
    			}
    		   });
              //loadtable();        
    }
*/
</script>	

