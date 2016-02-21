<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */
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
		<?php echo $form->label($model,'benchmark_id'); ?>
		<?php echo $form->textField($model,'benchmark_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instrument_id'); ?>
		<?php echo $form->textField($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_instrument_or_portfolio'); ?>
		<?php echo $form->textField($model,'is_instrument_or_portfolio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->