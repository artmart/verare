<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */

$this->breadcrumbs=array(
	'Benchmark Components'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BenchmarkComponents', 'url'=>array('index')),
	array('label'=>'Create BenchmarkComponents', 'url'=>array('create')),
	array('label'=>'Update BenchmarkComponents', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BenchmarkComponents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BenchmarkComponents', 'url'=>array('admin')),
);
?>

<h1>View BenchmarkComponents #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'benchmark_id',
		'instrument_id',
		'is_instrument_or_portfolio',
		'weight',
	),
)); ?>
