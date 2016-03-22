<?php  $baseUrl1 = Yii::app()->baseUrl; 

$usermenu=[];
$usermenu1 = [];
$user_role_id = Yii::app()->user->getState('user_role');


switch ($user_role_id) {
    case 1:
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/ledger/admin">Ledger</a>
                            <a href="'.$baseUrl1.'/documents/admin">Documents</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/instruments/admin">Instruments</a>
                            <a href="'.$baseUrl1.'/prices/admin">Prices</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/portfolios/admin">Portfolios</a>
                            <a href="'.$baseUrl1.'/grouping/admin">Grouping</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/counterparties/admin">Counterparties</a>  
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/users/admin">Users</a>
                            <a href="'.$baseUrl1.'/userRole/admin">User Roles</a>
                            </li><li class="divider"></li>';
    
    
                $usermenu[]=['label'=>'Portfolio UserS with Roles', 'url'=>['/portfolioUserRoles/admin']];
                $usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Instrument Types', 'url'=>['/instrumentTypes/admin']];
                $usermenu[]=['label'=>'Benchmarks', 'url'=>['/benchmarks/admin']];
                $usermenu[]=['label'=>'Benchmark Components', 'url'=>['/benchmarkComponents/admin']]; 
                $usermenu[]=['label'=>'Group Item', 'url'=>['/groupItem/admin']];                
                $usermenu[]=['label'=>'Group Benchmark', 'url'=>['/groupBenchmark/admin']];
                $usermenu[]=['label'=>'Document Types', 'url'=>['/documentTypes/admin']];
                $usermenu[]=['label'=>'Document Locations', 'url'=>['/documentLocations/admin']];
                $usermenu[]=['label'=>'Clients', 'url'=>['/clients/admin']];
                $usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];
                $usermenu[]=['label'=>'Upload pricies', 'url'=>['/uploads/create']];
                $usermenu[]=['label'=>'New Upload pricies', 'url'=>['/uploads/fullupload']];
                $usermenu[]=['label'=>'Return', 'url'=>['/prices/return']];
                $usermenu[]=['label'=>'Returns', 'url'=>['/returns/admin']];
                $usermenu[]=['label'=>'Return Calculation', 'url'=>['/prices/allReturns']];
                $usermenu[]=['label'=>'Portfolio Returns', 'url'=>['/portfolioReturns/admin']];
                $usermenu[]=['label'=>'All Stats', 'url'=>['/prices/allStats']];                             
                $usermenu[]=['label'=>'Portfolio Types', 'url'=>['/portfolioTypes/admin']];
                $usermenu[]=['label'=>'Access Levels', 'url'=>['/accessLevels/admin']];
                
        break;
    case 2:
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/ledger/admin">Ledger</a>
                            <a href="'.$baseUrl1.'/documents/admin">Documents</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/instruments/admin">Instruments</a>
                            <a href="'.$baseUrl1.'/prices/admin">Prices</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/portfolios/admin">Portfolios</a>
                            <a href="'.$baseUrl1.'/grouping/admin">Grouping</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/counterparties/admin">Counterparties</a>  
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/users/admin">Users</a>
                            
                            </li><li class="divider"></li>';
    //<a href="'.$baseUrl1.'/userRole/admin">User Roles</a>
                $usermenu[]=['label'=>'Portfolio UserS with Roles', 'url'=>['/portfolioUserRoles/admin']];
                $usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Instrument Types', 'url'=>['/instrumentTypes/admin']];
                $usermenu[]=['label'=>'Benchmarks', 'url'=>['/benchmarks/admin']];
                $usermenu[]=['label'=>'Benchmark Components', 'url'=>['/benchmarkComponents/admin']]; 
                $usermenu[]=['label'=>'Group Item', 'url'=>['/groupItem/admin']];                
                $usermenu[]=['label'=>'Group Benchmark', 'url'=>['/groupBenchmark/admin']];
                $usermenu[]=['label'=>'Document Types', 'url'=>['/documentTypes/admin']];
                $usermenu[]=['label'=>'Document Locations', 'url'=>['/documentLocations/admin']];
                $usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];
                $usermenu[]=['label'=>'Upload pricies', 'url'=>['/uploads/create']];
                $usermenu[]=['label'=>'New Upload pricies', 'url'=>['/uploads/fullupload']];
                $usermenu[]=['label'=>'Return', 'url'=>['/prices/return']];
                $usermenu[]=['label'=>'Returns', 'url'=>['/returns/admin']];
                $usermenu[]=['label'=>'Return Calculation', 'url'=>['/prices/allReturns']];
                $usermenu[]=['label'=>'Portfolio Returns', 'url'=>['/portfolioReturns/admin']];
                $usermenu[]=['label'=>'All Stats', 'url'=>['/prices/allStats']];                             
                $usermenu[]=['label'=>'Portfolio Types', 'url'=>['/portfolioTypes/admin']];
                $usermenu[]=['label'=>'Access Levels', 'url'=>['/accessLevels/admin']];
                
        break;
    case 3:
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/ledger/admin">Ledger</a>
                            <a href="'.$baseUrl1.'/documents/admin">Documents</a>
                            </li><li class="divider"></li>';
        break;
    case 4:
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/ledger/admin">Ledger</a>
                            <a href="'.$baseUrl1.'/documents/admin">Documents</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/instruments/admin">Instruments</a>
                            <a href="'.$baseUrl1.'/prices/admin">Prices</a>
                            </li><li class="divider"></li>';
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/portfolios/admin">Portfolios</a>
                            <a href="'.$baseUrl1.'/counterparties/admin">Counterparties</a> 
                            </li><li class="divider"></li>';
                //$usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];                        
        break;
    default:
                $usermenu1[]= '<li>
                            <a href="'.$baseUrl1.'/ledger/admin">Ledger</a>
                            <a href="'.$baseUrl1.'/documents/admin">Documents</a>
                            </li><li class="divider"></li>';
                //$usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];
                
} 


/*
//$access_level = 5;
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
              
              //if($ledger_access_level !== 5){$usermenu[]=['label'=>'Ledger', 'url'=>['/ledger/admin']];}
              //if($users_access_level !== 5){$usermenu[]=['label'=>'Users', 'url'=>['/user/admin']];}
              //if($user_roles_access_level !== 5){$usermenu[]=['label'=>'User Roles', 'url'=>['userRole/admin']];}
              //if($portfolios_access_level !== 5){$usermenu[]=['label'=>'Portfolios', 'url'=>['/portfolios/admin']];}
              //if($instruments_access_level !== 5){$usermenu[]=['label'=>'Instruments', 'url'=>['/instruments/admin']];}
              //if($counterparties_access_level !== 5){$usermenu[]=['label'=>'Counterparties', 'url'=>['/counterparties/admin']];}
              //if($documents_access_level !== 5){$usermenu[]=['label'=>'Documents', 'url'=>['/documents/admin']];}
              //if($prices_access_level !== 5){$usermenu[]=['label'=>'Prices', 'url'=>['/prices/admin']];}
              if($audit_trails_access_level !== 5){$usermenu[]=['label'=>'Audit Trails', 'url'=>['/auditTrails/admin']];}
              //if($grouping_access_level !== 5){$usermenu[]=['label'=>'Grouping', 'url'=>['/grouping/admin']];}
             
              //Admin Menu//
              if(Yii::app()->getModule('user')->isAdmin())
              {
                //$usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Portfolio UserS with Roles', 'url'=>['/portfolioUserRoles/admin']];
                $usermenu[]=['label'=>'Trade Statuses', 'url'=>['/tradeStatus/admin']];
                $usermenu[]=['label'=>'Instrument Types', 'url'=>['/instrumentTypes/admin']];
                $usermenu[]=['label'=>'Benchmarks', 'url'=>['/benchmarks/admin']];
                $usermenu[]=['label'=>'Benchmark Components', 'url'=>['/benchmarkComponents/admin']]; 
                $usermenu[]=['label'=>'Group Item', 'url'=>['/groupItem/admin']];                
                $usermenu[]=['label'=>'Group Benchmark', 'url'=>['/groupBenchmark/admin']];
                $usermenu[]=['label'=>'Document Types', 'url'=>['/documentTypes/admin']];
                $usermenu[]=['label'=>'Document Locations', 'url'=>['/documentLocations/admin']];
                $usermenu[]=['label'=>'Clients', 'url'=>['/clients/admin']];
                $usermenu[]=['label'=>'Audit Tables', 'url'=>['/auditTables/admin']];
                $usermenu[]=['label'=>'Upload pricies', 'url'=>['/uploads/create']];
                $usermenu[]=['label'=>'New Upload pricies', 'url'=>['/uploads/fullupload']];
                $usermenu[]=['label'=>'Return', 'url'=>['/prices/return']];
                $usermenu[]=['label'=>'Returns', 'url'=>['/returns/admin']];
                $usermenu[]=['label'=>'Return Calculation', 'url'=>['/prices/allReturns']];
                $usermenu[]=['label'=>'Portfolio Returns', 'url'=>['/portfolioReturns/admin']];
                $usermenu[]=['label'=>'All Stats', 'url'=>['/prices/allStats']];                            
                $usermenu[]=['label'=>'Access Levels', 'url'=>['/accessLevels/admin']]; 
                $usermenu[]=['label'=>'Portfolio Types', 'url'=>['/portfolioTypes/admin']];
                 
                
                           
              }
              
           }
}  

*/

?>
<style>
.navbar-default {
    position: absolute;
}
</style>
<!-- start navigation -->
		<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<!--<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">-->
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">Verare</a>
				</div>
                <div class="span4"></div>
				<div class="collapse navbar-collapse span8" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right text-uppercase">
						<li><a href="<?php echo $baseUrl1;?>/site/index">Home</a></li>
						<li><a href="<?php echo $baseUrl1;?>/site/admin">Dashboard</a></li>
                        <?php /*
                        <?php if(Yii::app()->user->isGuest){?>
                        <li><a class="login-hide" href="<?php echo $baseUrl1;?>/site/login">Login</a></li>
                        <?php }else{ ?>
                        <li><a href="<?php echo $baseUrl1;?>/site/logout">Logout (<?php echo Yii::app()->user->name; ?>)</a></li>
                        <?php } ?>
                        */
                        ?>




                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">ADMIN<b class="caret"></b></a>
                          <ul class="dropdown-menu">
                          <?php   
                                  foreach($usermenu1 as $item1){echo $item1;}
                                  foreach($usermenu as $item){
                                    echo '<li>
                                         <a href="'.$baseUrl1."/".$item['url'][0].'">'.$item['label'].'</a>
                                         </li>';
                                  }
                          ?>
                          <li class="divider"></li>
                          </ul>
                        </li>
                        

                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">USER<b class="caret"></b></a>
                          <ul class="dropdown-menu">
                          <li>
                            <a href="<?php echo $baseUrl1; ?>/users/settings">Settings</a>
                          </li>
                          <li class="divider"></li>
                          <?php if(Yii::app()->user->isGuest){?>
                            <li><a class="login-hide" href="<?php echo $baseUrl1;?>/site/login">Login</a></li>
                            <?php }else{ ?>
                            <li><a href="<?php echo $baseUrl1;?>/site/logout">Logout (<?php echo Yii::app()->user->name; ?>)</a></li>
                          <?php } ?>
                          </ul>
                        </li>
                        <!--<li><a onclick="redirecttologin()" href="<?php //echo $baseUrl1;?>/user/login">Login</a></li>-->
					</ul>
                </div>
</div>
</nav>
<!-- end navigation -->




