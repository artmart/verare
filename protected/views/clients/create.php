<?php
/* @var $this ClientsController */
/* @var $model Clients */

$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Clients', 'url'=>array('index')),
	array('label'=>'Manage Clients', 'url'=>array('admin')),
);
?>

<h1>Create Client</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>