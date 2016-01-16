<?php
/* @var $this CounterpartiesController */
/* @var $model Counterparties */

$this->breadcrumbs=array(
	'Counterparties'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Counterparties', 'url'=>array('index')),
	array('label'=>'Manage Counterparties', 'url'=>array('admin')),
);
?>

<h1>Create Counterparties</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>