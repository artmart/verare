<?php
/* @var $this DocumentLocationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Document Locations',
);

$this->menu=array(
	array('label'=>'Create DocumentLocations', 'url'=>array('create')),
	array('label'=>'Manage DocumentLocations', 'url'=>array('admin')),
);
?>

<h1>Document Locations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
