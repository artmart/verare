<?php
/* @var $this BenchmarksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Benchmarks',
);

$this->menu=array(
	array('label'=>'Create Benchmarks', 'url'=>array('create')),
	array('label'=>'Manage Benchmarks', 'url'=>array('admin')),
);
?>

<h1>Benchmarks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
