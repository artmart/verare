<?php
/* @var $this BenchmarksController */
/* @var $data Benchmarks */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portfolio_id')); ?>:</b>
	<?php echo CHtml::encode($data->portfolio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('benchmark_name')); ?>:</b>
	<?php echo CHtml::encode($data->benchmark_name); ?>
	<br />


</div>