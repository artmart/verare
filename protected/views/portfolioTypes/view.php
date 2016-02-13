<?php
/* @var $this PortfolioTypesController */
/* @var $model PortfolioTypes */

$this->breadcrumbs=array(
	'Portfolio Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PortfolioTypes', 'url'=>array('index')),
	array('label'=>'Create PortfolioTypes', 'url'=>array('create')),
	array('label'=>'Update PortfolioTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PortfolioTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PortfolioTypes', 'url'=>array('admin')),
);
?>

<h1>View PortfolioTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'portfolio_type',
		'allocation_min',
		'allocation_max',
		'allocation_normal',
	),
)); ?>
