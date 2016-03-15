<?php
$this->breadcrumbs=['Prices'=>['admin'], 'Manage'];

//$access_buttons = '{view} {update} {delete}';
$access_level = 5;
$access_buttons = '';
if(isset(Yii::app()->user->user_role)){
              $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
              if($user_rols){$access_level = $user_rols->prices_access_level;}
}

switch ($access_level) {
    case 1:
    $this->menu=[['label'=>'Create Prices', 'url'=>['create']]];
        break;
    case 2:
        $access_buttons = '{update}';
        break;
    case 3:
        $access_buttons = '{delete}';
        break;
    case 4:
        $access_buttons = '{view} {update} {delete}';
        $this->menu=[['label'=>'Create Prices', 'url'=>['create']]];
        break;
} 


/*'
$this->menu=[
	['label'=>'List Prices', 'url'=>['index']],
	['label'=>'Create Prices', 'url'=>['create']],
];
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#prices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Prices</h1>

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
$this->widget('bootstrap.widgets.TbGridView', array(
//$this->widget('zii.widgets.grid.CGridView', array(
    //'type'=>'striped bordered condensed',

	'id'=>'prices-grid',
    //'id'=>"example1",
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'template' => "{items}\n<div class=\"row-fluid\"><div class=\"span\">{pager}</div><div class=\"span\">{summary}</div></div>",
    'enablePagination' => true,
    
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'columns'=>array(
		'id',
		'trade_date',
		//'instrument_id',
        array(
			'name' => 'instrument_id',
            'header' => 'Instrument',
			'type'=>'raw',
            'value'=>function($data){
				$ss = Instruments::model()->findByAttributes(array("id"=>$data->instrument_id));
                if($ss){return $ss->instrument;} else{return '-';};
            },
			'filter'=>CHtml::listData(Instruments::model()->findAll(),'id', 'instrument'),
            'htmlOptions'=>array('width'=>'150px'),
			),
		//'price',
        array(
			'name' => 'price',
            'header' => 'Price',
			'type'=>'raw',
            'value'=>function($data){
			     return number_format($data->price, 2);
            },
            'htmlOptions'=>array('width'=>'30px'),
			),
		//'is_current',
         array(
			'name' => 'is_current',
            'header' => 'Is Current',
			'type'=>'raw',
            'value'=>function($data){
                if($data->is_current == 1){
                    return 'Yes';
                }else{ return 'No';}
            },
            'filter'=>CHtml::listData([['id'=>'Yes', 'instrument'=>'Yes'], ['id'=>'No', 'instrument'=>'No']],'id', 'instrument'),
            'htmlOptions'=>array('width'=>'20px'),
			),
		'created_at',
		array(
			'class'=>'CButtonColumn',
            'template' => $access_buttons,
		),
	),
)); ?>


