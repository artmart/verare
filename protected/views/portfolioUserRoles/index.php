<?php
/* @var $this PortfolioUserRolesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Portfolio User Roles',
);

$this->menu=array(
	array('label'=>'Create PortfolioUserRoles', 'url'=>array('create')),
	array('label'=>'Manage PortfolioUserRoles', 'url'=>array('admin')),
);
?>

<h1>Portfolio User Roles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
