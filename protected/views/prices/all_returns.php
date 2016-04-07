<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>
<div class="span1"></div>
<div class="span11">
    <h2>Time-weighted return calculation for selected instrument</h2>
</div>

<div class="row-fluid"></div>
<div class="span1"></div>
<div class="span12">

<?php 
    $baseurl = Yii::app()->baseUrl;
    $instrument_id = '';
    $dt = '';
    $where = ' 1 = 1 ';
    
    if(isset($_REQUEST['instrument']) && !($_REQUEST['instrument'] == '')){$instrument_id = $_REQUEST['instrument'];}

        
    if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and l.trade_date >='$dt' "; }

    //$this->beginWidget('zii.widgets.CPortlet', array('title'=>"Selection",));
    echo CHtml::beginForm('returnCalculation','post'); 
?>
<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
    <?php
        echo CHtml::dropDownList('instrument', $instrument_id,  CHtml::listData(Instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '-- Select Instrument --', 'class'=>'form-control'  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
</div>

<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
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
        'htmlOptions'=>array('placeholder'=>'YYYY-MM-DD', 'class'=>'form-control' ),
    ));

?>
</div>
</div>

<div class="row form-group">
    <label class="col-md-3 control-label"></label>  
    <div class="col-md-4">
    <?php echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/prices/allReturns', 'class'=>"btn btn-primary"));?>
    </div>
</div>

</div>

<br />
<?php echo CHtml::endForm(); ?>
<?php //$this->endWidget();?>	
</div>


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




if($instrument_id >0){
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
             where l.is_current = 1 and i.is_current = 1 and i.id = $instrument_id  order by trade_date asc";
$trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);

if(count($trades)>0){
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
    $columns[] = array('name' => 'price', 'header' =>'Price', 'type'=>'raw');
    $columns[] = array('name' => 'return', 'header' =>'Return', 'type'=>'raw');
    $columns[] = array('name' => 'chart', 'header' =>'Chart Return', 'type'=>'raw');
    
    
$prices_sql = "select distinct p.trade_date, p.price,
                (select sum(if(trade_date<=p.trade_date, nominal, 0)) from ledger where instrument_id = p.instrument_id) nominal,
                (select sum(if(trade_date=p.trade_date, nominal*price, 0)) from ledger where instrument_id = p.instrument_id) pnl
                 from prices p
                where p.is_current = 1 and p.instrument_id = $instrument_id and p.trade_date >='$dt'  
                order by p.trade_date asc";
$prices = Yii::app()->db->createCommand($prices_sql)->queryAll(true);

if(count($prices)>0){
$i = 0;
foreach($prices as $price){
    $rawData[$i]['id'] = $i;    
    $rawData[$i]['trade_date'] = $price['trade_date'];
    $rawData[$i]['price'] = $price['price'];
    $rawData[$i]['nominal'] = $price['nominal'];
    $rawData[$i]['pnl'] = $price['pnl'];
    $rawData[$i]['return'] = 1;                          
    $rawData[$i]['chart'] = 1;
    // $rawData[$i]['amount'] = 0;
    // $amount_portfolio[$i] = 0; 
    // $amount_traded[$i] = 0; 
    // $amount_nominal[$i] = 0;
    // $porfolio_amount[$i] = 0;
     
    if($i>0 && $rawData[0]['price'] !== 0){
            $rawData[$i]['chart'] = $rawData[$i]['price']/$rawData[0]['price'];      
        
            $div = $rawData[$i-1]['nominal'] * $rawData[$i-1]['price']+ $rawData[$i]['pnl'];
            
            if($div>0){
                $rawData[$i]['return'] = ($rawData[$i]['nominal'] * $rawData[$i]['price'])/$div;
            }else{
                $rawData[$i]['return'] = 1;
            }
        
            // $porfolio_amount[$i] = $porfolio_amount[$i] + $rawData[$i]['nominal'] * $rawData[$i]['price'];
            // $amount_traded[$i] = $amount_traded[$i] + $rawData[$i]['pnl'];
        }
 

      //checking if the return for current instrument is not exist and inserting the calculated return.//
      
       $existing_return  = Returns::model()->findByAttributes(['instrument_id'=>$instrument_id, 'trade_date' =>$rawData[$i]['trade_date']]);
           if(count($existing_return)==0){
               $return = new Returns;
               $return->instrument_id = $instrument_id;
               $return->trade_date = $rawData[$i]['trade_date'];
               $return->return = $rawData[$i]['return'];
               $return->save(); 
           }else{
               $existing_return->return = $rawData[$i]['return'];
               $existing_return->save(); 
           }
       
       $i++;
       }
        
        //////////////////Portfolio calculation////////////////////
        /*
            if($i == 0){
                $rawData[$i]['portfolio'] = 1;
            }else{   
                //$dev1 = $amount_nominal[$i-1] * $rawData[$i-1][$column] + $amount_traded[$i];
                $dev1 = $porfolio_amount[$i-1] + $amount_traded[$i];
                if($dev1 >0){
                    $rawData[$i]['portfolio'] = ($porfolio_amount[$i])/$dev1;
               // if(($amount_portfolio[$i-1]+$amount_traded[$i])>0){
                //$rawData[$i]['portfolio'] = $amount_portfolio[$i]/($amount_portfolio[$i-1]+$amount_traded[$i]);                
                }else{
                    $rawData[$i]['portfolio'] = 1;
                }
            }
        */
        //////////////////////////////////////////////////////////
    
?>
<div class="row-fluid"></div>
    <?php
	$dp=new CArrayDataProvider($rawData, ['pagination'=>['pageSize'=>70, 'params' => ['instrument' => $instrument_id, 'dt' => $dt]], 
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


