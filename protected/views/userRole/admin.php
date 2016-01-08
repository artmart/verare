<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>
<?php
$this->breadcrumbs=['User Roles'=>['admin'], 'Manage'];

$this->menu=array(
//	array('label'=>'List UserRole', 'url'=>array('index')),
	array('label'=>'Create UserRole', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-role-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Roles</h1>

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
	'id'=>'user-role-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'trade_role',
		'user_role',
		//'trade_creation',
		//'trade_confirmation',
		//'trade_cancellation',
		//'price_administration',
		//'instrument_administration',
		//'ledger_access_level',        
        array(
			'name' => 'ledger_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->ledger_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'users_access_level',
         array(
			'name' => 'users_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->users_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'user_roles_access_level',
        array(
			'name' => 'user_roles_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->user_roles_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'portfolios_access_level',
        array(
			'name' => 'portfolios_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->portfolios_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'instruments_access_level',
        array(
			'name' => 'instruments_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->instruments_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'counterparties_access_level',
        array(
			'name' => 'counterparties_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->counterparties_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'documents_access_level',
        array(
			'name' => 'documents_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->documents_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'prices_access_level',
        array(
			'name' => 'prices_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->prices_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'audit_trails_access_level',
        array(
			'name' => 'audit_trails_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->audit_trails_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		//'grouping_access_level',
        array(
			'name' => 'grouping_access_level',
            //'header' => 'Customer',
			'type'=>'raw',
            'value'=>function($data){
				$ss = AccessLevels::model()->findByAttributes(array("id"=>$data->grouping_access_level));
                if($ss){return $ss->access_level;} else{return '-';};
            },
			'filter'=>CHtml::listData(AccessLevels::model()->findAll(),'id', 'access_level'),
            //'htmlOptions'=>array('width'=>'170px'),
			),
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
