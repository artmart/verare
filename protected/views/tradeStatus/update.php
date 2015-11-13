<?php
/* @var $this TradeStatusController */
/* @var $model TradeStatus */

$this->breadcrumbs=array(
	'Trade Statuses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TradeStatus', 'url'=>array('index')),
	array('label'=>'Create TradeStatus', 'url'=>array('create')),
	array('label'=>'View TradeStatus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TradeStatus', 'url'=>array('admin')),
);
?>

<h1>Update TradeStatus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>