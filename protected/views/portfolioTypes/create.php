<?php
/* @var $this PortfolioTypesController */
/* @var $model PortfolioTypes */

$this->breadcrumbs=array(
	'Portfolio Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PortfolioTypes', 'url'=>array('index')),
	array('label'=>'Manage PortfolioTypes', 'url'=>array('admin')),
);
?>

<h1>Create PortfolioTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>