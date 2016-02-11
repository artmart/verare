<?php  $baseUrl1 = Yii::app()->baseUrl; ?>

<!-- start navigation -->
		<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">Verare</a>
				</div>
				<div class="collapse navbar-collapse span8">
					<ul class="nav navbar-nav navbar-right text-uppercase">
						<li><a href="<?php echo $baseUrl1;?>/site/index">Home</a></li>
						<li><a href="<?php echo $baseUrl1;?>/site/admin">Dashboard</a></li>
                        <?php if(Yii::app()->user->isGuest){?>
                        <li><a class="login-hide" href="<?php echo $baseUrl1;?>/site/login">Login</a></li>
                        <?php }else{ ?>
                        <li><a href="<?php echo $baseUrl1;?>/site/logout">Logout (<?php echo Yii::app()->user->name; ?>)</a></li>
                        <?php } ?>
		
                        <!--<li><a onclick="redirecttologin()" href="<?php //echo $baseUrl1;?>/user/login">Login</a></li>-->
					</ul>
                </div>
				
   <div class="dropdown span2">
            <a id="dLabel"  data-toggle="dropdown" class="btn" data-target="#" href="#">ADMIN <span class="caret"></span>
            </a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li>
                <a href="<?php echo $baseUrl1; ?>/ledger/admin">Ledger</a>
                <a href="<?php echo $baseUrl1; ?>/documents/admin">Documents</a>
              </li>
              <li class="divider"></li>
                <li>
                <a href="<?php echo $baseUrl1; ?>/instruments/admin">Instruments</a>
                <a href="<?php echo $baseUrl1; ?>/prices/admin">Prices</a>
              </li>
              <li class="divider"></li>
                <li>
                <a href="<?php echo $baseUrl1; ?>/portfolios/admin">Portfolios</a>
                <a href="<?php echo $baseUrl1; ?>/grouping/admin">Grouping</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="<?php echo $baseUrl1; ?>/counterparties/admin">Counterparties</a>  
              </li>
              <li class="divider"></li>
              <li>
                <a href="<?php echo $baseUrl1; ?>/user/admin">Users</a>
                <a href="<?php echo $baseUrl1; ?>/userRole/admin">User Roles</a>
              </li>
       </ul>
</div>


</div>
</nav>


		<!-- end navigation -->


<?php
/*

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
		  <?php $baseUrl1 = Yii::app()->baseUrl; ?>
          <!-- Be sure to leave the brand out there if you want it shown-->
          <a class="brand" href="<?php echo $baseUrl1;?>/site/index">Verare</a> 
          <!--<a class="brand" href="<?php //echo $baseUrl1;?>/site/index"><img src="<?php //echo $baseUrl;?>/img/rdl-logo.png" style= 'height: 18px;'/></a>-->
		  <div class="span5"></div>	  
          <div class="nav-collapse" style="float: left;">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
                        array('label'=>'Home', 'url'=>array('/site/index')),
                        array('label'=>'Dashboard', 'url'=>array('/site/admin')),
                        
                        array('label'=>'Overview', 'url'=>array('/site/page', 'view'=>'graphs')),
                        array('label'=>'Analysis', 'url'=>array('/site/page', 'view'=>'forms')),
                       // array('label'=>'Tables', 'url'=>array('/site/page', 'view'=>'tables')),
					//	array('label'=>'Interface', 'url'=>array('/site/page', 'view'=>'interface')),
                      //  array('label'=>'Typography', 'url'=>array('/site/page', 'view'=>'typography')),
                        /*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/
                    /*
                        array('label'=>'My Account <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'My Messages <span class="badge badge-warning pull-right">26</span>', 'url'=>'#'),
							array('label'=>'My Tasks <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
							array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
							array('label'=>'Separated link', 'url'=>'#'),
							array('label'=>'One more separated link', 'url'=>'#'),
                        )),
                        *//*
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
		</div>

<div class="dropdown" style="float: left;">
            <a id="dLabel"  data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#">ADMIN <span class="caret"></span>
            </a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li>
                <a href="<?php echo $baseUrl1; ?>/ledger/admin">Ledger</a>
                <a href="<?php echo $baseUrl1; ?>/documents/admin">Documents</a>
              </li>
              <li class="divider"></li>
                <li>
                <a href="<?php echo $baseUrl1; ?>/instruments/admin">Instruments</a>
                <a href="<?php echo $baseUrl1; ?>/prices/admin">Prices</a>
              </li>
              <li class="divider"></li>
                <li>
                <a href="<?php echo $baseUrl1; ?>/portfolios/admin">Portfolios</a>
                <a href="<?php echo $baseUrl1; ?>/grouping/admin">Grouping</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="<?php echo $baseUrl1; ?>/counterparties/admin">Counterparties</a>  
              </li>
              <li class="divider"></li>
              <li>
                <a href="<?php echo $baseUrl1; ?>/user/admin">Users</a>
                <a href="<?php echo $baseUrl1; ?>/userRole/admin">User Roles</a>
              </li>
 
<?php /*           
              
              <li class="divider"></li>
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Customers</a>
                <ul class="dropdown-menu">
				  <li><a tabindex="-1" href="/custGroups/admin">Customer Groups</a></li>
				  <li><a tabindex="-1" href="/customergroups/admin">Manage Groups</a></li>
                  <li><a tabindex="-1" href="/customers/customerupdate">Update Customers from Server</a></li>
                </ul>
              </li>
			  
			  <li class="dropdown-submenu">
                <a tabindex="-1" href="#">products</a>
                <ul class="dropdown-menu">				
				  <li><a tabindex="-1" href="/products/admin">Custom Product Grouping</a></li>
                  <li><a tabindex="-1" href="/products/productupdate">Update Products from SQL database</a></li>
				  <li><a tabindex="-1" href="/categories/groupview">Groups, Subgroups and categories</a></li>
				  <li><a tabindex="-1" href="/productGroups/admin">Product Groups</a></li>
                </ul>
              </li>
			  <li><a href="/zipMsa/create">Zip-CBSA Administration</a></li>
			  <li><a href="/customers/customersWithoutGeocode">Update Geocodes</a></li>
					
			  <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Update/Edit</a>
                <ul class="dropdown-menu">
                  <li><a tabindex="-1" href="/groups/admin">Groups</a></li>
				  <li><a tabindex="-1" href="/subgroups/admin">Subgroups</a></li>
				  <li><a tabindex="-1" href="/categories/admin">Categories</a></li>
				  <li><a tabindex="-1" href="/departments/admin">Department colors</a></li>
				  
                </ul>
              </li>
				
			  <li><a href="/cronLogs/admin">Cron Logs</a></li>
			  <li><a href="/site/start">Database connection settings</a></li>
			   <li><a href="/settings/update/1">Daily Average Sales Goal</a></li>
			
		<!--	  <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Hover me for more options</a>
                <ul class="dropdown-menu">
                  <li><a tabindex="-1" href="#">Second level</a></li>
                  <li class="dropdown-submenu">
                    <a href="#">Even More..</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">3rd level</a></li>
                    	<li><a href="#">3rd level</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Second level</a></li>
                  <li><a href="#">Second level</a></li>
                </ul>
              </li>
			 --> 
			*//*
            ?>  
            </ul>
        </div>


		
    	
    </div>
	</div>
</div>
*/
?>



