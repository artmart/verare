<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Currencies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Currencies', 'url'=>array('index')),
	array('label'=>'Create Currencies', 'url'=>array('create')),
	array('label'=>'View Currencies', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Currencies', 'url'=>array('admin')),
);
?>

<h1>Update Currencies <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>