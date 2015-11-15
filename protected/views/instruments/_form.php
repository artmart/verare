<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instruments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'instrument'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'instrument',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instrument'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'instrument_type_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'instrument_type_id'); 
              echo $form->dropDownList($model, 'instrument_type_id',  CHtml::listData(instrumenttypes::model()->findAll(array('select'=>'id, instrument_type', 'order'=>'instrument_type')),'id','instrument_type'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'instrument_type_id'); ?>
	</div>
    </div>
 </div>

<?php /*
<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'fpml'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textArea($model,'fpml',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'fpml'); ?>
	</div>
    </div>
 </div>
*/
?>
 
  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'fpml'); ?>
		<?php //echo $form->textField($model,'fpml',array('size'=>60,'maxlength'=>255)); 
              //echo $form->textArea($model, 'fpml', array('maxlength' => 255, 'rows' => 4, 'cols' => 150, 'class'=>'span5'));
        ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
                'model'=>$model,
                'attribute'=>'fpml',
                'config' => array(
                    'toolbar'=>array(
                        array( /*'Source',*/ '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Undo', 'Redo' ),
                        //array( 'Image', 'Link', 'Unlink', 'Anchor' ) ,
                        array('Styles', 'Format', 'Font', 'FontSize'),
                    ),
                    ),
                )); ?>
		<?php echo $form->error($model,'fpml'); ?>
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