<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>
<div class="span1"></div>
<div class="span11">
    <h2>Time-weighted return</h2>
</div>

<div class="row-fluid"></div>
<div class="span9">
<?php //$this->beginWidget('zii.widgets.CPortlet', array('title'=>"Selection",));
      // echo CHtml::beginForm('prices/return','post'); 
      // $baseurl = Yii::app()->baseUrl;
      //$this->endWidget();
 ?>	
</div>

<?php 
ini_set('max_execution_time', 50000);

//Trades
$inst_sql = "select * from ledger l
             inner join instruments i on l.instrument_id = i.id
             where l.is_current = 1 and i.is_current = 1 order by trade_date, l.instrument_id asc";
             
$trades = Yii::app()->db->createCommand($inst_sql)->queryAll(true);
if(count($trades)>0){

$columnsArray = array('Trade Date', 'Instrument', 'Nominal', 'Price');
    $cnt=count($trades);
    foreach($trades as $instrument){
        $rowsArray[] = [$instrument['trade_date'], $instrument['instrument'], number_format(floatval($instrument['nominal']), 1), number_format(floatval($instrument['price']), 1)];
        $all_instruments[$instrument['instrument_id']] = $instrument['instrument'];   
    }
    $this->widget('ext.htmlTableUi.htmlTableUi',array(
        'ajaxUrl'=>'site/handleHtmlTable',
        'arProvider'=>'',    
        'collapsed'=>true,
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

//Prices and returns calculations
$columns = array(array('name' => 'trade_date', 'header' =>'trade_date', 'type'=>'raw'));
$distinct_instruments  = array_unique($all_instruments);

//exit;
foreach($distinct_instruments as $key => $di){
    $columns[] = array('name' => $di, 'header' =>$di, 'type'=>'raw');
    $columns[] = array('name' => 'ret_'.$key, 'header' =>'ret_'.$di, 'type'=>'raw');
    $columns[] = array('name' => 'chart_'.$di, 'header' =>'chart_'.$di, 'type'=>'raw');
    $inst_id[] = $key;
}
$columns[] = array('name' => 'portfolio', 'header' =>'Portfolio', 'type'=>'raw');
//array_merge($columns, $columns1);
$inst_ids = implode(" ', '", $inst_id);

$prices = Yii::app()->db->createCommand("select DATE(trade_date) trade_date, price, instrument_id from prices where is_current = 1 and instrument_id in ('$inst_ids') order by trade_date, instrument_id asc")->queryAll(true);
if(count($prices)>0){
foreach($prices as $pr){$all_dates[] = $pr['trade_date'];}
$trade_dates = array_unique($all_dates); 

$i = 0;
foreach($trade_dates as $td){
    $rawData[$i]['id'] = $i;    
    $rawData[$i]['trade_date'] = $td;
    
    $amount_portfolio[$i] = 0; 
    $amount_traded[$i] = 0; 
    $amount_nominal[$i] = 0;
    $porfolio_amount[$i] = 0;
    
    foreach($trades as $trade){
        $rawData[$i]['nominal'.$trade['instrument_id']] = 0;
        $rawData[$i]['pnl'.$trade['instrument_id']] = 0;
        if($i==0){
                $rawData[$i]['ret_'.$trade['instrument_id']] = 1;
                if(strtotime($trade['trade_date']) > strtotime($rawData[0]['trade_date'])){
                    $rawData[$i]['amount'.$trade['instrument_id']] = $trade['nominal'] * $trade['price'];                    
                }else{$rawData[$i]['amount'.$trade['instrument_id']] = 0;}
                }
        $instrument_id = $trade['instrument_id'];
        
        $nom_pl_sql = "select sum(if(DATE(trade_date)<='$td', nominal, 0)) nominal, sum(if(DATE(trade_date)='$td', nominal*price, 0)) pnl from ledger where instrument_id = '$instrument_id'";    
        $nom_pl = Yii::app()->db->createCommand($nom_pl_sql)->queryAll(true);
        
        $rawData[$i]['nominal'.$trade['instrument_id']] = $nom_pl[0]['nominal'];
        $rawData[$i]['pnl'.$trade['instrument_id']] = $nom_pl[0]['pnl'];
   
        $column = $trade['instrument'];
        
                foreach($prices as $price)
                {
                    if($price['instrument_id'] == $instrument_id && strtotime($price['trade_date']) == strtotime($td))
                       {        
                                $rawData[$i][$column] = $price['price'];
                                $rawData[$i]['price_'.$trade['instrument_id']] = $price['price'];
                                $retun_field = 'chart_'.$column; 
                                $rawData[$i][$retun_field] = 1;
                                if($i>0 && !($rawData[0][$column] == 0)){
                                        $rawData[$i][$retun_field] = $rawData[$i][$column]/$rawData[0][$column];      
                                    }
                        }
                }
                    
        if($i>0){ 
            $div = $rawData[$i-1]['nominal'.$trade['instrument_id']] * $rawData[$i-1]['price_'.$trade['instrument_id']]+ $rawData[$i]['pnl'.$trade['instrument_id']];
            
            if($div>0){
                $rawData[$i]['ret_'.$trade['instrument_id']] = ($rawData[$i]['nominal'.$trade['instrument_id']] * $rawData[$i]['price_'.$trade['instrument_id']])/$div;
            }else{
                $rawData[$i]['ret_'.$trade['instrument_id']] = 1;
            }
        }
                $porfolio_amount[$i] = $porfolio_amount[$i] + $rawData[$i]['nominal'.$trade['instrument_id']] * $rawData[$i]['price_'.$trade['instrument_id']];
                $amount_traded[$i] = $amount_traded[$i] + $rawData[$i]['pnl'.$trade['instrument_id']];

      //checking if the return for current instrument is not exist and inserting the calculated return.//
       $existing_return  = Returns::model()->findByAttributes(['instrument_id'=>$trade['instrument_id'], 'trade_date' =>$rawData[$i]['trade_date']]);
           if(count($existing_return)==0){
               $return = new Returns;
               $return->instrument_id = $trade['instrument_id'];
               $return->trade_date = $rawData[$i]['trade_date'];
               $return->return = $rawData[$i]['ret_'.$trade['instrument_id']];
               $return->save(); 
           }
       }
        
        //////////////////Portfolio calculation////////////////////
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
        //////////////////////////////////////////////////////////
    $i++;
}

?>

<div class="row-fluid"></div>
<?php

 
  //  $data1[] = floatval($rawData[$i]['ending_inventory']);
 //   $data2[] = floatval($safety_stock); 
//}

	$dp=new CArrayDataProvider($rawData, array(
												'pagination'=>array('pageSize'=>75,),
												//'sort'=>array('attributes'=> array('Group', 'Subgroup', 'Category', 'Total'),),
			//'sort'=>array('attributes'=>array('product_group', 'subgroup', 'category'),),
			
	));
	//$dp= new CSqlDataProvider($sql);
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
   // 'htmlOptions'=>$data['tclass'],
    //'htmlOptions'=>["id" => "hoptions"],
    //'rowHtmlOptionsExpression' => $hoptions, // '[ "data-animalclass" => $hoptions, ]',
    //'rowHtmlOptionsExpression' => ["id" => "hoptions"],
    //'rowCssClassExpression'=>if(!($data["tclass"] == '')){'$data["tclass"]'},
//    'rowCssClassExpression'=>'($data["tclass"] == 1)?(($data["id"]%2==1)?"even":"odd"):$data["tclass"]',
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
?>


