<?php
/* @var $this PortfoliosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Portfolioses',
);

$this->menu=array(
	array('label'=>'Create Portfolios', 'url'=>array('create')),
	array('label'=>'Manage Portfolios', 'url'=>array('admin')),
);
?>

<h1>Portfolioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
