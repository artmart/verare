<?php
/* @var $this PortfolioReturnsController */
/* @var $model PortfolioReturns */

$this->breadcrumbs=array(
	'Portfolio Returns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PortfolioReturns', 'url'=>array('index')),
	array('label'=>'Manage PortfolioReturns', 'url'=>array('admin')),
);
?>

<h1>Create PortfolioReturns</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>