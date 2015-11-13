<?php
/* @var $this InstrumentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Instruments',
);

$this->menu=array(
	array('label'=>'Create Instruments', 'url'=>array('create')),
	array('label'=>'Manage Instruments', 'url'=>array('admin')),
);
?>

<h1>Instruments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
