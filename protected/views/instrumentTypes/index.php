<?php
/* @var $this InstrumentTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Instrument Types',
);

$this->menu=array(
	array('label'=>'Create InstrumentTypes', 'url'=>array('create')),
	array('label'=>'Manage InstrumentTypes', 'url'=>array('admin')),
);
?>

<h1>Instrument Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
