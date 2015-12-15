<?php
/* @var $this PortfolioReturnsController */
/* @var $model PortfolioReturns */

$this->breadcrumbs=array(
	'Portfolio Returns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PortfolioReturns', 'url'=>array('index')),
	array('label'=>'Create PortfolioReturns', 'url'=>array('create')),
	array('label'=>'View PortfolioReturns', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PortfolioReturns', 'url'=>array('admin')),
);
?>

<h1>Update PortfolioReturns <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>