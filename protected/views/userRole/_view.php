<?php
/* @var $this UserRoleController */
/* @var $data UserRole */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_role')); ?>:</b>
	<?php echo CHtml::encode($data->trade_role); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_administration')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_administration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ledger_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->ledger_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->users_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_roles_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->user_roles_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portfolios_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->portfolios_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instruments_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->instruments_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('counterparties_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->counterparties_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documents_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->documents_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prices_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->prices_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('audit_trails_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->audit_trails_access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grouping_access_level')); ?>:</b>
	<?php echo CHtml::encode($data->grouping_access_level); ?>
	<br />

	*/ ?>

</div>