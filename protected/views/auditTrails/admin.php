<?php
/* @var $this AuditTrailsController */
/* @var $model AuditTrails */

$this->breadcrumbs=array(
	'Audit Trails'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AuditTrails', 'url'=>array('index')),
	array('label'=>'Create AuditTrails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#audit-trails-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Audit Trails</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-trails-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'table_id',
		'reverse_sql',
		'created_by',
		'created_at',
		'is_current',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
