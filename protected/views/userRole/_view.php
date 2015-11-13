<?php
/* @var $this UserRoleController */
/* @var $data UserRole */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_role')); ?>:</b>
	<?php echo CHtml::encode($data->user_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_creation')); ?>:</b>
	<?php echo CHtml::encode($data->trade_creation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_confirmation')); ?>:</b>
	<?php echo CHtml::encode($data->trade_confirmation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_cancellation')); ?>:</b>
	<?php echo CHtml::encode($data->trade_cancellation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_administration')); ?>:</b>
	<?php echo CHtml::encode($data->price_administration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_administration')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_administration); ?>
	<br />


</div>