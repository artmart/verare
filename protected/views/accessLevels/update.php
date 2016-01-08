<?php
/* @var $this AccessLevelsController */
/* @var $model AccessLevels */

$this->breadcrumbs=array(
	'Access Levels'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccessLevels', 'url'=>array('index')),
	array('label'=>'Create AccessLevels', 'url'=>array('create')),
	array('label'=>'View AccessLevels', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AccessLevels', 'url'=>array('admin')),
);
?>

<h1>Update AccessLevels <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>