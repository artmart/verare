<?php
/* @var $this PortfolioUserRolesController */
/* @var $model PortfolioUserRoles */

$this->breadcrumbs=array(
	'Portfolio User Roles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PortfolioUserRoles', 'url'=>array('index')),
	array('label'=>'Create PortfolioUserRoles', 'url'=>array('create')),
	array('label'=>'View PortfolioUserRoles', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PortfolioUserRoles', 'url'=>array('admin')),
);
?>

<h1>Update Portfolio User Role <?php //echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>