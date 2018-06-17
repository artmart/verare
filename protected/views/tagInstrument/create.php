<?php
/* @var $this TagInstrumentController */
/* @var $model TagInstrument */

$this->breadcrumbs=array(
	'Tag Instruments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TagInstrument', 'url'=>array('index')),
	array('label'=>'Manage TagInstrument', 'url'=>array('admin')),
);
?>

<h1>Create TagInstrument</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>