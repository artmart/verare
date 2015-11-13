<?php
/* @var $this DocumentsController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_name'); ?>
		<?php echo $form->textField($model,'document_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_location_id'); ?>
		<?php echo $form->textField($model,'document_location_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_type_id'); ?>
		<?php echo $form->textField($model,'document_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_upload_date'); ?>
		<?php echo $form->textField($model,'document_upload_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->