<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-role-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?> 
   
<div class="row form-group">
  <label class="col-md-2 control-label"><?php echo $form->labelEx($model,'user_role'); ?></label>  
  <div class="col-md-4"> 
  <?php echo $form->textField($model,'user_role',array('size'=>100,'maxlength'=>255, 'class' => 'form-control input-md')); ?>
  <?php echo $form->error($model,'user_role'); ?>
  </div>
</div>

<div class="row form-group">
  <label class="col-md-2 control-label">Access to Actions</label>  
  <div class="col-md-4"> 
  <div class="span2">Create</div><div class="span2">Edit</div><div class="span2">Delete</div><div class="span3">Status Change</div>
  </div>
</div> 

	<div class="row form-group">
        <div class="col-md-2 control-label">
		<?php echo $form->labelEx($model,'ledger_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'ledger_access_level'); 
              //echo $form->dropDownList($model, 'ledger_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
          //echo CHTML::checkBox($model,'ledger_access_level',  array('checked'=>'checked'));
          $ledger_create = 0;
          $ledger_edit = 0;
          $ledger_delete = 0;
          $ledger_status_change = 0;
          if(isset($model->ledger_access_level) && $model->ledger_access_level !== ''){
            $ledgar_access = json_decode($model->ledger_access_level);
          
          $ledger_create = $ledgar_access->create;
          $ledger_edit = $ledgar_access->edit;
          $ledger_delete = $ledgar_access->delete;
          $ledger_status_change = $ledgar_access->status_change;
          }
        ?>
        <div class="col-md-4">
            <div class="span2"><?php echo CHtml::CheckBox('ledger_create', $ledger_create, array('checked'=>'checked', 'value'=>'1', 'class' => 'checkbox')); ?></div>
            <div class="span2"><?php echo CHtml::CheckBox('ledger_edit', $ledger_edit, array('checked'=>'checked', 'value'=>'1', 'class' => 'checkbox')); ?></div>
            <div class="span2"><?php echo CHtml::CheckBox('ledger_delete', $ledger_delete, array('checked'=>'checked', 'value'=>'1', 'class' => 'checkbox')); ?></div>
            <div class="span2"><?php echo CHtml::CheckBox('ledger_status_change', $ledger_status_change, array('checked'=>'checked', 'value'=>'1', 'class' => 'checkbox')); ?></div>
          
		<?php echo $form->error($model,'ledger_access_level'); ?>
        </div>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'users_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'users_access_level'); 
              echo $form->dropDownList($model, 'users_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'users_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'user_roles_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'user_roles_access_level'); 
              echo $form->dropDownList($model, 'user_roles_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'user_roles_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'portfolios_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'portfolios_access_level'); 
              echo $form->dropDownList($model, 'portfolios_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'portfolios_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'instruments_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'instruments_access_level'); 
              echo $form->dropDownList($model, 'instruments_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'instruments_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'counterparties_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'counterparties_access_level'); 
              echo $form->dropDownList($model, 'counterparties_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'counterparties_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'documents_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'documents_access_level'); 
              echo $form->dropDownList($model, 'documents_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'documents_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'prices_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'prices_access_level'); 
              echo $form->dropDownList($model, 'prices_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'prices_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'audit_trails_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'audit_trails_access_level'); 
              echo $form->dropDownList($model, 'audit_trails_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'audit_trails_access_level'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'grouping_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'grouping_access_level'); 
              echo $form->dropDownList($model, 'grouping_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'grouping_access_level'); ?>
	</div>

	<div class="row buttons">
        <div class="span3"></div>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class'=>"btn btn-primary span4"]); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->