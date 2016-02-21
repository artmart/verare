<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'benchmark-components-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'benchmark_id'); ?>
		<?php //echo $form->textField($model,'benchmark_id'); 
            echo $form->dropDownList($model, 'benchmark_id',  CHtml::listData(Benchmarks::model()->findAll(array('select'=>'id, benchmark_name', 'order'=>'benchmark_name')),'id','benchmark_name'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'benchmark_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instrument_id'); ?>
		<?php //echo $form->textField($model,'instrument_id'); 
            echo $form->dropDownList($model, 'instrument_id',  CHtml::listData(instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'instrument_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_instrument_or_portfolio'); ?>
		<?php //echo $form->textField($model,'is_instrument_or_portfolio'); 
            echo $form->checkBox($model,'is_instrument_or_portfolio',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'is_instrument_or_portfolio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->