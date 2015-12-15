<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>
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

        
    if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and p.trade_date >='$dt' "; }

    $this->beginWidget('zii.widgets.CPortlet', array('title'=>"Selection",));
    echo CHtml::beginForm('portfolioReturns','post'); 
?>
<div class="span3">
    <?php
        echo CHtml::dropDownList('portfolio', $portfolio_id,  CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio'), array('empty' => '-- Select Instrument --',  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
<div class="span3">
<?php

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
        'htmlOptions'=>array('style'=>'height:20px;', 'placeholder'=>'YYYY-MM-DD', ),
    ));

?>
</div>
<div class="span1">
<?php echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/prices/PortfolioReturns', 'class'=>"btn btn-primary"));?>
</div>
<br />
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>	
</div>

<div>
<?php 
ini_set('max_execution_time', 50000);

//update ledgar for total nominals//
/*
$update_nominals_sql = "UPDATE ledger t1
                        INNER JOIN 
                        			(select l.instrument_id, l.trade_date, 
                        			(select sum(if(trade_date<=l.trade_date, nominal, 0)) from ledger where instrument_id = l.instrument_id) nominal
                        			from ledger l group by instrument_id, trade_date) t2 
                        ON t2.instrument_id = t1.instrument_id and t1.trade_date = t2.trade_date
                        SET t1.total_nominal = t2.nominal where t1.total_nominal = 0";
                    
Yii::app()->db->createCommand($update_nominals_sql)->execute();
*/

if($portfolio_id >0){
//Trades
/*
$trades_sql = "select l.instrument_id, i.instrument, l.trade_date, 
                (select sum(if(trade_date<=l.trade_date, nominal, 0)) from ledger where instrument_id = l.instrument_id) total_nominal,
                (select sum(if(trade_date=l.trade_date, nominal*price, 0)) from ledger where instrument_id = l.instrument_id) pnl
                from ledger l
                inner join instruments i on l.instrument_id = i.id 
                where l.instrument_id = 1 and l.is_current =1 " . $where . "  group by instrument_id, i.instrument, trade_date order by by instrument_id, i.instrument, trade_date asc";
                
                
$inst_sql = "select * from ledger l
             inner join instruments i on l.instrument_id = i.id
             where l.is_current = 1 and i.is_current = 1 and i.id = $instrument_id  order by trade_date, l.instrument_id asc";
             
$trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
*/
$inst_sql = "select * from ledger l
             inner join instruments i on l.instrument_id = i.id
             where l.is_current = 1 and i.is_current = 1 and l.portfolio_id = $portfolio_id  order by trade_date asc";
$trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);


if(count($trades)>0){

foreach($trades as $trd){
    $ins_ids[] = $trd['instrument_id'];
} 

$insids = implode("','", $ins_ids);
 
/*
$columnsArray = array('Trade Date', 'Instrument', 'Nominal', 'Price', 'Total Nominal');
    $cnt=count($trades);
    foreach($trades as $instrument){
        $rowsArray[] = [$instrument['trade_date'], $instrument['instrument'], number_format(floatval($instrument['nominal']), 1), number_format(floatval($instrument['price']), 1)];
        $all_instruments[$instrument['instrument_id']] = $instrument['instrument'];   
    }
    $this->widget('ext.htmlTableUi.htmlTableUi',array(
        'ajaxUrl'=>'site/handleHtmlTable',
        'arProvider'=>'',    
        'collapsed'=>false,
        'columns'=>$columnsArray,
        'cssFile'=>'',
        'editable'=>false,
        'enableSort'=>false,
        'exportUrl'=>'',//'site/exportTable',
        'extra'=>'', //'Additional Information',
        //'footer'=> 'Total rows: '.$cnt.'',
        'formTitle'=>'Form Title',
        'rows'=>$rowsArray,
        'sortColumn'=>1,
        'sortOrder'=>'desc',
        //'subtitle'=>'SubTitle of Table',
        'title'=>'Trades', 
    ));
*/

    //Prices and returns calculations
    $columns = array(array('name' => 'trade_date', 'header' =>'trade_date', 'type'=>'raw'));
    //$columns[] = array('name' => 'price', 'header' =>'Price', 'type'=>'raw');
    $columns[] = array('name' => 'return', 'header' =>'Return', 'type'=>'raw');
   // $columns[] = array('name' => 'chart', 'header' =>'Chart Return', 'type'=>'raw');
    
/*    
$prices_sql = "select distinct p.trade_date, p.price,
                (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id) nominal,
                (select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id) pnl
                 from prices p
                where p.is_current = 1 and p.instrument_id = $instrument_id and p.trade_date >='$dt'  
                order by p.trade_date asc";
*/               
                
$portfolio_return_sql = "select p.trade_date,
                        sum((select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id)) pnl,
                        sum(p.price * (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id)) top
                        from prices p
                        where p.is_current = 1 and instrument_id in ('$insids') and " . $where .  
                        " group by  p.trade_date
                        order by p.trade_date asc";
$portfolio_returns = Yii::app()->db->createCommand($portfolio_return_sql)->queryAll(true);

if(count($portfolio_returns)>0){
$i = 0;
foreach($portfolio_returns as $price){
    $rawData[$i]['id'] = $i;    
    $rawData[$i]['trade_date'] = $price['trade_date'];
    //$rawData[$i]['price'] = $price['price'];
    $rawData[$i]['top'] = $price['top'];
    $rawData[$i]['pnl'] = $price['pnl'];
    $rawData[$i]['return'] = 1;                          
    //$rawData[$i]['chart'] = 1;
    // $rawData[$i]['amount'] = 0;
    // $amount_portfolio[$i] = 0; 
    // $amount_traded[$i] = 0; 
    // $amount_nominal[$i] = 0;
    // $porfolio_amount[$i] = 0;
     
    if($i>0){        
            $div = $rawData[$i-1]['top'] + $rawData[$i]['pnl'];
            
            if($div>0){
                $rawData[$i]['return'] = $rawData[$i]['top']/$div;
            }else{
                $rawData[$i]['return'] = 1;
            }
       }
 
      //checking if the return for current instrument is not exist and inserting the calculated return.//
       $existing_return  = PortfolioReturns::model()->findByAttributes(['portfolio_id'=>$portfolio_id, 'trade_date' =>$rawData[$i]['trade_date'], 'is_prtfolio_or_group' =>1]);
           if(count($existing_return)==0){
               $return = new PortfolioReturns;
               $return->portfolio_id = $portfolio_id;
               $return->is_prtfolio_or_group = 1;
               $return->trade_date = $rawData[$i]['trade_date'];
               $return->return = $rawData[$i]['return'];
               $return->save(); 
           }else{
                   $existing_return->return = $rawData[$i]['return'];
                   $existing_return->save(); 
                }
       
       $i++;
       } 
?>
<div class="row-fluid"></div>
    <?php 

	$dp=new CArrayDataProvider($rawData, ['pagination'=>['pageSize'=>70, 'params' => ['portfolio' => $portfolio_id, 'dt' => $dt]], 
    /*'sort'=>array('attributes'=> array('Group', 'Subgroup', 'Category', 'Total'),),*/
    ]);
	$dp->setTotalItemCount(count($rawData));	
	?>
	
<h3>Prices and Returns</h3>	
	<?php 
	//$this->widget('bootstrap.widgets.TbGridView', array(
	$this->widget('ext.groupgridview.GroupGridView', array(
	'ajaxUpdate' => false,
	'id'=>'product-groups-grid',
	'dataProvider'=>$dp,// $model->search(),
	//'mergeColumns' => array('Group', 'Subgroup'),
	//'filter'=>$model,
	//'template' => "{items}",
	//'type' => TbHtml::GRID_TYPE_BORDERED,
    //'htmlOptions'=>$hoptions,
    //'cssClassExpression' => '"yes"',
    //'rowCssClass'=>array('odd','even'),
	'columns'=>$columns,
    ));
 }else{ ?>
    <div class="row-fluid"></div>
    <div class="span1"></div>        
    <div class="alert alert-info span5">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>Error!</strong> Prices not fount for selected instrument.
    </div>
    <?php }}else{ ?>
    <div class="row-fluid"></div>
    <div class="span1"></div> 
    <div class="alert alert-info span5">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>Error!</strong> Ledgar information not fount for selected instrument.
    </div>
    <?php }
    }?>


