<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Currencies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Currencies', 'url'=>array('index')),
	array('label'=>'Manage Currencies', 'url'=>array('admin')),
);
?>

<h1>Create Currencies</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>