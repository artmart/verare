<?php
/* @var $this PortfolioUserRolesController */
/* @var $model PortfolioUserRoles */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'portfolio-user-roles-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->labelEx($model,'user_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'user_id'); 
              echo $form->dropDownList($model, 'user_id',  CHtml::listData(user::model()->findAll(array('select'=>'id, username', 'order'=>'username')),'id','username'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'user_id'); ?>
	 </div>
    </div>
 </div>

 <div class="row">
	<div class="form-group">
     <div class="span2">
		<?php echo $form->labelEx($model,'role_id'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'role_id'); 
              echo $form->dropDownList($model, 'role_id',  CHtml::listData(userrole::model()->findAll(array('select'=>'id, user_role', 'order'=>'user_role')),'id','user_role'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'role_id'); ?>
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
	<div class="form-group">
     <div class="span2">
		<?php //echo $form->labelEx($model,'created_at'); ?>
        </div>
        <div class="col-sm-8 clearLeftPadding">
		<?php //echo $form->textField($model,'created_at'); ?>
		<?php // echo $form->error($model,'created_at'); ?>
	 </div>
    </div>
 </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->