<?php
/* @var $this TagLimitController */
/* @var $model TagLimit */

$this->breadcrumbs=array(
	'Tag Limits'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TagLimit', 'url'=>array('index')),
	array('label'=>'Create TagLimit', 'url'=>array('create')),
	array('label'=>'View TagLimit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TagLimit', 'url'=>array('admin')),
);
?>

<h1>Update TagLimit <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>