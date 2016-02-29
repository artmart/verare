<?php
/* @var $this InstrumentGroupsController */
/* @var $model InstrumentGroups */

$this->breadcrumbs=array(
	'Instrument Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InstrumentGroups', 'url'=>array('index')),
	array('label'=>'Manage InstrumentGroups', 'url'=>array('admin')),
);
?>

<h1>Create InstrumentGroups</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>