<?php
/* @var $this BenchmarkComponentsController */
/* @var $data BenchmarkComponents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('benchmark_id')); ?>:</b>
	<?php echo CHtml::encode($data->benchmark_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_instrument_or_portfolio')); ?>:</b>
	<?php echo CHtml::encode($data->is_instrument_or_portfolio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />


</div>