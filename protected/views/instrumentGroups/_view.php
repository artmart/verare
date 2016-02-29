<?php
/* @var $this InstrumentGroupsController */
/* @var $data InstrumentGroups */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_name')); ?>:</b>
	<?php echo CHtml::encode($data->group_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allocation_min')); ?>:</b>
	<?php echo CHtml::encode($data->allocation_min); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allocation_max')); ?>:</b>
	<?php echo CHtml::encode($data->allocation_max); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allocation_normal')); ?>:</b>
	<?php echo CHtml::encode($data->allocation_normal); ?>
	<br />


</div>