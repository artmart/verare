<?php
/* @var $this AccessLevelsController */
/* @var $data AccessLevels */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_level')); ?>:</b>
	<?php echo CHtml::encode($data->access_level); ?>
	<br />


</div>