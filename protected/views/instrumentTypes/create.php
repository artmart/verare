<?php
/* @var $this InstrumentTypesController */
/* @var $model InstrumentTypes */

$this->breadcrumbs=array(
	'Instrument Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InstrumentTypes', 'url'=>array('index')),
	array('label'=>'Manage InstrumentTypes', 'url'=>array('admin')),
);
?>

<h1>Create InstrumentTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>