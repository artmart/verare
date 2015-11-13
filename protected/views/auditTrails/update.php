<?php
/* @var $this AuditTrailsController */
/* @var $model AuditTrails */

$this->breadcrumbs=array(
	'Audit Trails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AuditTrails', 'url'=>array('index')),
	array('label'=>'Create AuditTrails', 'url'=>array('create')),
	array('label'=>'View AuditTrails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AuditTrails', 'url'=>array('admin')),
);
?>

<h1>Update AuditTrails <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>