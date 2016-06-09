<?php
/* @var $this CashFlowsController */
/* @var $model CashFlows */

$this->breadcrumbs=array(
	'Cash Flows'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CashFlows', 'url'=>array('index')),
	array('label'=>'Create CashFlows', 'url'=>array('create')),
	array('label'=>'View CashFlows', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashFlows', 'url'=>array('admin')),
);
?>

<h1>Update CashFlows <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>