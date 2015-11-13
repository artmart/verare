<?php
/* @var $this DocumentLocationsController */
/* @var $model DocumentLocations */

$this->breadcrumbs=array(
	'Document Locations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DocumentLocations', 'url'=>array('index')),
	array('label'=>'Create DocumentLocations', 'url'=>array('create')),
	array('label'=>'Update DocumentLocations', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DocumentLocations', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentLocations', 'url'=>array('admin')),
);
?>

<h1>View DocumentLocations #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'location',
	),
)); ?>
