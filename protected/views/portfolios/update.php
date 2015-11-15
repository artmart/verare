<?php
/* @var $this PortfoliosController */
/* @var $model Portfolios */

$this->breadcrumbs=array(
	'Portfolioses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Portfolios', 'url'=>array('index')),
	array('label'=>'Create Portfolios', 'url'=>array('create')),
	array('label'=>'View Portfolios', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Portfolios', 'url'=>array('admin')),
);
?>

<h1>Update Portfolio: <?php echo $model->portfolio; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>