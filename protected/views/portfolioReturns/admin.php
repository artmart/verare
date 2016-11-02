<?php $this->breadcrumbs=array('Portfolio Returns'=>array('index'),	'Manage',);?>

<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-info span5"><div class="flash-' . $key . '">' . $message . "</div></div>\n";
    }
?>

<div class="span1"></div>
<div class="span11">
    <h2>Time-weighted return calculation for selected portfolio</h2>
</div>

<div class="row-fluid"></div>
<div class="span1"></div>
<div class="span12">

<?php 
    $baseurl = Yii::app()->baseUrl;
    $portfolio_id = '';
    $dt = '';
    $where = ' 1 = 1 ';
    
    if(isset($_REQUEST['portfolio']) && !($_REQUEST['portfolio'] == '')){$portfolio_id = $_REQUEST['portfolio'];}

        
    //if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and p.trade_date >='$dt' "; }

    
    echo CHtml::beginForm('Admin','post'); 
?>







<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
    <?php
        echo CHtml::dropDownList('portfolio', $portfolio_id,  CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio'), array('empty' => '-- Select Portfolio --', 'class' => 'form-control input-md'  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
</div>

<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
<?php
/*
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'name'=>'dt',
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            //'onselect'=>'loaddata()'
        ),
        'htmlOptions'=>array('class' => 'form-control input-md',  'placeholder'=>'YYYY-MM-DD', ),
    ));
*/
?>
</div>
</div>


<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
<?php //echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/portfolioReturns/PortfolioReturnsCalc', 'class'=>"btn btn-primary"));?>
<?php echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/portfolioReturns/admin', 'class'=>"btn btn-primary"));?>
</div>
</div>
<br />
<?php echo CHtml::endForm(); ?>

</div>

<?php
$table_boady = '';
$id = Yii::app()->user->id;
$user_data = Users::model()->findByPk($id);
$client_id = $user_data->client_id;

//var_dump($portfolio_id);

//PortfolioReturnsUpdate($portfolio_id, $client_id, $portfolio_currency){  
        if($portfolio_id >0){
            $portfolios = Portfolios::model()->findByPk($portfolio_id);
            $portfolio_currency = $portfolios->currency;
        ini_set('max_execution_time', 50000);
        //$table_name = "client_".$client_id. "_inst_returns";
        
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
        //Trades // and (p.id = $portfolio_id or p.parrent_portfolio = $portfolio_id )
        $inst_sql = "select * from ledger l
                     inner join instruments i on l.instrument_id = i.id
                     inner join portfolios p on p.id = l.portfolio_id
                     where l.is_current = 1 and i.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' 
                     and p.id in ('$all_p_ids')
                     order by trade_date asc";
        $trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
        
        //var_dump($trades);
       // exit;
  
        if(count($trades)>0){
        
        foreach($trades as $trd){$ins_ids[] = $trd['instrument_id'];} 
        
        $insids = implode("','", array_unique($ins_ids));                         
                                
         //(port.id = $portfolio_id  or port.parrent_portfolio = $portfolio_id ) 
         //sum(p.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) sums   
         //sum((select  sum(p1.price*cr.SEK/curs.cur_rate*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date)) sums                   


/*  //with currencies//
$portfolio_return_sql = "select p.trade_date,
    sum((select sum(if(trade_date=p.trade_date, nominal*price*cr.{$portfolio_currency}/ledger.currency_rate, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id )) pnl,
    sum(p.price*cr.{$portfolio_currency}/curs.cur_rate * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id )) top, 
    sum((select sum(p1.price*cr.{$portfolio_currency}/curs.cur_rate*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date and bc.benchmark_id = port.benchmark_id))/sum(bc.weight) sums
    from prices p
    inner join ledger ldg on ldg.instrument_id = p.instrument_id
    inner join portfolios port on port.id = ldg.portfolio_id
    inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
    inner join currency_rates cr on cr.day = p.trade_date 
    
    inner join benchmarks bench on bench.id = port.benchmark_id and bench.client_id = ldg.client_id
    
    inner join instruments i on i.id = p.instrument_id
    inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
    
    where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' 
    and port.id in ('$all_p_ids') 
    group by  p.trade_date
    order by p.trade_date asc";
*/

 /*
$portfolio_return_sql = "select p.trade_date,
    (select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id ) pnl,
    sum(p.price * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id )) top, 
    sum((select sum(p1.price*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date and bc.benchmark_id = port.benchmark_id))/sum(bc.weight) sums
    from prices p
    inner join ledger ldg on ldg.instrument_id = p.instrument_id
    inner join portfolios port on port.id = ldg.portfolio_id
    inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
    inner join benchmarks bench on bench.id = port.benchmark_id and bench.client_id = ldg.client_id 
    inner join instruments i on i.id = p.instrument_id
    where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' 
    and port.id in ('$all_p_ids') 
    group by  p.trade_date
    order by p.trade_date asc";


$portfolio_return_sql = "select p.trade_date,
    (select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id ) pnl,
    p.price * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id and ledger.is_current = 1 and ledger.trade_status_id = 2 and ledger.client_id = ldg.client_id and port.id = portfolio_id ) top
     from prices p
    inner join ledger ldg on ldg.instrument_id = p.instrument_id
    inner join portfolios port on port.id = ldg.portfolio_id
    
    inner join instruments i on i.id = p.instrument_id
    where p.instrument_id in ('$insids') and ldg.client_id = '$client_id' 
    and port.id in ('$all_p_ids') 
    group by  p.trade_date
    order by p.trade_date asc";
 */   
  $portfolio_currency = 'SEK';
  
  $portfolio_return_sql = "select p.trade_date, 
                            if(c.trd is not NULL, c.trd, 0) pnl,  
                            if(sum(p.price * m.port_val) is not NULL, sum(p.price * m.port_val* cr.{$portfolio_currency}/curs.cur_rate), 0) top,
                            if(bc.weight is not NULL, sum(bc.ww)/sum(bc.weight), 0) sums
                            
                            from prices p 
                            inner join currency_rates cr on cr.day = p.trade_date
                            inner join instruments i on i.id = p.instrument_id
                            inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                                                        
                            left join
                            (select l.trade_date, sum(l.nominal*l.price * cr.{$portfolio_currency}/curs.cur_rate) trd 
                        		from ledger l
                                
                                inner join currency_rates cr on cr.day = l.trade_date
                            	inner join instruments i on i.id = l.instrument_id
                            	inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency
                                
                        		where l.is_current = 1 and l.trade_status_id = 2 
                        		and l.instrument_id in ('$insids') and l.client_id = '$client_id' and l.portfolio_id in ('$all_p_ids') 
                        		group by l.trade_date
                            ) c on c.trade_date = p.trade_date  
                            
                            left join
                            (
                                select  trade_date, instrument_id, sum(nominal) port_val 
                                from ledger 
                                where  is_current = 1 and trade_status_id = 2 
                                and instrument_id in ('$insids') and client_id = '$client_id' and portfolio_id in ('$all_p_ids') 
                                group by trade_date, instrument_id
                            ) m on m.trade_date <= p.trade_date and m.instrument_id = p.instrument_id
                                                        
                            left join
                            (
                            select bc.instrument_id, p.trade_date,  p.price* bc.weight * cr.{$portfolio_currency}/curs.cur_rate ww, bc.weight
                            from benchmark_components bc 
                            inner join benchmarks bench on bench.id = bc.benchmark_id 
                            inner join portfolios port on port.benchmark_id = bench.id
                            inner join prices p on p.instrument_id = bc.instrument_id
                            
                            inner join currency_rates cr on cr.day = p.trade_date
                        	inner join instruments i on i.id = p.instrument_id
                        	inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                            
                            where port.id ='$portfolio_id'
                            ) bc on  bc.trade_date = p.trade_date
                            
                            where p.instrument_id in ('$insids') 
                            group by p.trade_date order by p.trade_date asc";  
    
    
    
    
    
    
    
    
    //sum((select sum(p1.price*bc.weight) from prices p1 where p1.instrument_id = bc.instrument_id and p1.trade_date = p.trade_date and bc.benchmark_id = port.benchmark_id))/sum(bc.weight) sums
   
    //inner join benchmark_components bc on bc.benchmark_id = port.benchmark_id
    //inner join benchmarks bench on bench.id = port.benchmark_id and bench.client_id = ldg.client_id 
        //  echo $portfolio_return_sql;
         // exit;                      
                                //port.id = '$portfolio_id'
                                //inner join benchmark_components bc on bc.instrument_id = p.instrument_id 
                                //inner join ledger l on l.instrument_id = p.instrument_id
                                //inner join benchmarks b on b.portfolio_id = l.portfolio_id
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $portfolio_returns = Yii::app()->db->createCommand($portfolio_return_sql)->queryAll(true);
        
        //var_dump($portfolio_returns);
        //exit;
        
        if(count($portfolio_returns)>0){
        $i = 0;
        
        //for benchmarks//
        $return1[$i] = 1;
        //$return_bench = 1;
        //$return_bench_daily[] = 1;
        ////////////////////////
        $return2[$i] = 1;
        
        foreach($portfolio_returns as $price){
            $rawData[$i]['id'] = $i;    
            $rawData[$i]['trade_date'] = $price['trade_date'];
            $rawData[$i]['top'] = $price['top'];
            $rawData[$i]['pnl'] = $price['pnl'];
            $rawData[$i]['return'] = 1;  
            
            ////For Benchmark///////
            $sums[$i] = $price['sums'];
            $rawData[$i]['benchmark_return'] = 1;
            ////////////////////////
            $return1[$i] = 1;
            $return2[$i] = 1;
                        
            if($i>0){ 
                    ////For Benchmark///////
                   if($sums[$i-1]> 0){$return1[$i] = $price['sums']/$sums[$i-1];}
                    //$return_bench = $return_bench * $return1[$i];
                    $rawData[$i]['benchmark_return'] = $return1[$i];
                    ////////////////////////
                    
                    //Portfolio return//
                    $div = $rawData[$i-1]['top'] + $rawData[$i]['pnl'];
                    if($div>0){$rawData[$i]['return'] = $rawData[$i]['top']/$div;}
                    //$return2[$i] = $return1[$i-1]* $rawData[$i]['return'];
               }
         
         
         $table_boady .= '<tr>
                            	<td>'.$rawData[$i]['trade_date']. '</td>
                            	<td>'.$rawData[$i]['return'].'</td>	
                                <td>'.$rawData[$i]['benchmark_return'].'</td>
                            </tr>'; 
         
        
              //checking if the return for current instrument is not exist and inserting the calculated return.//
              /*
               $existing_return  = PortfolioReturns::model()->findByAttributes([
                                                                                'portfolio_id'=>$portfolio_id, 
                                                                                'trade_date' =>$rawData[$i]['trade_date'], 
                                                                                //'is_prtfolio_or_group' =>1,
                                                                                //'return' =>$rawData[$i]['return'],
                                                                                //'benchmark_return' => $rawData[$i]['benchmark_return']
                                                                                ]);
               
                   if(count($existing_return)==0){
                       $return = new PortfolioReturns;
                       $return->portfolio_id = $portfolio_id;
                       $return->is_prtfolio_or_group = 1;
                       $return->trade_date = $rawData[$i]['trade_date'];
                       $return->return = $rawData[$i]['return'];
                       $return->benchmark_return = $rawData[$i]['benchmark_return'];
                       $return->save(); 
                   }else{
                           $existing_return->return = $rawData[$i]['return'];
                           $existing_return->benchmark_return = $rawData[$i]['benchmark_return'];
                           $existing_return->save(); 
                        }
                        */
               $i++;
               }     
          }else{
                ///portfolio return is empty////
                //Yii::app()->user->setFlash('notice', "There are not confirmed trades available aor prices not found.");
                //Yii::app()->user->setFlash('success', "Data1 saved!");
                //Yii::app()->user->setFlash('error', "Data2 failed!"); 
               // foreach(Yii::app()->user->getFlashes() as $key => $message) {
                //    echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
                //}
                //exit;       
              }  
        }else{
                ///treades are not found//
                Yii::app()->user->setFlash('notice', "Ledgar information not found.");
            }
        }    
      //  Yii::app()->user->setFlash('success', "Portfolio returns updated.");
        //$this->redirect('admin');       
    














/*
$this->menu=array(
	array('label'=>'List PortfolioReturns', 'url'=>array('index')),
	array('label'=>'Create PortfolioReturns', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#portfolio-returns-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row-fluid"></div>
<h1>Manage Portfolio Returns</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'portfolio-returns-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'portfolio_id',
		'is_prtfolio_or_group',
		'trade_date',
		'return',
        'benchmark_return',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
*/

//var_dump($table_boady);
?>

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- page script    class="display"
            
            
            -->
         
                
                
                
                
                
       <table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>trade_date</th>
                <th>return</th>
                <th>benchmark_return</th>
            </tr>
        </thead>

        <tbody>
        <?php echo $table_boady; ?>
       </tbody>
    </table>         
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

<script>

$(document).ready(function() {
    $('#example').DataTable( {
         renderer: "bootstrap",
        
        dom: 'lBfrtip',
        
        filter: true,
        paginate: true,
        sort:true,
        info: false,
   
        bJQueryUI: false,
        bProcessing: false,
        
        buttons: [
            /*{ extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },*/
            <?php //echo $access_buttons; ?>
            {
                extend: 'copyHtml5',
                //exportOptions: {
                  //  columns: [ 0, ':visible' ]
                //}
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                //exportOptions: {
                //    columns: [ 0, 1, 2, 5 ]
                //}
            },
            { extend: 'colvis', collectionLayout: 'fixed two-column',},
           
            
        ], 
    } );
} );
</script>