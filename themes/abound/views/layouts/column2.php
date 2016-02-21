<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

  <div class="row-fluid">
	<div class="span2">
		<div class="sidebar-nav">
        
<?php
$usermenu=[];

$access_level = 5;
if(isset(Yii::app()->user->user_role)){
          $user_rols = UserRole::model()->findByPk(Yii::app()->user->user_role);
          if($user_rols)
          {              
              $ledger_access_level = $user_rols->ledger_access_level;
              $users_access_level = $user_rols->users_access_level;
              $user_roles_access_level = $user_rols->user_roles_access_level;
              $portfolios_access_level = $user_rols->portfolios_access_level;
              $instruments_access_level = $user_rols->instruments_access_level;
              $counterparties_access_level = $user_rols->counterparties_access_level;//???????
              $documents_access_level = $user_rols->documents_access_level;
              $prices_access_level = $user_rols->prices_access_level;
              $audit_trails_access_level = $user_rols->audit_trails_access_level;
              $grouping_access_level = $user_rols->grouping_access_level;
              
              if($ledger_access_level !== 5){$usermenu[]=['label'=>'Ledger', 'url'=>['/ledger/admin']];}
              if($users_access_level !== 5){$usermenu[]=['label'=>'Users', 'url'=>['/user/admin']];}
              if($user_roles_access_level !== 5){$usermenu[]=['label'=>'User Roles', 'url'=>['userRole/admin']];}
              if($portfolios_access_level !== 5){$usermenu[]=['label'=>'Portfolios', 'url'=>['/portfolios/admin']];}
              if($instruments_access_level !== 5){$usermenu[]=['label'=>'Instruments', 'url'=>['/instruments/admin']];}
              if($counterparties_access_level !== 5){$usermenu[]=['label'=>'Counterparties', 'url'=>['/counterparties/admin']];}
              if($documents_access_level !== 5){$usermenu[]=['label'=>'Documents', 'url'=>['/documents/admin']];}
              if($prices_access_level !== 5){$usermenu[]=['label'=>'Prices', 'url'=>['/prices/admin']];}
              if($audit_trails_access_level !== 5){$usermenu[]=['label'=>'Audit Trails', 'url'=>['/auditTrails/admin']];}
              if($grouping_access_level !== 5){$usermenu[]=['label'=>'Grouping', 'url'=>['/grouping/admin']];}
             
              //Admin Menu//
              if(Yii::app()->getModule('user')->isAdmin())
              {
                $usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Portfolio UserS with Roles', 'url'=>['/portfolioUserRoles/admin']];
                $usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Instrument Types', 'url'=>['/instrumentTypes/admin']];
                $usermenu[]=['label'=>'Group Item', 'url'=>['/groupItem/admin']];                
                $usermenu[]=['label'=>'Group Benchmark', 'url'=>['/groupBenchmark/admin']];
                $usermenu[]=['label'=>'Document Types', 'url'=>['/documentTypes/admin']];
                $usermenu[]=['label'=>'Document Locations', 'url'=>['/documentLocations/admin']];
                $usermenu[]=['label'=>'Clients', 'url'=>['/clients/admin']];
                $usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];
                $usermenu[]=['label'=>'Upload pricies', 'url'=>['/uploads/create']];
                $usermenu[]=['label'=>'Return', 'url'=>['/prices/return']];
                $usermenu[]=['label'=>'Returns', 'url'=>['/returns/admin']];
                $usermenu[]=['label'=>'Return Calculation', 'url'=>['/prices/allReturns']];
                $usermenu[]=['label'=>'Portfolio Returns', 'url'=>['/portfolioReturns/admin']];
                $usermenu[]=['label'=>'All Stats', 'url'=>['/prices/allStats']];                            
                $usermenu[]=['label'=>'Access Levels', 'url'=>['/accessLevels/admin']]; 
                $usermenu[]=['label'=>'Portfolio Types', 'url'=>['/portfolioTypes/admin']];
                $usermenu[]=['label'=>'Benchmarks', 'url'=>['/benchmarks/admin']];
                $usermenu[]=['label'=>'Benchmark Components', 'url'=>['/benchmarkComponents/admin']];             
              }
              
           }
}              
          $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(
				array('label'=>'<i class="icon icon-home"></i>  Dashboard <span class="label label-info pull-right">BETA</span>', 'url'=>array('/site/index'),'itemOptions'=>array('class'=>'')),
				array('label'=>'<i class="icon icon-search"></i> About this theme <span class="label label-important pull-right">HOT</span>', 'url'=>'http://www.webapplicationthemes.com/abound-yii-framework-theme/'),
				array('label'=>'<i class="icon icon-envelope"></i> Messages <span class="badge badge-success pull-right">12</span>', 'url'=>'#'),
				// Include the operations menu
				array('label'=>'OPERATIONS','items'=>$this->menu),
                array('label'=>'ACCESSABLE ACTIONS','items'=>$usermenu),                
			),
			));?>
		</div> 
        <br />   
<?php
/*        
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
<?php  echo CHtml::link('Return Calculation',array('/prices/allReturns')); 

//echo CHtml::link('Return Calculation',array('/prices/ReturnCalculation')); ?> 
</br>
<?php  echo CHtml::link('Portfolio Returns',array('/portfolioReturns/admin')); ?> 
</br>
<?php  echo CHtml::link('All Stats',array('/prices/allStats')); ?> 
</br>
<?php  echo CHtml::link('Access Levels',array('/accessLevels/admin')); ?> 
 
 */
 ?>
    
        
        
  <!--     
        <br /><br/>
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td width="50%">Bandwith Usage</td>
              <td>
              	<div class="progress progress-danger">
                  <div class="bar" style="width: 80%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Disk Spage</td>
              <td>
             	<div class="progress progress-warning">
                  <div class="bar" style="width: 60%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Conversion Rate</td>
              <td>
             	<div class="progress progress-success">
                  <div class="bar" style="width: 40%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Closed Sales</td>
              <td>
              	<div class="progress progress-info">
                  <div class="bar" style="width: 20%"></div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
		<div class="well">
        
            <dl class="dl-horizontal">
              <dt>Account status</dt>
              <dd>$1,234,002</dd>
              <dt>Open Invoices</dt>
              <dd>$245,000</dd>
              <dt>Overdue Invoices</dt>
              <dd>$20,023</dd>
              <dt>Converted Quotes</dt>
              <dd>$560,000</dd>
              
            </dl>
      </div>
-->		
    </div><!--/span-->
    <div class="span10">
    
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Dashboard'),
			'htmlOptions'=>array('class'=>'breadcrumb')
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    
    <!-- Include content pages -->
    <?php echo $content; ?>

	</div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>