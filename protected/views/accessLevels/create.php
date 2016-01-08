<?php
/* @var $this AccessLevelsController */
/* @var $model AccessLevels */

$this->breadcrumbs=array(
	'Access Levels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccessLevels', 'url'=>array('index')),
	array('label'=>'Manage AccessLevels', 'url'=>array('admin')),
);
?>

<h1>Create AccessLevels</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>