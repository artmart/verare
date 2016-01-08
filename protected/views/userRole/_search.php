<?php
/* @var $this UserRoleController */
/* @var $model UserRole */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php //echo $form->label($model,'id'); ?>
		<?php //echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'trade_role'); ?>
		<?php //echo $form->textField($model,'trade_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_role'); ?>
		<?php echo $form->textField($model,'user_role',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'trade_creation'); ?>
		<?php //echo $form->textField($model,'trade_creation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'trade_confirmation'); ?>
		<?php //echo $form->textField($model,'trade_confirmation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'trade_cancellation'); ?>
		<?php //echo $form->textField($model,'trade_cancellation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'price_administration'); ?>
		<?php //echo $form->textField($model,'price_administration'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'instrument_administration'); ?>
		<?php //echo $form->textField($model,'instrument_administration'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ledger_access_level'); ?>
		<?php echo $form->textField($model,'ledger_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'users_access_level'); ?>
		<?php echo $form->textField($model,'users_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_roles_access_level'); ?>
		<?php echo $form->textField($model,'user_roles_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'portfolios_access_level'); ?>
		<?php echo $form->textField($model,'portfolios_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instruments_access_level'); ?>
		<?php echo $form->textField($model,'instruments_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'counterparties_access_level'); ?>
		<?php echo $form->textField($model,'counterparties_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'documents_access_level'); ?>
		<?php echo $form->textField($model,'documents_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prices_access_level'); ?>
		<?php echo $form->textField($model,'prices_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'audit_trails_access_level'); ?>
		<?php echo $form->textField($model,'audit_trails_access_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grouping_access_level'); ?>
		<?php echo $form->textField($model,'grouping_access_level'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->