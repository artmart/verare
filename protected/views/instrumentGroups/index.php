<?php
/* @var $this InstrumentGroupsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Instrument Groups',
);

$this->menu=array(
	array('label'=>'Create InstrumentGroups', 'url'=>array('create')),
	array('label'=>'Manage InstrumentGroups', 'url'=>array('admin')),
);
?>

<h1>Instrument Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
