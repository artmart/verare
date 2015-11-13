<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */
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
		<?php echo $form->label($model,'instrument'); ?>
		<?php echo $form->textField($model,'instrument',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instrument_type_id'); ?>
		<?php echo $form->textField($model,'instrument_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fpml'); ?>
		<?php echo $form->textArea($model,'fpml',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->