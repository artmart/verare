<?php
/* @var $this BenchmarksController */
/* @var $model Benchmarks */

$this->breadcrumbs=array(
	'Benchmarks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Benchmarks', 'url'=>array('index')),
	array('label'=>'Manage Benchmarks', 'url'=>array('admin')),
);
?>

<h1>Create Benchmarks</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>