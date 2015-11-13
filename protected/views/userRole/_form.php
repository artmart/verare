<?php
/* @var $this UserRoleController */
/* @var $model UserRole */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-role-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php echo $form->textField($model,'user_role',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_creation'); ?>
		<?php echo $form->textField($model,'trade_creation'); ?>
		<?php echo $form->error($model,'trade_creation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_confirmation'); ?>
		<?php echo $form->textField($model,'trade_confirmation'); ?>
		<?php echo $form->error($model,'trade_confirmation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_cancellation'); ?>
		<?php echo $form->textField($model,'trade_cancellation'); ?>
		<?php echo $form->error($model,'trade_cancellation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_administration'); ?>
		<?php echo $form->textField($model,'price_administration'); ?>
		<?php echo $form->error($model,'price_administration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_administration'); ?>
		<?php echo $form->textField($model,'instrument_administration'); ?>
		<?php echo $form->error($model,'instrument_administration'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->