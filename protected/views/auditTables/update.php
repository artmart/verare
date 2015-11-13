<?php
/* @var $this AuditTablesController */
/* @var $model AuditTables */

$this->breadcrumbs=array(
	'Audit Tables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AuditTables', 'url'=>array('index')),
	array('label'=>'Create AuditTables', 'url'=>array('create')),
	array('label'=>'View AuditTables', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AuditTables', 'url'=>array('admin')),
);
?>

<h1>Update AuditTables <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>