 <?php 
    $baseurl11 = Yii::app()->baseUrl;
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'action'=>Yii::app()->createUrl('/user/login'),
        //'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
        //'clientOptions'=>array(
        //  'validateOnSubmit'=>true,
       // ),
     //'focus'=>array($model,'name')
    )); ?>
  
        <div class="row">
            <div class="span2">
                <?php //echo $form->labelEx($model,'username'); ?>
            </div>
            <div class="span2">
            <?php echo $form->textField($model,'username', ['class'=>"form-control", 'placeholder'=>"Userame"]); ?>
            <?php echo $form->error($model,'username'); ?>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="span2">
                <?php //echo $form->labelEx($model,'password'); ?>
            </div>
            <div class="span2">
            <?php echo $form->passwordField($model,'password', ['class'=>"form-control", 'placeholder'=>"Password"]); ?>
            <?php echo $form->error($model,'password'); ?>
            </div>
        </div>
    
        <div class="row rememberMe">
            <div class="span2">
                <?php //echo $form->label($model,'rememberMe'); ?>
                
            </div>
            <div class="span2">
            <?php //echo $form->checkBox($model,'rememberMe'); ?>
            <?php //echo $form->error($model,'rememberMe'); ?>
            </div>
        </div>
    
        <div class="row buttons">
            <div class="span2"></div>
            <div class="span2">
            <?php //echo CHtml::submitButton('Login',array('class'=>'btn btn btn-primary', 'style' => 'width: 220px')); ?>
            <?php //echo CHtml::ajaxSubmitButton('Login',array($baseurl11.'/user/login'), array('success'=>'loaddata()'),  array('class'=>"btn btn-primary", 'style' => 'width:220px;')); ?> 
        <?php echo CHtml::submitButton('Login', ['submit' => $baseurl11.'/user/login', 'class'=>"btn btn-primary", 'style' => 'width:100%;']);?>
            </div>
        </div>
    
<?php $this->endWidget(); ?>
