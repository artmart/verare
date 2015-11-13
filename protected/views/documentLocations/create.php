<?php
/* @var $this DocumentLocationsController */
/* @var $model DocumentLocations */

$this->breadcrumbs=array(
	'Document Locations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DocumentLocations', 'url'=>array('index')),
	array('label'=>'Manage DocumentLocations', 'url'=>array('admin')),
);
?>

<h1>Create DocumentLocations</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>