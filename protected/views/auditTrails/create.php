<?php
/* @var $this AuditTrailsController */
/* @var $model AuditTrails */

$this->breadcrumbs=array(
	'Audit Trails'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AuditTrails', 'url'=>array('index')),
	array('label'=>'Manage AuditTrails', 'url'=>array('admin')),
);
?>

<h1>Create AuditTrails</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>