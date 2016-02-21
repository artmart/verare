<?php
/* @var $this BenchmarksController */
/* @var $model Benchmarks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'benchmarks-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php //echo $form->textField($model,'client_id'); 
            echo $form->dropDownList($model, 'client_id',  CHtml::listData(clients::model()->findAll(array('select'=>'id, client_name', 'order'=>'client_name')),'id','client_name'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'client_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'portfolio_id'); ?>
		<?php //echo $form->textField($model,'portfolio_id'); 
            echo $form->dropDownList($model, 'portfolio_id',  CHtml::listData(portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'portfolio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'benchmark_name'); ?>
		<?php echo $form->textField($model,'benchmark_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'benchmark_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->