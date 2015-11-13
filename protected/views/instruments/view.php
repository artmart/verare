<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */

$this->breadcrumbs=array(
	'Instruments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Instruments', 'url'=>array('index')),
	array('label'=>'Create Instruments', 'url'=>array('create')),
	array('label'=>'Update Instruments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Instruments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Instruments', 'url'=>array('admin')),
);
?>

<h1>View Instruments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'instrument',
		'instrument_type_id',
		'fpml',
		'is_current',
		'created_at',
	),
)); ?>
