<?php
/* @var $this GroupingController */
/* @var $model Grouping */

$this->breadcrumbs=array(
	'Groupings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Grouping', 'url'=>array('index')),
	array('label'=>'Create Grouping', 'url'=>array('create')),
	array('label'=>'Update Grouping', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Grouping', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Grouping', 'url'=>array('admin')),
);
?>

<h1>View Grouping #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_name',
		'is_current',
		'created_at',
	),
)); ?>
