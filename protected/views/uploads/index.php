<?php
/* @var $this UploadsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Uploads',
);

$this->menu=array(
	array('label'=>'Create Uploads', 'url'=>array('create')),
	array('label'=>'Manage Uploads', 'url'=>array('admin')),
);
?>

<h1>Uploads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
