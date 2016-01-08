<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-role-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php //echo $form->labelEx($model,'trade_role'); ?>
		<?php //echo $form->textField($model,'trade_role'); ?>
		<?php //echo $form->error($model,'trade_role'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'user_role'); ?>
        </div>
		<?php echo $form->textField($model,'user_role',array('size'=>100,'maxlength'=>255, 'class' => 'span4')); ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'trade_creation'); ?>
		<?php //echo $form->textField($model,'trade_creation'); ?>
		<?php //echo $form->error($model,'trade_creation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'trade_confirmation'); ?>
		<?php //echo $form->textField($model,'trade_confirmation'); ?>
		<?php //echo $form->error($model,'trade_confirmation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'trade_cancellation'); ?>
		<?php //echo $form->textField($model,'trade_cancellation'); ?>
		<?php //echo $form->error($model,'trade_cancellation'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'price_administration'); ?>
		<?php //echo $form->textField($model,'price_administration'); ?>
		<?php //echo $form->error($model,'price_administration'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'instrument_administration'); ?>
		<?php //echo $form->textField($model,'instrument_administration'); ?>
		<?php //echo $form->error($model,'instrument_administration'); ?>
	</div>

	<div class="row">
        <div class="span3">
		<?php echo $form->labelEx($model,'ledger_access_level'); ?>
        </div>
		<?php //echo $form->textField($model,'ledger_access_level'); 
              echo $form->dropDownList($model, 'ledger_access_level',  CHtml::listData(AccessLevels::model()->findAll(array('select'=>'id, access_level', 'order'=>'access_level')),'id','access_level'), array('empty' => '- Select -'));
        ?>
		<?php echo $form->error($model,'ledger_access_level'); ?>
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