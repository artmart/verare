<?php
/* @var $this UploadsController */
/* @var $data Uploads */
?>

<div class="view">
<!--
	<b><?php //echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_date')); ?>:</b>
	<?php echo CHtml::encode($data->upload_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_file')); ?>:</b>
	<?php echo CHtml::encode($data->upload_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_description')); ?>:</b>
	<?php echo CHtml::encode($data->upload_description); ?>
	<br />

</div>