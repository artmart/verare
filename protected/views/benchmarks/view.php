<?php
/* @var $this BenchmarksController */
/* @var $model Benchmarks */

$this->breadcrumbs=array(
	'Benchmarks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Benchmarks', 'url'=>array('index')),
	array('label'=>'Create Benchmarks', 'url'=>array('create')),
	array('label'=>'Update Benchmarks', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Benchmarks', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Benchmarks', 'url'=>array('admin')),
);
?>

<h1>View Benchmarks #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client_id',
		'portfolio_id',
		'benchmark_name',
	),
)); ?>
