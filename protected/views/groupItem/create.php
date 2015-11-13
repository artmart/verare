<?php
/* @var $this GroupItemController */
/* @var $model GroupItem */

$this->breadcrumbs=array(
	'Group Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GroupItem', 'url'=>array('index')),
	array('label'=>'Manage GroupItem', 'url'=>array('admin')),
);
?>

<h1>Create GroupItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>