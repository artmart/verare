<?php
/* @var $this UploadsController */
/* @var $model Uploads */

$this->breadcrumbs=array(
	'Uploads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Uploads', 'url'=>array('index')),
	array('label'=>'Manage Uploads', 'url'=>array('admin')),
);
?>

<h1>Upload price data</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>