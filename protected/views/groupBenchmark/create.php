<?php
/* @var $this GroupBenchmarkController */
/* @var $model GroupBenchmark */

$this->breadcrumbs=array(
	'Group Benchmarks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupBenchmark', 'url'=>array('index')),
	array('label'=>'Manage GroupBenchmark', 'url'=>array('admin')),
);
?>

<h1>Create GroupBenchmark</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>