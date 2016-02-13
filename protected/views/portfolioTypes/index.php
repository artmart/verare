<?php
/* @var $this PortfolioTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Portfolio Types',
);

$this->menu=array(
	array('label'=>'Create PortfolioTypes', 'url'=>array('create')),
	array('label'=>'Manage PortfolioTypes', 'url'=>array('admin')),
);
?>

<h1>Portfolio Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
