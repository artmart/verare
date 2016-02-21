<?php
/* @var $this BenchmarkComponentsController */
/* @var $model BenchmarkComponents */

$this->breadcrumbs=array(
	'Benchmark Components'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BenchmarkComponents', 'url'=>array('index')),
	array('label'=>'Create BenchmarkComponents', 'url'=>array('create')),
	array('label'=>'View BenchmarkComponents', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BenchmarkComponents', 'url'=>array('admin')),
);
?>

<h1>Update BenchmarkComponents <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>