<?php
/* @var $this CounterpartiesController */
/* @var $model Counterparties */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'counterparties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'name'); ?>
        </div>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'contact_info'); ?>
        </div>
		<?php echo $form->textArea($model,'contact_info',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contact_info'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'company_id'); ?>
        </div>
		<?php echo $form->textField($model,'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'documents'); ?>
        </div>
		<?php echo $form->textField($model,'documents',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'documents'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->