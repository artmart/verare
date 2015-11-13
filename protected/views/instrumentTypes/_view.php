<?php
/* @var $this InstrumentTypesController */
/* @var $data InstrumentTypes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_type')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency')); ?>:</b>
	<?php echo CHtml::encode($data->currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('defaults')); ?>:</b>
	<?php echo CHtml::encode($data->defaults); ?>
	<br />


</div>