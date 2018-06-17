<?php
/* @var $this TagInstrumentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tag Instruments',
);

$this->menu=array(
	array('label'=>'Create TagInstrument', 'url'=>array('create')),
	array('label'=>'Manage TagInstrument', 'url'=>array('admin')),
);
?>

<h1>Tag Instruments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
