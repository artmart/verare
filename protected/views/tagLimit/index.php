<?php
/* @var $this TagLimitController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tag Limits',
);

$this->menu=array(
	array('label'=>'Create TagLimit', 'url'=>array('create')),
	array('label'=>'Manage TagLimit', 'url'=>array('admin')),
);
?>

<h1>Tag Limits</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
