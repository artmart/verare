<?php
/* @var $this CashFlowsController */
/* @var $model CashFlows */

$this->breadcrumbs=array(
	'Cash Flows'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CashFlows', 'url'=>array('index')),
	array('label'=>'Manage CashFlows', 'url'=>array('admin')),
);
?>

<h1>Create CashFlows</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>