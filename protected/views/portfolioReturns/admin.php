<?php $this->breadcrumbs=array('Portfolio Returns'=>array('index'),	'Manage',);?>

<style>
.grid-view table.items th{
    	background-size: 100% 100%;
    }
</style>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-info span5"><div class="flash-' . $key . '">' . $message . "</div></div>\n";
    }
?>

<div class="span1"></div>
<div class="span11">
    <h2>Time-weighted return calculation for selected portfolio</h2>
</div>

<div class="row-fluid"></div>
<div class="span1"></div>
<div class="span12">

<?php 
    $baseurl = Yii::app()->baseUrl;
    $portfolio_id = '';
    $dt = '';
    $where = ' 1 = 1 ';
    
    if(isset($_REQUEST['portfolio']) && !($_REQUEST['portfolio'] == '')){$portfolio_id = $_REQUEST['portfolio'];}

        
    if(isset($_REQUEST['dt']) && !($_REQUEST['dt'] == '')){$dt = $_REQUEST['dt']; $where .= " and p.trade_date >='$dt' "; }

    
    echo CHtml::beginForm('portfolioReturns','post'); 
?>







<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
    <?php
        echo CHtml::dropDownList('portfolio', $portfolio_id,  CHtml::listData(Portfolios::model()->findAll(array('select'=>'id, portfolio', 'order'=>'portfolio')),'id','portfolio'), array('empty' => '-- Select Portfolio --', 'class' => 'form-control input-md'  /*'onchange'=>'loaddata()', 'multiple' => true, 'size'=>'10'*/ ));
    ?>
</div>
</div>

<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
<?php

$this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'name'=>'dt',
        //'language'=>'nl',
        //'attribute'=>'SaleDate',
        //'model'=>$model,
        // additional javascript options for the date picker plugin
        'options'=>array(
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
            //'onselect'=>'loaddata()'
        ),
        'htmlOptions'=>array('class' => 'form-control input-md',  'placeholder'=>'YYYY-MM-DD', ),
    ));

?>
</div>
</div>


<div class="row form-group">
  <label class="col-md-3 control-label"></label>  
  <div class="col-md-4">
<?php echo CHtml::submitButton('Calculate Return', array('submit' => $baseurl.'/portfolioReturns/PortfolioReturnsCalc', 'class'=>"btn btn-primary"));?>
</div>
</div>
<br />
<?php echo CHtml::endForm(); ?>

</div>

<?php
$this->menu=array(
	array('label'=>'List PortfolioReturns', 'url'=>array('index')),
	array('label'=>'Create PortfolioReturns', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#portfolio-returns-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row-fluid"></div>
<h1>Manage Portfolio Returns</h1>

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
	'id'=>'portfolio-returns-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'portfolio_id',
		'is_prtfolio_or_group',
		'trade_date',
		'return',
        'benchmark_return',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
