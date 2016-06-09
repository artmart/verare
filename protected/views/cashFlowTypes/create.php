<?php
/* @var $this CashFlowTypesController */
/* @var $model CashFlowTypes */

$this->breadcrumbs=array(
	'Cash Flow Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CashFlowTypes', 'url'=>array('index')),
	array('label'=>'Manage CashFlowTypes', 'url'=>array('admin')),
);
?>

<h1>Create CashFlowTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>