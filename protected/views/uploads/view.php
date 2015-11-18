<?php
/* @var $this UploadsController */
/* @var $model Uploads */

$this->breadcrumbs=array(
	'Uploads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Uploads', 'url'=>array('index')),
	array('label'=>'Create Uploads', 'url'=>array('create')),
	//array('label'=>'Update Uploads', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Uploads', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Uploads', 'url'=>array('admin')),
);
?>

<h1>View Uploads #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'user_id',
		'upload_date',
		'upload_file',
		'instrument_id',
		'upload_description',
	),
)); ?>
