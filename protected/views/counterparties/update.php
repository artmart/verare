<?php
/* @var $this CounterpartiesController */
/* @var $model Counterparties */

$this->breadcrumbs=array(
	'Counterparties'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Counterparties', 'url'=>array('index')),
	array('label'=>'Create Counterparties', 'url'=>array('create')),
	array('label'=>'View Counterparties', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Counterparties', 'url'=>array('admin')),
);
?>

<h1>Update Counterparties <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>