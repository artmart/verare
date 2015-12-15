<?php
/* @var $this PortfolioReturnsController */
/* @var $model PortfolioReturns */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'portfolio-returns-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'portfolio_id'); ?>
		<?php echo $form->textField($model,'portfolio_id'); ?>
		<?php echo $form->error($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_prtfolio_or_group'); ?>
		<?php echo $form->textField($model,'is_prtfolio_or_group'); ?>
		<?php echo $form->error($model,'is_prtfolio_or_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trade_date'); ?>
		<?php echo $form->textField($model,'trade_date'); ?>
		<?php echo $form->error($model,'trade_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'return'); ?>
		<?php echo $form->textField($model,'return'); ?>
		<?php echo $form->error($model,'return'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->