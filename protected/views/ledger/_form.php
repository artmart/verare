<?php
/* @var $this LedgerController */
/* @var $model Ledger */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ledger-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_date'); ?>
		<?php echo $form->textField($model,'trade_date'); ?>
		<?php echo $form->error($model,'trade_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_id'); ?>
		<?php echo $form->textField($model,'instrument_id'); ?>
		<?php echo $form->error($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'portfolio_id'); ?>
		<?php echo $form->textField($model,'portfolio_id'); ?>
		<?php echo $form->error($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nominal'); ?>
		<?php echo $form->textField($model,'nominal'); ?>
		<?php echo $form->error($model,'nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_status_id'); ?>
		<?php echo $form->textField($model,'trade_status_id'); ?>
		<?php echo $form->error($model,'trade_status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirmed_by'); ?>
		<?php echo $form->textField($model,'confirmed_by'); ?>
		<?php echo $form->error($model,'confirmed_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'confirmed_at'); ?>
		<?php echo $form->textField($model,'confirmed_at'); ?>
		<?php echo $form->error($model,'confirmed_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'version_number'); ?>
		<?php echo $form->textField($model,'version_number'); ?>
		<?php echo $form->error($model,'version_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_id'); ?>
		<?php echo $form->textField($model,'document_id'); ?>
		<?php echo $form->error($model,'document_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'custody_account'); ?>
		<?php echo $form->textField($model,'custody_account',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'custody_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'custody_comment'); ?>
		<?php echo $form->textField($model,'custody_comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'custody_comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_number'); ?>
		<?php echo $form->textField($model,'account_number'); ?>
		<?php echo $form->error($model,'account_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
		<?php echo $form->error($model,'is_current'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->