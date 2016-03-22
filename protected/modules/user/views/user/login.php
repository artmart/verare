<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="page-header">
	<h1>Login <small>to your account</small></h1>
</div>
<div class="row-fluid">
	
    <div class="span6 offset3">
    <h2>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h2>
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Private access",
	));
	
?>



    <p>Please fill out the following form with your login credentials:</p>
    
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <p class="note">Fields with <span class="required">*</span> are required.</p>
    
        <div class="row form-group">
            <div class="col-md-3 control-label">
                <?php echo $form->labelEx($model,'username'); ?>
            </div>
            <div class="col-md-4">
            <?php echo $form->textField($model,'username', ['class'=>'form-control']); ?>
            <?php echo $form->error($model,'username'); ?>
            </div>
        </div>
    
        <div class="row form-group">
            <div class="col-md-3 control-label">
                <?php echo $form->labelEx($model,'password'); ?>
            </div>
            <div class="col-md-4">
            <?php echo $form->passwordField($model,'password', ['class'=>'form-control']); ?>
            <?php echo $form->error($model,'password'); ?>
            </div>
           <!-- <p class="hint">
                Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
            </p>
			-->
        </div>
    
        <div class="row rememberMe">
            <div class="col-md-3 control-label">
                <?php echo $form->label($model,'rememberMe'); ?>
                
            </div>
            <div class="col-md-4">
            <?php echo $form->checkBox($model,'rememberMe', ['class'=>'checkbox']); ?>
            <?php echo $form->error($model,'rememberMe'); ?>
            </div>
        </div>
    
        <div class="row buttons">
            <div class="col-md-3 control-label"></div>
            <div class="col-md-4">
            <?php echo CHtml::submitButton('Login',array('class'=>'btn btn btn-primary', 'style' => 'width: 360px')); ?>
            </div>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>

    </div>

</div>