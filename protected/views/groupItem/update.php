<?php
/* @var $this GroupItemController */
/* @var $model GroupItem */

$this->breadcrumbs=array(
	'Group Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GroupItem', 'url'=>array('index')),
	array('label'=>'Create GroupItem', 'url'=>array('create')),
	array('label'=>'View GroupItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupItem', 'url'=>array('admin')),
);
?>

<h1>Update GroupItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>