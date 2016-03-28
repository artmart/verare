<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>
<div class="span1"></div>
<div class="span11">
    <h2>All Stats calculation for selected instruments</h2>
</div>

<div class="row-fluid"></div>
<div class="span1"></div>
<div class="span12">

<?php 
    $baseurl = Yii::app()->baseUrl;
    $instrument_id1 = '';
    $instrument_id2 = '';

    if(isset($_REQUEST['instrument1']) && !($_REQUEST['instrument1'] == '')){
        $instrument_id1 = $_REQUEST['instrument1'];
        }
    if(isset($_REQUEST['instrument2']) && !($_REQUEST['instrument2'] == '')){
        $instrument_id2 = $_REQUEST['instrument2'];
        }

    $this->beginWidget('zii.widgets.CPortlet', array('title'=>"Selection",));
    echo CHtml::beginForm('allStats','post'); 
?>
<div class="span4">
    <?php
    echo CHtml::dropDownList('instrument1', $instrument_id1,  CHtml::listData(Instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '-- Select Instrument --',  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
<div class="span4">
    <?php
    echo CHtml::dropDownList('instrument2', $instrument_id2,  CHtml::listData(Instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '-- Select Instrument --',  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
<div class="span1">
<?php echo CHtml::submitButton('Calculate All Stats', array('submit' => $baseurl.'/prices/allStats', 'class'=>"btn btn-primary"));?>
</div>
<br />
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>	
</div>

<div>
<?php 
ini_set('max_execution_time', 50000);

if($instrument_id1 >0 && $instrument_id2 >0){
//Trades
$inst1 = Yii::app()->db->createCommand("select distinct trade_date, price from prices where instrument_id = $instrument_id1 order by trade_date")->queryAll(true);      
$inst2 = Yii::app()->db->createCommand("select distinct trade_date, price from prices where instrument_id = $instrument_id2 order by trade_date")->queryAll(true);
foreach($inst1 as $i1){$returnTarget[] = $i1['price'];} 
foreach($inst2 as $i2){$returnBenchmark[] = $i2['price'];}           
?>
<div class="row-fluid"></div>
<div class="span1"></div>
<div class="span12">
<?php
$this->beginWidget('zii.widgets.CPortlet', array('title'=>"All Stats",));
if($inst1 & $inst2){
   $allstats = Calculators::CalcAllStats1($returnTarget, $returnBenchmark);
 ?>
 <table>
<tr>
	<td>VolTarget</td>
	<td><?php echo $allstats[0];?></td>
</tr>
<tr>
	<td>Sharpe</td>
	<td><?php echo $allstats[1];?></td>
</tr>
<tr>
	<td>Alpha</td>
	<td><?php echo $allstats[2];?></td>
</tr>
<tr>
	<td>Beta</td>
	<td><?php echo $allstats[3];?></td>
</tr>
<tr>
	<td>Treynor</td>
	<td><?php echo $allstats[4];?></td>
</tr>
<tr>
	<td>Tracking Error</td>
	<td><?php echo $allstats[5];?></td>
</tr>
<tr>
	<td>Info Quota</td>
	<td><?php echo $allstats[6];?></td>
</tr>
<tr>
	<td>Consistency</td>
	<td><?php echo $allstats[7];?></td>
</tr>
<tr>
	<td>R2</td>
	<td><?php echo $allstats[8];?></td>
</tr>
<tr>
	<td>VaR</td>
	<td><?php echo $allstats[9];?></td>
</tr>
<tr>
	<td>AverageTarget-1</td>
	<td><?php echo $allstats[10];?></td>
</tr>
<tr>
	<td>ReturnMax-1</td>
	<td><?php echo $allstats[11];?></td>
</tr>
<tr>
	<td>ReturnMin-1</td>
	<td><?php echo $allstats[12];?></td>
</tr>
<tr>
	<td>Sortino</td>
	<td><?php echo $allstats[13];?></td>
</tr>
<tr>
	<td>Omega</td>
	<td><?php echo $allstats[14];?></td>
</tr>
<tr>
	<td>Average Target Minus Bench</td>
	<td><?php echo $allstats[15];?></td>
</tr>
<tr>
	<td>Average Bench Minus Target On Bad Days</td>
	<td><?php echo $allstats[16];?></td>
</tr>
</table>
 <?php  
   
//var_dump($allstats);
  
 ?>
 </div>
 <?php   
    }else{ ?>
    <div class="row-fluid"></div>
    <div class="span1"></div>        
    <div class="alert alert-info span5">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>Error!</strong> Prices not fount for one of the selected instruments.
    </div>
    <?php }}else{ ?>
    <div class="row-fluid"></div>
    <div class="span1"></div> 
    <div class="alert alert-info span5">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <strong>Error!</strong> One instrument is not selected.
    </div>
    <?php }
 $this->endWidget(); 
?>


