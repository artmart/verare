<?php
/* @var $this CashFlowTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Flow Types',
);

$this->menu=array(
	array('label'=>'Create CashFlowTypes', 'url'=>array('create')),
	array('label'=>'Manage CashFlowTypes', 'url'=>array('admin')),
);
?>

<h1>Cash Flow Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
