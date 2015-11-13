<?php
/* @var $this GroupItemController */
/* @var $model GroupItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->textField($model,'group_id'); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_id'); ?>
		<?php echo $form->textField($model,'item_id'); ?>
		<?php echo $form->error($model,'item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_table'); ?>
		<?php echo $form->textField($model,'item_table',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'item_table'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_weight'); ?>
		<?php echo $form->textField($model,'item_weight'); ?>
		<?php echo $form->error($model,'item_weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
		<?php echo $form->error($model,'is_current'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->