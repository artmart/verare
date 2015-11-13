<?php
/* @var $this GroupBenchmarkController */
/* @var $model GroupBenchmark */

$this->breadcrumbs=array(
	'Group Benchmarks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupBenchmark', 'url'=>array('index')),
	array('label'=>'Create GroupBenchmark', 'url'=>array('create')),
	array('label'=>'Update GroupBenchmark', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupBenchmark', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupBenchmark', 'url'=>array('admin')),
);
?>

<h1>View GroupBenchmark #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'item_id',
		'item_table',
		'item_weight',
	),
)); ?>
