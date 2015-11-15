<?php
/* @var $this DocumentTypesController */
/* @var $model DocumentTypes */

$this->breadcrumbs=array(
	'Document Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DocumentTypes', 'url'=>array('index')),
	array('label'=>'Create DocumentTypes', 'url'=>array('create')),
	array('label'=>'View DocumentTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DocumentTypes', 'url'=>array('admin')),
);
?>

<h1>Update Document Type: <?php echo $model->document_type; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>