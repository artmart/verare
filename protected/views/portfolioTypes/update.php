<?php
/* @var $this PortfolioTypesController */
/* @var $model PortfolioTypes */

$this->breadcrumbs=array(
	'Portfolio Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PortfolioTypes', 'url'=>array('index')),
	array('label'=>'Create PortfolioTypes', 'url'=>array('create')),
	array('label'=>'View PortfolioTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PortfolioTypes', 'url'=>array('admin')),
);
?>

<h1>Update PortfolioTypes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>