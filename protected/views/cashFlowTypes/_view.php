<?php
/* @var $this CashFlowTypesController */
/* @var $data CashFlowTypes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_flow_type')); ?>:</b>
	<?php echo CHtml::encode($data->cash_flow_type); ?>
	<br />


</div>