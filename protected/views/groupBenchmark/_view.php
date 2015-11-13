<?php
/* @var $this GroupBenchmarkController */
/* @var $data GroupBenchmark */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
	<?php echo CHtml::encode($data->group_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_table')); ?>:</b>
	<?php echo CHtml::encode($data->item_table); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_weight')); ?>:</b>
	<?php echo CHtml::encode($data->item_weight); ?>
	<br />


</div>