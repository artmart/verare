<?php
/* @var $this TagLimitController */
/* @var $model TagLimit */

$this->breadcrumbs=array(
	'Tag Limits'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TagLimit', 'url'=>array('index')),
	array('label'=>'Manage TagLimit', 'url'=>array('admin')),
);
?>

<h1>Create TagLimit</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>