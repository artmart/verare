<?php
/* @var $this InstrumentTypesController */
/* @var $model InstrumentTypes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instrument-types-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'instrument_type'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'instrument_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'instrument_type'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'currency'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'currency',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'currency'); ?>
	</div>
    </div>
 </div>

<?php 
/*
	<div class="row">
		<?php echo $form->labelEx($model,'defaults'); ?>
		<?php echo $form->textArea($model,'defaults',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'defaults'); ?>
	</div>
*/
?>   
    
    
   <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'defaults'); ?>
		<?php //echo $form->textField($model,'defaults',array('size'=>60,'maxlength'=>255)); 
              //echo $form->textArea($model, 'defaults', array('maxlength' => 255, 'rows' => 4, 'cols' => 150, 'class'=>'span5'));
        ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
                'model'=>$model,
                'attribute'=>'defaults',
                'config' => array(
                    'toolbar'=>array(
                        array( /*'Source',*/ '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Undo', 'Redo' ),
                        //array( 'Image', 'Link', 'Unlink', 'Anchor' ) ,
                        array('Styles', 'Format', 'Font', 'FontSize'),
                    ),
                    ),
                )); ?>
		<?php echo $form->error($model,'defaults'); ?>
	</div>
 </div>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->