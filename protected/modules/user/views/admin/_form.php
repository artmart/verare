<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'username'); ?>
        </div>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'password'); ?>
        </div>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'email'); ?>
        </div>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
<!--
	<div class="row">
        <div class="span2">
		<?php //echo $form->labelEx($model,'superuser'); ?>
        </div>
		<?php //echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
		<?php //echo $form->error($model,'superuser'); ?>
	</div>
 -->   
    <div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'user_role'); ?>
        </div>
		<?php //echo $form->dropDownList($model,'user_role',User::itemAlias('AdminStatus')); 
              echo $form->dropDownList($model, 'user_role',  CHtml::listData(UserRole::model()->findAll(array('select'=>'id, user_role', 'order'=>'user_role')),'id','user_role'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($model,'status'); ?>
        </div>
		<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
        <div class="span2">
		<?php echo $form->labelEx($profile,$field->varname); ?>
        </div>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>
			<?php
			}
		}
?>
	<div class="row buttons">
        <div class="span2"></div>
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), ['class'=>"btn btn-primary span2"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->