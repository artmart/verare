<?php
/* @var $this LedgerController */
/* @var $model Ledger */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ledger-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php
/*
<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_date'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'trade_date'); ?>
		<?php echo $form->error($model,'trade_date'); ?>
	</div>
    </div>
 </div>
 */
 ?>
 
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
		<?php echo $form->labelEx($model,'portfolio_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'portfolio_id'); 
              echo $form->dropDownList($model, 'portfolio_id',  CHtml::listData(portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'portfolio_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'nominal'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'nominal'); ?>
		<?php echo $form->error($model,'nominal'); ?>
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
		<?php echo $form->labelEx($model,'created_by'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'created_by'); 
              echo $form->dropDownList($model, 'created_by',  CHtml::listData(user::model()->findAll(array('select'=>'id, username', 'order'=>'username')),'id','username'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'created_by'); ?>
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

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_status_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'trade_status_id'); 
              echo $form->dropDownList($model, 'trade_status_id',  CHtml::listData(tradestatus::model()->findAll(array('select'=>'id, trade_status', 'order'=>'trade_status')),'id','trade_status'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'trade_status_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'confirmed_by'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'confirmed_by'); 
              echo $form->dropDownList($model, 'confirmed_by',  CHtml::listData(user::model()->findAll(array('select'=>'id, username', 'order'=>'username')),'id','username'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'confirmed_by'); ?>
	</div>
    </div>
 </div>
 
 <div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'confirmed_at'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
        <?php //echo $form->textField($model,'confirmed_at'); ?>
        		<?php //echo $form->textField($model,'confirmed_at'); 
                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'confirmed_at',
                    'options' => array('format' =>'Y-m-d', 'timepicker'=>false, 'closeOnDateSelect'=>true), //DateTimePicker options
                    'htmlOptions' => array(),
                    ));
                ?>
        		<?php echo $form->error($model,'confirmed_at'); ?>
            </div>
	</div>
 

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'version_number'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'version_number'); ?>
		<?php echo $form->error($model,'version_number'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'document_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'document_id'); 
              echo $form->dropDownList($model, 'document_id',  CHtml::listData(documents::model()->findAll(array('select'=>'id, document_name', 'order'=>'document_name')),'id','document_name'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'document_id'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'custody_account'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'custody_account',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'custody_account'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'custody_comment'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'custody_comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'custody_comment'); ?>
	</div>
    </div>
 </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'account_number'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php echo $form->textField($model,'account_number'); ?>
		<?php echo $form->error($model,'account_number'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->