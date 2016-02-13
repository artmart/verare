<?php
/* @var $this PortfolioTypesController */
/* @var $model PortfolioTypes */
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
		<?php echo $form->label($model,'portfolio_type'); ?>
		<?php echo $form->textField($model,'portfolio_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allocation_min'); ?>
		<?php echo $form->textField($model,'allocation_min'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allocation_max'); ?>
		<?php echo $form->textField($model,'allocation_max'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allocation_normal'); ?>
		<?php echo $form->textField($model,'allocation_normal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->