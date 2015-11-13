<?php
/* @var $this DocumentsController */
/* @var $data Documents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_name')); ?>:</b>
	<?php echo CHtml::encode($data->document_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_location_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_location_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_upload_date')); ?>:</b>
	<?php echo CHtml::encode($data->document_upload_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_current')); ?>:</b>
	<?php echo CHtml::encode($data->is_current); ?>
	<br />


</div>