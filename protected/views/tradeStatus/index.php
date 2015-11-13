<?php
/* @var $this TradeStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Trade Statuses',
);

$this->menu=array(
	array('label'=>'Create TradeStatus', 'url'=>array('create')),
	array('label'=>'Manage TradeStatus', 'url'=>array('admin')),
);
?>

<h1>Trade Statuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
