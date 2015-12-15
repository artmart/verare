<?php
/* @var $this PortfolioReturnsController */
/* @var $data PortfolioReturns */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portfolio_id')); ?>:</b>
	<?php echo CHtml::encode($data->portfolio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_prtfolio_or_group')); ?>:</b>
	<?php echo CHtml::encode($data->is_prtfolio_or_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trade_date')); ?>:</b>
	<?php echo CHtml::encode($data->trade_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return')); ?>:</b>
	<?php echo CHtml::encode($data->return); ?>
	<br />


</div>