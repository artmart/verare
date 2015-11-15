<?php
/* @var $this TradeStatusController */
/* @var $model TradeStatus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trade-status-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_status'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'trade_status',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'trade_status'); ?>
		</div>
    </div>
 </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->