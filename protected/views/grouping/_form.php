<?php
/* @var $this GroupingController */
/* @var $model Grouping */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grouping-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'group_name'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'group_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'group_name'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'is_current'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'is_current'); 
              echo $form->checkBox($model,'is_current',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'is_current'); ?>
	</div>
    </div>
 </div>
 
<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'created_at'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
        <?php //echo $form->textField($model,'created_at'); ?>
        		<?php //echo $form->textField($model,'from'); 
                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'created_at',
                    'options' => array('format' =>'Y-m-d', 'timepicker'=>false, 'closeOnDateSelect'=>true), //DateTimePicker options
                    'htmlOptions' => array(),
                    ));
                ?>
        		<?php echo $form->error($model,'created_at'); ?>
            </div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->