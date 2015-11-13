<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */

$this->breadcrumbs=array(
	'Instruments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Instruments', 'url'=>array('index')),
	array('label'=>'Create Instruments', 'url'=>array('create')),
	array('label'=>'View Instruments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Instruments', 'url'=>array('admin')),
);
?>

<h1>Update Instruments <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>