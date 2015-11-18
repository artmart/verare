<?php
/* @var $this UploadsController */
/* @var $model Uploads */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php //echo $form->label($model,'id'); ?>
		<?php //echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upload_date'); ?>
		<?php echo $form->textField($model,'upload_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upload_file'); ?>
		<?php echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instrument_id'); ?>
		<?php echo $form->textField($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upload_description'); ?>
		<?php echo $form->textField($model,'upload_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->