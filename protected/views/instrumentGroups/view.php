<?php
/* @var $this InstrumentGroupsController */
/* @var $model InstrumentGroups */

$this->breadcrumbs=array(
	'Instrument Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InstrumentGroups', 'url'=>array('index')),
	array('label'=>'Create InstrumentGroups', 'url'=>array('create')),
	array('label'=>'Update InstrumentGroups', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InstrumentGroups', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InstrumentGroups', 'url'=>array('admin')),
);
?>

<h1>View InstrumentGroups #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_name',
		'allocation_min',
		'allocation_max',
		'allocation_normal',
	),
)); ?>
