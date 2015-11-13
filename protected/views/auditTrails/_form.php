<?php
/* @var $this AuditTrailsController */
/* @var $model AuditTrails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'audit-trails-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'table_id'); ?>
		<?php echo $form->textField($model,'table_id'); ?>
		<?php echo $form->error($model,'table_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reverse_sql'); ?>
		<?php echo $form->textField($model,'reverse_sql',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'reverse_sql'); ?>
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
		<?php echo $form->labelEx($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
		<?php echo $form->error($model,'is_current'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->