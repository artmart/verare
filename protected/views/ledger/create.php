<?php
/* @var $this LedgerController */
/* @var $model Ledger */

$this->breadcrumbs=array(
	'Ledgers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Manage Ledger', 'url'=>array('admin')),
);
?>

<h1>Create Ledger</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>