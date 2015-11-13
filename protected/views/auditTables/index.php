<?php
/* @var $this AuditTablesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Audit Tables',
);

$this->menu=array(
	array('label'=>'Create AuditTables', 'url'=>array('create')),
	array('label'=>'Manage AuditTables', 'url'=>array('admin')),
);
?>

<h1>Audit Tables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
