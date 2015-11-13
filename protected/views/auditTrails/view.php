<?php
/* @var $this AuditTrailsController */
/* @var $model AuditTrails */

$this->breadcrumbs=array(
	'Audit Trails'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AuditTrails', 'url'=>array('index')),
	array('label'=>'Create AuditTrails', 'url'=>array('create')),
	array('label'=>'Update AuditTrails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AuditTrails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AuditTrails', 'url'=>array('admin')),
);
?>

<h1>View AuditTrails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'table_id',
		'reverse_sql',
		'created_by',
		'created_at',
		'is_current',
	),
)); ?>
