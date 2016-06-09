<?php
/* @var $this CashFlowTypesController */
/* @var $model CashFlowTypes */

$this->breadcrumbs=array(
	'Cash Flow Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashFlowTypes', 'url'=>array('index')),
	array('label'=>'Create CashFlowTypes', 'url'=>array('create')),
	array('label'=>'Update CashFlowTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashFlowTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashFlowTypes', 'url'=>array('admin')),
);
?>

<h1>View CashFlowTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cash_flow_type',
	),
)); ?>
