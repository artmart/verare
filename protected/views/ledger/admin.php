<?php
$this->breadcrumbs=['Ledgers'=>['admin'], 'Manage'];

//$access_buttons = '{view} {update} {delete}';
$access_level = 5;
$access_buttons = '';
if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){$access_level = $user_rols->ledger_access_level;}
}

switch ($access_level) {
    case 1:
    $this->menu=[
        	//array('label'=>'List Ledger', 'url'=>array('index')),
        	array('label'=>'Create Ledger', 'url'=>array('create')),
        ];
        break;
    case 2:
        $access_buttons = '{update}';
        break;
    case 3:
        $access_buttons = '{delete}';
        break;
    case 4:
        $access_buttons = '{view} {update} {delete}';
        $this->menu=[
        	//array('label'=>'List Ledger', 'url'=>array('index')),
        	array('label'=>'Create Ledger', 'url'=>array('create')),
        ];
        break;
} 


/*
$this->menu=[
	//array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
];
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ledger-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ledgers</h1>

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

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ledger-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'trade_date',
		'instrument_id',
		'portfolio_id',
		'nominal',
		'price',
		'created_by',
		'created_at',
		'trade_status_id',
       /*
        array(
			'name' => 'trade_status_id',
            //'header' => 'trade_status_id',
			'type'=>'raw',
            //'template'=>'',
            'value'=>function($data){
				if($data->trade_status_id == 2){$access_buttons = '';}
                return $data->trade_status_id;
            },
			//'filter'=>CHtml::listData(Locations::model()->findAll(),'location_code', 'locations_name'),
            //'htmlOptions'=>array('width'=>'150px'),
			),
            */
		'confirmed_by',
		'confirmed_at',
		'version_number',
		'document_id',
		'custody_account',
		'custody_comment',
		'account_number',
		'is_current',
		
		array(
			'class'=>'CButtonColumn',
            'template' => $access_buttons,
            'buttons'=>array(
                            'update'=>['visible'=>'!($data->trade_status_id==2)'],
                            'delete'=>['visible'=>'!($data->trade_status_id==2)'],
                            'view'=>['visible'=>'!($data->trade_status_id==2)'],
                            )  
            //'visible'=>'$data->trade_status_id!==2', 
		),
	),
)); ?>
