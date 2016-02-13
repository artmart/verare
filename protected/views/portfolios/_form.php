<?php
/* @var $this PortfoliosController */
/* @var $model Portfolios */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'portfolios-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'client_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'client_id'); 
              echo $form->dropDownList($model, 'client_id',  CHtml::listData(clients::model()->findAll(array('select'=>'id, client_name', 'order'=>'client_name')),'id','client_name'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'client_id'); ?>
	</div>
    </div>
 </div>

	<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'portfolio'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'portfolio',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'portfolio'); ?>
	</div>
    </div>
 </div>

	<div class="row">
		<?php //echo $form->labelEx($model,'description'); ?>
		<?php //echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($model,'description'); ?>
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
		<?php //echo $form->labelEx($model,'created_at'); ?>
		<?php //echo $form->textField($model,'created_at'); ?>
		<?php //echo $form->error($model,'created_at'); ?>
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
    
  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php //echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); 
              //echo $form->textArea($model, 'description', array('maxlength' => 255, 'rows' => 4, 'cols' => 150, 'class'=>'span5'));
        ?>
        </div>
        <div class="span6" style="margin-left: -5px;">
        <?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
                'model'=>$model,
                'attribute'=>'description',
                'config' => array(
                    'toolbar'=>array(
                        array( /*'Source',*/ '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Undo', 'Redo' ),
                        //array( 'Image', 'Link', 'Unlink', 'Anchor' ) ,
                        array('Styles', 'Format', 'Font', 'FontSize'),
                    ),
                    ),
                )); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
 </div>
</div>

	<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'type_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'type_id'); 
              echo $form->dropDownList($model, 'type_id',  CHtml::listData(PortfolioTypes::model()->findAll(array('select'=>'id, portfolio_type', 'order'=>'portfolio_type')),'id','portfolio_type'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>
    </div>
 </div>


    
    <div class="clearfix"></div>
<br />    
 <br />   

    

	<div class="col-sm-offset-8 col-sm-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->