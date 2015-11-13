<?php
/* @var $this GroupBenchmarkController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Group Benchmarks',
);

$this->menu=array(
	array('label'=>'Create GroupBenchmark', 'url'=>array('create')),
	array('label'=>'Manage GroupBenchmark', 'url'=>array('admin')),
);
?>

<h1>Group Benchmarks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
