<?php
$this->breadcrumbs=['Audit Trails'=>['admin'], 'Manage'];

//$access_buttons = '{view} {update} {delete}';
$access_level = 5;
$access_buttons = '';
if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){$access_level = $user_rols->audit_trails_access_level;}
}

switch ($access_level) {
    case 1:
    $this->menu=[['label'=>'Create AuditTrails', 'url'=>['create']]];
        break;
    case 2:
        $access_buttons = '{update}';
        break;
    case 3:
        $access_buttons = '{delete}';
        break;
    case 4:
        $access_buttons = '{view} {update} {delete}';
        $this->menu=[['label'=>'Create AuditTrails', 'url'=>['create']]];
        break;
} 
/*
$this->menu=[
	['label'=>'List AuditTrails', 'url'=>['index']],
	['label'=>'Create AuditTrails', 'url'=>['create']],
];
*/

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
            'template' => $access_buttons,
		),
	),
)); ?>
