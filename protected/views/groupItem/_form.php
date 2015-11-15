<?php
/* @var $this GroupItemController */
/* @var $model GroupItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-item-form',
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
		<?php //echo $form->textField($model,'group_id'); 
              echo $form->dropDownList($model, 'group_id',  CHtml::listData(grouping::model()->findAll(array('select'=>'id, group_name', 'order'=>'group_name')),'id','group_name'), array('empty' => '- Select -'));
        ?>
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