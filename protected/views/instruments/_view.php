<?php
/* @var $this InstrumentsController */
/* @var $data Instruments */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument')); ?>:</b>
	<?php echo CHtml::encode($data->instrument); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fpml')); ?>:</b>
	<?php echo CHtml::encode($data->fpml); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_current')); ?>:</b>
	<?php echo CHtml::encode($data->is_current); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />


</div>