<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h3>
<!--
<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php // echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php // echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>
-->
</br>
</br>

<table class='table borderless'>
<tr>
	<td><?php  echo CHtml::link('Տվյալների դիտում',array('/site/baseline')); ?></td>
	<td><?php  echo CHtml::link('Ստեղծել նոր սցենար',array('/site/newscenario')); ?></td>
	<td><?php  echo CHtml::link('Բազային և այլ առկա սցենարներ',array('/site/basescenario')); ?></td>
    <td><?php  echo CHtml::link('Օգտագործման ցուցումներ',array('../downloads/help.pdf'), array("target"=>"_blank")); ?></td>
</tr>
<td></td>
<td></td>
<td></td>
<td></td>
</table>
<?php // echo CHtml::link('Օգտագործման ցուցումներ',array('../downloads/help.pdf'), array("target"=>"_blank")); ?>

<?php

if(Yii::app()->user->isAdmin())
            {
 ?>  
<h3>Ադմինիստրատիվ կառավարման վահանակ</h4>             
</br>
<?php  echo CHtml::link('Տնտեսական տվյալներ',array('/economy/admin')); ?>

</br>
<?php  echo CHtml::link('Շրջակա միջավայր',array('/emissions/admin')); ?>

</br>
<?php  echo CHtml::link('Ոլորտներ',array('/industries')); ?>
</br>
<?php  echo CHtml::link('Ճյուղեր',array('/subIndustries')); ?>
</br>
<?php  echo CHtml::link('Ենթաճյուղեր',array('/subBranches')); ?>
</br>

<?php  echo CHtml::link('Ցուցանիշներ',array('/data')); ?>
</br>
<?php  echo CHtml::link('Չափման միավորները',array('/measureUnits')); ?>

</br>
<?php  echo CHtml::link('Update Economy for 2013-2024',array('/economy/ab')); ?>
</br>
<?php  echo CHtml::link('Update population for 2015 - 2024',array('/population/ab')); ?>

</br>
<?php  echo CHtml::link('Update emissions for 2013 - 2024',array('/emissions/ab')); ?>
 
 
 
                    
<?php            }
?>