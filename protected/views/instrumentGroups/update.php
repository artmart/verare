<?php
/* @var $this InstrumentGroupsController */
/* @var $model InstrumentGroups */

$this->breadcrumbs=array(
	'Instrument Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InstrumentGroups', 'url'=>array('index')),
	array('label'=>'Create InstrumentGroups', 'url'=>array('create')),
	array('label'=>'View InstrumentGroups', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InstrumentGroups', 'url'=>array('admin')),
);
?>

<h1>Update InstrumentGroups <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>