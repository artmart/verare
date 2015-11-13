<?php
/* @var $this GroupingController */
/* @var $model Grouping */

$this->breadcrumbs=array(
	'Groupings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Grouping', 'url'=>array('index')),
	array('label'=>'Create Grouping', 'url'=>array('create')),
	array('label'=>'View Grouping', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Grouping', 'url'=>array('admin')),
);
?>

<h1>Update Grouping <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>