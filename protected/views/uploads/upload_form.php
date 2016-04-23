<div class="form">
<h3>Upload Pricies</h3>
<?php 
 $baseurl = Yii::app()->baseUrl;
 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'full-uploads-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'method' => 'post',
    'action'=> array('uploads/fullupload'), // Yii::app()->createUrl('//uploads/fullupload'),
    //'action'=>Yii::app()->createUrl('//uploads/fullupload'),
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	
<div class="col-sm-7 clearLeftPadding">  
<?php echo $form->errorSummary($model); ?>
	<div class="row">
    
    <div class="col-sm-12 control-label">
    <p> The data should be an excel file, with the sheet name "Sheet1" and the data starting in cell A1. 
        The data should be dates (dd/mm/yyyy) in column A, name of instruments in column B, and price in column C.
        The instruments in the list will be created if they don't exist previously.
    </p>
    </div>  
	</div>
    
    <br />
    <div class="row">
    	<div class="form-group">
         <div class="col-sm-2 control-label">
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
            
            <br />
            <!--<p>CSV or TXT file format example is here.</p>-->
    		<?php //echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
    		<?php echo $form->error($model,'upload_file'); ?>
            </div>
    	</div>
     </div>

    <br />
	
    <div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'upload_description'); ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php echo $form->textArea($model, 'upload_description', array('maxlength' => 255, 'rows' => 3, 'cols' => 80)); ?>
		<?php echo $form->error($model,'upload_description'); ?>
	</div>
 </div>
   
<br />    

<div class="row">
	<div class="form-group">
     <div class="span3">
     </div>
     <div class="col-sm-4 clearLeftPadding">
	 <?php echo CHtml::submitButton('Upload', ['class'=>"btn btn-primary", 'id'=>'upload']); ?>
	</div>
 </div>
</div>
</div>

    <div class="col-sm-5">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/xlsx_upload_example.jpg" alt="xlsx upload example">
    </div>

<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo Yii::app()->theme->baseUrl;?>/img/demo_wait.gif' width="64" height="64" /><br>Loading..</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
//$("#wait").css("display", "block");
$('#upload').click(function(){
  //$('#wait').show(); //<----here
   $("#wait").css("display", "block");

});
</script>