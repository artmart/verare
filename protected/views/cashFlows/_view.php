<?php
/* @var $this CashFlowsController */
/* @var $data CashFlows */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_flow_date')); ?>:</b>
	<?php echo CHtml::encode($data->cash_flow_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument')); ?>:</b>
	<?php echo CHtml::encode($data->instrument); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_flow')); ?>:</b>
	<?php echo CHtml::encode($data->cash_flow); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>