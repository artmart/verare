<?php
/* @var $this CounterpartiesController */
/* @var $model Counterparties */

$this->breadcrumbs=array(
	'Counterparties'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Counterparties', 'url'=>array('index')),
	array('label'=>'Create Counterparties', 'url'=>array('create')),
	array('label'=>'Update Counterparties', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Counterparties', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Counterparties', 'url'=>array('admin')),
);
?>

<h1>View Counterparties #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'contact_info',
		'company_id',
		'documents',
	),
)); ?>
