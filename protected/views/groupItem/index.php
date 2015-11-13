<?php
/* @var $this GroupItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Group Items',
);

$this->menu=array(
	array('label'=>'Create GroupItem', 'url'=>array('create')),
	array('label'=>'Manage GroupItem', 'url'=>array('admin')),
);
?>

<h1>Group Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
