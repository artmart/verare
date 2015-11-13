<?php
/* @var $this TradeStatusController */
/* @var $model TradeStatus */

$this->breadcrumbs=array(
	'Trade Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TradeStatus', 'url'=>array('index')),
	array('label'=>'Manage TradeStatus', 'url'=>array('admin')),
);
?>

<h1>Create TradeStatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>