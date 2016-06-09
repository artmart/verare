<?php
/* @var $this CashFlowTypesController */
/* @var $model CashFlowTypes */

$this->breadcrumbs=array(
	'Cash Flow Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CashFlowTypes', 'url'=>array('index')),
	array('label'=>'Create CashFlowTypes', 'url'=>array('create')),
	array('label'=>'View CashFlowTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashFlowTypes', 'url'=>array('admin')),
);
?>

<h1>Update CashFlowTypes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>