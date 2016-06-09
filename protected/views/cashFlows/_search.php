<?php
/* @var $this CashFlowsController */
/* @var $model CashFlows */
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
		<?php echo $form->label($model,'cash_flow_date'); ?>
		<?php echo $form->textField($model,'cash_flow_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instrument'); ?>
		<?php echo $form->textField($model,'instrument'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cash_flow'); ?>
		<?php echo $form->textField($model,'cash_flow'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->