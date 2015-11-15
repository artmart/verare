<?php
/* @var $this GroupBenchmarkController */
/* @var $model GroupBenchmark */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-benchmark-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'group_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'group_id'); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'item_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'item_id'); ?>
		<?php echo $form->error($model,'item_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'item_table'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'item_table',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'item_table'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'item_weight'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'item_weight'); ?>
		<?php echo $form->error($model,'item_weight'); ?>
	</div>
    </div>
 </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->