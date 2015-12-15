<?php
/* @var $this PortfolioReturnsController */
/* @var $model PortfolioReturns */

$this->breadcrumbs=array(
	'Portfolio Returns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PortfolioReturns', 'url'=>array('index')),
	array('label'=>'Create PortfolioReturns', 'url'=>array('create')),
	array('label'=>'Update PortfolioReturns', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PortfolioReturns', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PortfolioReturns', 'url'=>array('admin')),
);
?>

<h1>View PortfolioReturns #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'portfolio_id',
		'is_prtfolio_or_group',
		'trade_date',
		'return',
	),
)); ?>
