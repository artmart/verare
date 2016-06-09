<?php
/* @var $this CashFlowsController */
/* @var $model CashFlows */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cash-flows-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cash_flow_date'); ?>
		<?php echo $form->textField($model,'cash_flow_date'); ?>
		<?php echo $form->error($model,'cash_flow_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument'); ?>
		<?php echo $form->textField($model,'instrument'); ?>
		<?php echo $form->error($model,'instrument'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cash_flow'); ?>
		<?php echo $form->textField($model,'cash_flow'); ?>
		<?php echo $form->error($model,'cash_flow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->