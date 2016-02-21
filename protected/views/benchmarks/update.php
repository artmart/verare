<?php
/* @var $this BenchmarksController */
/* @var $model Benchmarks */

$this->breadcrumbs=array(
	'Benchmarks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Benchmarks', 'url'=>array('index')),
	array('label'=>'Create Benchmarks', 'url'=>array('create')),
	array('label'=>'View Benchmarks', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Benchmarks', 'url'=>array('admin')),
);
?>

<h1>Update Benchmarks <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>