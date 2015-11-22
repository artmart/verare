<div class="span1"></div><div class="span11"><h2>Time-weighted return</h2></div>
<?php $baseurl = Yii::app()->baseUrl; $baseUrl1 = Yii::app()->theme->baseUrl;?>
<!--<img src="<?php //echo $baseUrl1;?>/img/MLS_logo.jpg" style= 'height: 48px; '/>-->
<div class="row-fluid"></div>
<div class="span9">
<?php //$this->beginWidget('zii.widgets.CPortlet', array('title'=>"Selection",));
     // echo CHtml::beginForm('prices/return','post'); 
      $baseurl = Yii::app()->baseUrl;
?>

<style>
.hoptions{
    background-color: grey; 
    font-weight: bold;
    }
</style>

<?php //$this->endWidget();?>	
</div>

<?php 
ini_set('max_execution_time', 50000);
$columns= array(array('name' => 'trade_date', 'header' =>'trade_date', 'type'=>'raw'));
$instruments = Yii::app()->db->createCommand("select * from instruments where is_current = 1")->queryAll(true);

foreach($instruments as $instrument1){
    $columns[] =  array('name' => $instrument1['instrument'], 'header' =>$instrument1['instrument'], 'type'=>'raw');
    $ret_hiades[] = array('name' => 'chart_'.$instrument1['instrument'], 'header' =>'chart_'.$instrument1['instrument'], 'type'=>'raw');
}
foreach($ret_hiades as $rh){
array_push($columns, $rh);
}

$trade_dates = Yii::app()->db->createCommand("select distinct trade_date from prices where is_current = 1 order by trade_date asc")->queryAll(true);
$prices = Yii::app()->db->createCommand("select * from prices where is_current = 1")->queryAll(true);

$i = 0;
foreach($trade_dates as $td){
    $rawData[$i]['id'] = $i;
    $rawData[$i]['trade_date'] = date_format(date_create($td['trade_date']), 'Y-m-d');
    foreach($instruments as $instrument){
        $column = $instrument['instrument'];
        $instrument_id = $instrument['id']; 
        foreach($prices as $price){
            if($price['instrument_id'] == $instrument_id && $price['trade_date'] == $td['trade_date']){        
                        $rawData[$i][$column] = $price['price']; 
                        $retun_field = 'chart_'.$column; 
                        $rawData[$i][$retun_field] = '';
                        $data[$retun_field][] = 0;
                        if($i>0 && !($rawData[0][$column] == 0)){
                                $rawData[$i][$retun_field] = $rawData[$i][$column]/$rawData[0][$column];
                                $data[$retun_field][] = floatval($rawData[$i][$retun_field]);
                    }
                }
            }
        }
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
	
<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>	
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

//var_dump($data);

//foreach($ret_hiades as $rh){

//$series[] = array('name' => $rh, 'data' => $data[$rh]);
//}

//$series[] = array('name' => 'Ending Inventory', 'data' => $data1);
//$series[] = array('name' => 'Total stock', 'data' => $data2); 	

?>

<div class = "span12">
	<?php 
 /*   
    $this->Widget('ext.highcharts.HighchartsWidget', array(
		   'options'=>array('title' => array('text' => ''), 'xAxis' => array('categories' => $weeks, 'type' => 'datetime', 'title' => array('text'=> null), 
							'labels' => array('enabled' => true),),
			  'yAxis' => array('title' => array('text' => ''), 'min' => 0),
			  'chart' => array('plotBackgroundColor' => '#ffffff', 'plotBorderWidth' => null, 'plotShadow' => false, 'height' => 300, ),
			  'colors'=>array('#6AC36A', '#FFD148', '#0563FE', '#FF2F2F', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'),
			  'credits' => array('enabled' => false),
			  'series' => $series,
		   )
		));
} else{echo "<div class='row-fluid'></div><div class='span2'></div>No Results found";}  
*/
?>
</div>


