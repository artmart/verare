<?php
/* @var $this LedgerController */
/* @var $model Ledger */

$this->breadcrumbs=array(
	'Ledgers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
	array('label'=>'Update Ledger', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ledger', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ledger', 'url'=>array('admin')),
);
?>

<h1>View Ledger #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'trade_date',
		'instrument_id',
		'portfolio_id',
		'nominal',
		'price',
		'created_by',
		'created_at',
		'trade_status_id',
		'confirmed_by',
		'confirmed_at',
		'version_number',
		'document_id',
		'custody_account',
		'custody_comment',
		'account_number',
		'is_current',
	),
)); ?>
