<?php
/* @var $this CashFlowsController */
/* @var $model CashFlows */

$this->breadcrumbs=array(
	'Cash Flows'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CashFlows', 'url'=>array('index')),
	array('label'=>'Create CashFlows', 'url'=>array('create')),
	array('label'=>'Update CashFlows', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CashFlows', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CashFlows', 'url'=>array('admin')),
);
?>

<h1>View CashFlows #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cash_flow_date',
		'instrument',
		'cash_flow',
		'type',
	),
)); ?>
