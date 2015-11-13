<?php
/* @var $this PortfolioUserRolesController */
/* @var $model PortfolioUserRoles */

$this->breadcrumbs=array(
	'Portfolio User Roles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PortfolioUserRoles', 'url'=>array('index')),
	array('label'=>'Create PortfolioUserRoles', 'url'=>array('create')),
	array('label'=>'Update PortfolioUserRoles', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PortfolioUserRoles', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PortfolioUserRoles', 'url'=>array('admin')),
);
?>

<h1>View PortfolioUserRoles #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'portfolio_id',
		'user_id',
		'role_id',
		'created_by',
		'is_current',
		'created_at',
	),
)); ?>
