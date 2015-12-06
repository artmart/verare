<?php
/* @var $this ReturnsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Returns',
);

$this->menu=array(
	array('label'=>'Create Returns', 'url'=>array('create')),
	array('label'=>'Manage Returns', 'url'=>array('admin')),
);
?>

<h1>Returns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
