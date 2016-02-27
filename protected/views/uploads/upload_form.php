<?php
/* @var $this UploadsController */
/* @var $model Uploads */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
 $baseurl = Yii::app()->baseUrl;
 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'full-uploads-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'method' => 'post',
    //'action'=> array('uploads/fullupload'), // Yii::app()->createUrl('//uploads/fullupload'),
    'action'=>Yii::app()->createUrl('//uploads/fullupload'),
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php //echo $form->labelEx($model,'instrument_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'instrument_id'); 
              //echo $form->dropDownList($model, 'instrument_id',  CHtml::listData(instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '- Select -'));
        ?>
		<?php //echo $form->error($model,'instrument_id'); ?>
	</div>
 </div>
</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'upload_file'); ?>
		<?php //echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'upload_file'); ?>
	</div>
    

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'upload_file'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
        <?php  $this->widget('CMultiFileUpload',
            array(
                       'model'=>$model,
                       //'name' => 'documents',
                       'attribute' => 'upload_file',
                       'accept'=>'csv|txt|xlsx',
                       'denied'=>'Only csv file is allowed', 
                       'max'=>1,
                       'remove'=>'[x]',
                       'duplicate'=>'Already Selected',
                    )
            );?>
        </div>
        <br />
        <p>CSV or TXT file format example is here.</p>
		<?php //echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'upload_file'); ?>
	</div>
 </div>
</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'upload_file_name'); ?>
		<?php //echo $form->textField($model,'upload_file_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'upload_file_name'); ?>
	</div>


	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'upload_description'); ?>
		<?php //echo $form->textField($model,'upload_description',array('size'=>60,'maxlength'=>255)); 
              //echo $form->textArea($model, 'upload_description', array('maxlength' => 255, 'rows' => 4, 'cols' => 150, 'class'=>'span5'));
        ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
                'model'=>$model,
                'attribute'=>'upload_description',
                'config' => array(
                    'toolbar'=>array(
                        array( /*'Source',*/ '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Undo', 'Redo' ),
                        //array( 'Image', 'Link', 'Unlink', 'Anchor' ) ,
                        array('Styles', 'Format', 'Font', 'FontSize'),
                    ),
                    ),
                )); ?>
		<?php echo $form->error($model,'upload_description'); ?>
	</div>
 </div>

    <div class="clearfix"></div>    
<br />    

<div class="row">
	<div class="form-group">
     <div class="span7">
     </div>
     <div class="col-sm-4 clearLeftPadding">
	 <?php 
     //$baseurl = Yii::app()->baseUrl;
     echo CHtml::submitButton('Upload', ['class'=>"btn btn-primary"]); 
           //echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/prices/returnCalculation', 'class'=>"btn btn-primary"));
     ?>
	</div>
 </div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->