<?php
/* @var $this DocumentsController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'document_name'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'document_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'document_name'); ?>
	</div>
    </div>
 </div>

  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'document_location_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'document_location_id'); 
              echo $form->dropDownList($model, 'document_location_id',  CHtml::listData(documentlocations::model()->findAll(array('select'=>'id, location', 'order'=>'location')),'id','location'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'document_location_id'); ?>
	</div>
    </div>
 </div>

  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'document_type_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'document_type_id'); 
              echo $form->dropDownList($model, 'document_type_id',  CHtml::listData(documenttypes::model()->findAll(array('select'=>'id, document_type', 'order'=>'document_type')),'id','document_type'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'document_type_id'); ?>
	</div>
    </div>
 </div>

<?php 
/*
  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'document_upload_date'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'document_upload_date'); ?>
		<?php echo $form->error($model,'document_upload_date'); ?>
	</div>
    </div>
 </div>
 */
 ?>
 
 <div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'document_upload_date'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
        <?php //echo $form->textField($model,'document_upload_date'); ?>
        		<?php //echo $form->textField($model,'document_upload_date'); 
                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'document_upload_date',
                    'options' => array('format' =>'Y-m-d', 'timepicker'=>false, 'closeOnDateSelect'=>true), //DateTimePicker options
                    'htmlOptions' => array(),
                    ));
                ?>
        		<?php echo $form->error($model,'document_upload_date'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->