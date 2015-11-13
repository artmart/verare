<?php
/* @var $this GroupingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Groupings',
);

$this->menu=array(
	array('label'=>'Create Grouping', 'url'=>array('create')),
	array('label'=>'Manage Grouping', 'url'=>array('admin')),
);
?>

<h1>Groupings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
