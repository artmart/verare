<?php
/* @var $this BenchmarkComponentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Benchmark Components',
);

$this->menu=array(
	array('label'=>'Create BenchmarkComponents', 'url'=>array('create')),
	array('label'=>'Manage BenchmarkComponents', 'url'=>array('admin')),
);
?>

<h1>Benchmark Components</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
