<?php
/* @var $this PortfoliosController */
/* @var $model Portfolios */

$this->breadcrumbs=array(
	'Portfolioses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Portfolios', 'url'=>array('index')),
	array('label'=>'Create Portfolios', 'url'=>array('create')),
	array('label'=>'Update Portfolios', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Portfolios', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Portfolios', 'url'=>array('admin')),
);
?>

<h1>View Portfolios #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client_id',
		'portfolio',
		'description',
		'is_current',
		'created_at',
	),
)); ?>
