<?php
/* @var $this PortfolioUserRolesController */
/* @var $model PortfolioUserRoles */

$this->breadcrumbs=array(
	'Portfolio User Roles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PortfolioUserRoles', 'url'=>array('index')),
	array('label'=>'Manage PortfolioUserRoles', 'url'=>array('admin')),
);
?>

<h1>Create PortfolioUserRoles</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>