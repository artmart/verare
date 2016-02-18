<br />
<div class="form">
<?php 
$baseurl = Yii::app()->baseUrl; 
$id  = Yii::app()->user->id;
$model=$this->loadModel($id);

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div  class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
  // alert alert-success
?>

<?php /* if(Yii::app()->user->hasFlash('success')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php } ?>
<?php if(Yii::app()->user->hasFlash('error')){?>
    <div class="error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } */?>

<h2>Default Settings Configuration</h2>
<br />
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>
<?php
/*
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
*/
?>
<?php echo $form->hiddenField($model,'id'); ?>
<form class="form-horizontal">
    <div class="row form-group">
        <div class="col-sm-2 control-label">
		<?php echo $form->labelEx($model,'default_start_date'); ?>
        </div>
		<?php //echo $form->textField($model,'default_start_date'); ?>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                //'name'=>'start_date',
                //'id'=>'start_date',
                //'value' => $start_date,
                //'language'=>'nl',
                'attribute'=>'default_start_date',
                'model'=>$model,
                // additional javascript options for the date picker plugin
                //'cssFile' => 'jquery-ui-1.9.2.custom.css',
                'options'=>[
                    'showAnim'=>'fold',
                    'dateFormat'=>'yy-mm-dd',
                    //'onselect'=>'loaddata()',
                ],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control"],
            ]);
        
        ?>
        </div>
		<?php echo $form->error($model,'default_start_date'); ?>
	</div>
 
    <div class="row form-group">
        <div class="col-sm-2 control-label">
		<?php echo $form->labelEx($model,'default_end_date'); ?>
        </div>
		<?php //echo $form->textField($model,'default_end_date'); ?>
        <div class="col-sm-2">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',[
                //'name'=>'end_date',
                //'id'=>'end_date',
                //'value' =>$end_date,
                //'language'=>'nl',
                'attribute'=>'default_end_date',
                'model'=>$model,
                // additional javascript options for the date picker plugin
                //'cssFile' => 'jquery-ui-1.9.2.custom.css',
                'options'=>[
                    'showAnim'=>'fold',
                    'dateFormat'=>'yy-mm-dd',
                 //   'onselect'=>'loaddata()',
                ],
                'htmlOptions'=>['placeholder'=>'YYYY-MM-DD', 'class'=>"form-control"],
            ]);
        
        ?>
        </div>
		<?php echo $form->error($model,'default_end_date'); ?>
	</div>
    
    
    <div class="row form-group">
        <div class="col-sm-2 control-label">
		<?php echo $form->labelEx($model,'default_portfolio_id'); ?>
        </div>
		<?php //echo $form->textField($model,'default_portfolio_id'); ?>
        <div class="col-sm-2">
            <?php
                $list = CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio');
                echo $form->dropDownList($model, 'default_portfolio_id',   $list, [ 'id' => 'portfolio', 'empty' => '-- Select --',  'class'=>"form-control", /*'multiple' => true, 'size'=>'10'*/]);
             ?>
        </div>
		<?php echo $form->error($model,'default_portfolio_id'); ?>
	</div>

	<div class="row buttons">
    <div class="col-sm-2 control-label"></div>
        <div class="col-sm-2">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        <?php echo CHtml::submitButton('Save', array('submit' => $baseurl.'/users/settings', 'class'=>"btn btn-primary",  'style' => 'width:180px;'));?>
        </div>
	</div>
</form>
<?php $this->endWidget(); ?>

</div><!-- form -->