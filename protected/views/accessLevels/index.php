<?php
/* @var $this AccessLevelsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Access Levels',
);

$this->menu=array(
	array('label'=>'Create AccessLevels', 'url'=>array('create')),
	array('label'=>'Manage AccessLevels', 'url'=>array('admin')),
);
?>

<h1>Access Levels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
