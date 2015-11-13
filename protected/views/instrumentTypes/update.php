<?php
/* @var $this InstrumentTypesController */
/* @var $model InstrumentTypes */

$this->breadcrumbs=array(
	'Instrument Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InstrumentTypes', 'url'=>array('index')),
	array('label'=>'Create InstrumentTypes', 'url'=>array('create')),
	array('label'=>'View InstrumentTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InstrumentTypes', 'url'=>array('admin')),
);
?>

<h1>Update InstrumentTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>