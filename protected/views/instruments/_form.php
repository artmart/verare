<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instruments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument'); ?>
		<?php echo $form->textField($model,'instrument',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instrument'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_type_id'); ?>
		<?php echo $form->textField($model,'instrument_type_id'); ?>
		<?php echo $form->error($model,'instrument_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fpml'); ?>
		<?php echo $form->textArea($model,'fpml',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'fpml'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
		<?php echo $form->error($model,'is_current'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->