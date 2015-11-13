<?php
/* @var $this GroupItemController */
/* @var $model GroupItem */

$this->breadcrumbs=array(
	'Group Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GroupItem', 'url'=>array('index')),
	array('label'=>'Create GroupItem', 'url'=>array('create')),
	array('label'=>'Update GroupItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GroupItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GroupItem', 'url'=>array('admin')),
);
?>

<h1>View GroupItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'item_id',
		'item_table',
		'item_weight',
		'is_current',
		'created_at',
	),
)); ?>
