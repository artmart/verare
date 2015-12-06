<?php
/* @var $this ReturnsController */
/* @var $model Returns */

$this->breadcrumbs=array(
	'Returns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Returns', 'url'=>array('index')),
	array('label'=>'Create Returns', 'url'=>array('create')),
	array('label'=>'Update Returns', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Returns', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Returns', 'url'=>array('admin')),
);
?>

<h1>View Returns #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'instrument_id',
		'trade_date',
		'return',
	),
)); ?>
