<?php
/* @var $this InstrumentTypesController */
/* @var $model InstrumentTypes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instrument-types-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_type'); ?>
		<?php echo $form->textField($model,'instrument_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instrument_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency'); ?>
		<?php echo $form->textField($model,'currency',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'defaults'); ?>
		<?php echo $form->textArea($model,'defaults',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'defaults'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->