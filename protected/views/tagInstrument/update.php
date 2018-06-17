<?php
/* @var $this TagInstrumentController */
/* @var $model TagInstrument */

$this->breadcrumbs=array(
	'Tag Instruments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TagInstrument', 'url'=>array('index')),
	array('label'=>'Create TagInstrument', 'url'=>array('create')),
	array('label'=>'View TagInstrument', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TagInstrument', 'url'=>array('admin')),
);
?>

<h1>Update TagInstrument <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>