<?php
/* @var $this ClientsController */
/* @var $model Clients */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clients-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'client_name'); ?>
         </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'client_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'client_name'); ?>
		</div>
    </div>
 </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->