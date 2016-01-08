<?php
/* @var $this AccessLevelsController */
/* @var $model AccessLevels */

$this->breadcrumbs=array(
	'Access Levels'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AccessLevels', 'url'=>array('index')),
	array('label'=>'Create AccessLevels', 'url'=>array('create')),
	array('label'=>'Update AccessLevels', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AccessLevels', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccessLevels', 'url'=>array('admin')),
);
?>

<h1>View AccessLevels #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'access_level',
	),
)); ?>
