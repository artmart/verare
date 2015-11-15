<?php
/* @var $this UserRoleController */
/* @var $model UserRole */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-role-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
     
 <div class="row">
     <div class="form-group">
     <div class="span2">
        <?php echo $form->labelEx($model,'user_role'); ?>
     </div>
      <div class="col-sm-6 clearLeftPadding">      
        <?php echo $form->textField($model,'user_role',array('size'=>255,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_role'); ?>
      </div>
    </div>
  </div>
    
  <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_creation'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'trade_creation'); 
              echo $form->checkBox($model,'trade_creation',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'trade_creation'); ?>
	</div>
    </div>
 </div>

 <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_confirmation'); ?>
        </div>
        <div class="col-sm-6 clearLeftPadding">
		<?php //echo $form->textField($model,'trade_confirmation'); 
              echo $form->checkBox($model,'trade_confirmation',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'trade_confirmation'); ?>
	   </div>
    </div>
  </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'trade_cancellation'); ?>
        </div>
        <div class="col-sm-6 clearLeftPadding">
		<?php //echo $form->textField($model,'trade_cancellation'); 
              echo $form->checkBox($model,'trade_cancellation',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'trade_cancellation'); ?>
	   </div>
    </div>
  </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'price_administration'); ?>
        </div>
        <div class="col-sm-6 clearLeftPadding">
		<?php //echo $form->textField($model,'price_administration'); 
              echo $form->checkBox($model,'price_administration',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'price_administration'); ?>
	   </div>
    </div>
  </div>

<div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'instrument_administration'); ?>
        </div>
        <div class="col-sm-6 clearLeftPadding">
		<?php //echo $form->textField($model,'instrument_administration'); 
                echo $form->checkBox($model,'instrument_administration',array('value'=>1,'uncheckValue'=>0,'style'=>'margin-top:7px;'));
        ?>
		<?php echo $form->error($model,'instrument_administration'); ?>
	   </div>
    </div>
  </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->