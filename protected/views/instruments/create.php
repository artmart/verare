<?php
/* @var $this InstrumentsController */
/* @var $model Instruments */

$this->breadcrumbs=array(
	'Instruments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Instruments', 'url'=>array('index')),
	array('label'=>'Manage Instruments', 'url'=>array('admin')),
);
?>

<h1>Create Instruments</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>