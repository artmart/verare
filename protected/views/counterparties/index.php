<?php
/* @var $this CounterpartiesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Counterparties',
);

$this->menu=array(
	array('label'=>'Create Counterparties', 'url'=>array('create')),
	array('label'=>'Manage Counterparties', 'url'=>array('admin')),
);
?>

<h1>Counterparties</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
