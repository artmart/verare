<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */

$this->breadcrumbs=array(
	'Benchmark Components'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BenchmarkComponents', 'url'=>array('index')),
	array('label'=>'Manage BenchmarkComponents', 'url'=>array('admin')),
);
?>

<h1>Create BenchmarkComponents</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>