<?php
/* @var $this GroupBenchmarkController */
/* @var $model GroupBenchmark */

$this->breadcrumbs=array(
	'Group Benchmarks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupBenchmark', 'url'=>array('index')),
	array('label'=>'Create GroupBenchmark', 'url'=>array('create')),
	array('label'=>'View GroupBenchmark', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupBenchmark', 'url'=>array('admin')),
);
?>

<h1>Update GroupBenchmark <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>