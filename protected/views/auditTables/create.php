<?php
/* @var $this AuditTablesController */
/* @var $model AuditTables */

$this->breadcrumbs=array(
	'Audit Tables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AuditTables', 'url'=>array('index')),
	array('label'=>'Manage AuditTables', 'url'=>array('admin')),
);
?>

<h1>Create AuditTables</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>