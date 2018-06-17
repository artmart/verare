<?php
/* @var $this TagLimitController */
/* @var $model TagLimit */

$this->breadcrumbs=array(
	'Tag Limits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TagLimit', 'url'=>array('index')),
	array('label'=>'Create TagLimit', 'url'=>array('create')),
	array('label'=>'Update TagLimit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TagLimit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TagLimit', 'url'=>array('admin')),
);
?>

<h1>View TagLimit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tag',
		'limit_min',
		'limit_max',
		'client_id',
		'portfolio_id',
	),
)); ?>
