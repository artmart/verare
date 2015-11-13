<?php
/* @var $this PortfoliosController */
/* @var $model Portfolios */

$this->breadcrumbs=array(
	'Portfolioses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Portfolios', 'url'=>array('index')),
	array('label'=>'Manage Portfolios', 'url'=>array('admin')),
);
?>

<h1>Create Portfolios</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>