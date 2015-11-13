<?php
/* @var $this PricesController */
/* @var $data Prices */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_date')); ?>:</b>
	<?php echo CHtml::encode($data->trade_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_current')); ?>:</b>
	<?php echo CHtml::encode($data->is_current); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />


</div>