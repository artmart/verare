<?php
/* @var $this PortfolioReturnsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Portfolio Returns',
);

$this->menu=array(
	array('label'=>'Create PortfolioReturns', 'url'=>array('create')),
	array('label'=>'Manage PortfolioReturns', 'url'=>array('admin')),
);
?>

<h1>Portfolio Returns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
