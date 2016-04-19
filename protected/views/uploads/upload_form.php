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

	<?php echo $form->errorSummary($model); ?>
<div class="col-sm-7 clearLeftPadding">  

<?php /* 
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
*/
?>
	<div class="row">
    
    <div class="col-sm-12 control-label">
    <p> The data should be an excel file, with the sheet name "Sheet1" and the data starting in cell A1. 
        The data should be dates (dd/mm/yyyy) in column A, name of instruments in column B, and price in column C.
        The instruments in the list will be created if they don't exist previously.
    </p>
    </div>  
    
		<?php 
        
        //style="width:304px;height:228px;"
        //echo $form->labelEx($model,'upload_file'); ?>
		<?php //echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'upload_file'); ?>
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
        </div>
        <br />
        <!--<p>CSV or TXT file format example is here.</p>-->
		<?php //echo $form->textField($model,'upload_file',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'upload_file'); ?>
	</div>
 </div>

<br />
	<div class="row">
		<?php //echo $form->labelEx($model,'upload_file_name'); ?>
		<?php //echo $form->textField($model,'upload_file_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'upload_file_name'); ?>
	</div>


	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'upload_description'); ?>
		<?php //echo $form->textField($model,'upload_description',array('size'=>60,'maxlength'=>255)); 
              
        ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php 
        echo $form->textArea($model, 'upload_description', array('maxlength' => 255, 'rows' => 3, 'cols' => 80));
        /*
        $this->widget('application.extensions.eckeditor.ECKEditor', array(
                'model'=>$model,
                'attribute'=>'upload_description',
                'config' => array(
                    'toolbar'=>array(
                        array( /*'Source',*//* '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Undo', 'Redo' ),
                        //array( 'Image', 'Link', 'Unlink', 'Anchor' ) ,
                        array('Styles', 'Format', 'Font', 'FontSize'),
                    ),
                    ),
                )); 
                */
                ?>
		<?php echo $form->error($model,'upload_description'); ?>
	</div>
 </div>

    <div class="clearfix"></div>    
<br />    

<div class="row">
	<div class="form-group">
     <div class="span3">
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


</div>




    <div class="col-sm-5">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/xlsx_upload_example.jpg" alt="xlsx upload example">
    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->