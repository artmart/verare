<?php
/* @var $this PortfolioReturnsController */
/* @var $model PortfolioReturns */
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
		<?php echo $form->label($model,'portfolio_id'); ?>
		<?php echo $form->textField($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_prtfolio_or_group'); ?>
		<?php echo $form->textField($model,'is_prtfolio_or_group'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trade_date'); ?>
		<?php echo $form->textField($model,'trade_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'return'); ?>
		<?php echo $form->textField($model,'return'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->