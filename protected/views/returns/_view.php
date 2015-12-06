<?php
/* @var $this ReturnsController */
/* @var $data Returns */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_date')); ?>:</b>
	<?php echo CHtml::encode($data->trade_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return')); ?>:</b>
	<?php echo CHtml::encode($data->return); ?>
	<br />


</div>