<?php
/* @var $this CashFlowsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Flows',
);

$this->menu=array(
	array('label'=>'Create CashFlows', 'url'=>array('create')),
	array('label'=>'Manage CashFlows', 'url'=>array('admin')),
);
?>

<h1>Cash Flows</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
