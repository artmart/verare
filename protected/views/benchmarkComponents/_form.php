<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'benchmark-components-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'benchmark_id'); ?>
		<?php echo $form->textField($model,'benchmark_id'); ?>
		<?php echo $form->error($model,'benchmark_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_id'); ?>
		<?php echo $form->textField($model,'instrument_id'); ?>
		<?php echo $form->error($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_instrument_or_portfolio'); ?>
		<?php echo $form->textField($model,'is_instrument_or_portfolio'); ?>
		<?php echo $form->error($model,'is_instrument_or_portfolio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->