<?php
/* @var $this TagInstrumentController */
/* @var $model TagInstrument */

$this->breadcrumbs=array(
	'Tag Instruments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TagInstrument', 'url'=>array('index')),
	array('label'=>'Create TagInstrument', 'url'=>array('create')),
	array('label'=>'Update TagInstrument', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TagInstrument', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TagInstrument', 'url'=>array('admin')),
);
?>

<h1>View TagInstrument #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'instrument_id',
		'client_id',
		'portfolio_id',
		'tag',
		'limit_min',
		'limit_max',
	),
)); ?>
