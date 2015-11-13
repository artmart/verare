<?php
/* @var $this GroupingController */
/* @var $model Grouping */

$this->breadcrumbs=array(
	'Groupings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Grouping', 'url'=>array('index')),
	array('label'=>'Manage Grouping', 'url'=>array('admin')),
);
?>

<h1>Create Grouping</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>