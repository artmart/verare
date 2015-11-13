<?php
/* @var $this LedgerController */
/* @var $model Ledger */
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
		<?php echo $form->label($model,'trade_date'); ?>
		<?php echo $form->textField($model,'trade_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instrument_id'); ?>
		<?php echo $form->textField($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'portfolio_id'); ?>
		<?php echo $form->textField($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nominal'); ?>
		<?php echo $form->textField($model,'nominal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trade_status_id'); ?>
		<?php echo $form->textField($model,'trade_status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmed_by'); ?>
		<?php echo $form->textField($model,'confirmed_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'confirmed_at'); ?>
		<?php echo $form->textField($model,'confirmed_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'version_number'); ?>
		<?php echo $form->textField($model,'version_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_id'); ?>
		<?php echo $form->textField($model,'document_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'custody_account'); ?>
		<?php echo $form->textField($model,'custody_account',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'custody_comment'); ?>
		<?php echo $form->textField($model,'custody_comment',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_number'); ?>
		<?php echo $form->textField($model,'account_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_current'); ?>
		<?php echo $form->textField($model,'is_current'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->