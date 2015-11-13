<?php
/* @var $this TradeStatusController */
/* @var $data TradeStatus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_status')); ?>:</b>
	<?php echo CHtml::encode($data->trade_status); ?>
	<br />


</div>