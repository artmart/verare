<?php
/* @var $this DocumentsController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'document_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_location_id'); ?>
		<?php echo $form->textField($model,'document_location_id'); ?>
		<?php echo $form->error($model,'document_location_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_type_id'); ?>
		<?php echo $form->textField($model,'document_type_id'); ?>
		<?php echo $form->error($model,'document_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document_upload_date'); ?>
		<?php echo $form->textField($model,'document_upload_date'); ?>
		<?php echo $form->error($model,'document_upload_date'); ?>
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