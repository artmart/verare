<?php
/* @var $this DocumentLocationsController */
/* @var $model DocumentLocations */

$this->breadcrumbs=array(
	'Document Locations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DocumentLocations', 'url'=>array('index')),
	array('label'=>'Create DocumentLocations', 'url'=>array('create')),
	array('label'=>'View DocumentLocations', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DocumentLocations', 'url'=>array('admin')),
);
?>

<h1>Update DocumentLocations <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>