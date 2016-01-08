<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h3>
</br>
<h3><?php  echo CHtml::link('Admin menu',array('/site/admin')); ?></h4>

</br>
<?php  echo CHtml::link('Users',array('/user/admin')); ?>
</br>
<?php  echo CHtml::link('User Roles',array('userRole/admin')); ?>
</br>
<?php  echo CHtml::link('Trade Statuses',array('/tradeStatus/admin')); ?>
</br>
<?php  echo CHtml::link('Prices',array('/prices/admin')); ?>
</br>
<?php  echo CHtml::link('Portfolio UserS with Roles',array('/portfolioUserRoles/admin')); ?>
</br>
<?php  echo CHtml::link('Portfolios',array('/portfolios/admin')); ?>
</br>
<?php  echo CHtml::link('Ledger',array('/ledger/admin')); ?>
</br>
<?php  echo CHtml::link('Trade Statuses',array('/tradeStatus/admin')); ?>
</br>
<?php  echo CHtml::link('Instrument Types',array('/instrumentTypes/admin')); ?>
</br>
<?php  echo CHtml::link('Instruments',array('/instruments/admin')); ?>
</br>
<?php  echo CHtml::link('Group Item',array('/groupItem/admin')); ?>
</br>
<?php  echo CHtml::link('Group Benchmark',array('/groupBenchmark/admin')); ?>
</br>
<?php  echo CHtml::link('Grouping',array('/grouping/admin')); ?>
</br>
<?php  echo CHtml::link('Document Types',array('/documentTypes/admin')); ?>
</br>
<?php  echo CHtml::link('Document Locations',array('/documentLocations/admin')); ?>
</br>
<?php  echo CHtml::link('Documents',array('/documents/admin')); ?>
</br>
<?php  echo CHtml::link('Clients',array('/clients/admin')); ?>
</br>
<?php  echo CHtml::link('Audit Trails',array('/auditTrails/admin')); ?>
</br>
<?php  echo CHtml::link('Audit Tables',array('/auditTables/admin')); ?>
</br>
<?php  echo CHtml::link('Upload pricies',array('/uploads/create')); ?>
</br>
<?php  echo CHtml::link('Return',array('/prices/return')); ?>
</br>
<?php  echo CHtml::link('Returns',array('/returns/admin')); ?> 
</br>
<?php  
echo CHtml::link('Return Calculation',array('/prices/allReturns')); 
//echo CHtml::link('Return Calculation',array('/prices/ReturnCalculation')); ?> 
</br>
<?php  echo CHtml::link('Portfolio Returns',array('/portfolioReturns/admin')); ?> 
</br>
<?php  echo CHtml::link('All Stats',array('/prices/allStats')); ?> 
</br>
<?php  echo CHtml::link('Access Levels',array('/accessLevels/admin')); ?> 





