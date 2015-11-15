<?php
/* @var $this PricesController */
/* @var $model Prices */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prices-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
 
 <div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'trade_date'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
        <?php //echo $form->textField($model,'trade_date'); ?>
        		<?php //echo $form->textField($model,'trade_date'); 
                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'trade_date',
                    'options' => array('format' =>'Y-m-d', 'timepicker'=>false, 'closeOnDateSelect'=>true), //DateTimePicker options
                    'htmlOptions' => array(),
                    ));
                ?>
        		<?php echo $form->error($model,'trade_date'); ?>
            </div>
	</div>
 

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'instrument_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'instrument_id'); 
              echo $form->dropDownList($model, 'instrument_id',  CHtml::listData(instruments::model()->findAll(array('select'=>'id, instrument', 'order'=>'instrument')),'id','instrument'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'instrument_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'price'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
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