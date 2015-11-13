<?php
/* @var $this LedgerController */
/* @var $data Ledger */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_date')); ?>:</b>
	<?php echo CHtml::encode($data->trade_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instrument_id')); ?>:</b>
	<?php echo CHtml::encode($data->instrument_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portfolio_id')); ?>:</b>
	<?php echo CHtml::encode($data->portfolio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nominal')); ?>:</b>
	<?php echo CHtml::encode($data->nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_status_id')); ?>:</b>
	<?php echo CHtml::encode($data->trade_status_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmed_by')); ?>:</b>
	<?php echo CHtml::encode($data->confirmed_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('confirmed_at')); ?>:</b>
	<?php echo CHtml::encode($data->confirmed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('version_number')); ?>:</b>
	<?php echo CHtml::encode($data->version_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_id')); ?>:</b>
	<?php echo CHtml::encode($data->document_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custody_account')); ?>:</b>
	<?php echo CHtml::encode($data->custody_account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custody_comment')); ?>:</b>
	<?php echo CHtml::encode($data->custody_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_number')); ?>:</b>
	<?php echo CHtml::encode($data->account_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_current')); ?>:</b>
	<?php echo CHtml::encode($data->is_current); ?>
	<br />

	*/ ?>

</div>