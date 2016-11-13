<?php 
$baseUrl = Yii::app()->theme->baseUrl; 
$baseUrl1 = Yii::app()->baseUrl;
?>
<script>
//function redirecttologin(){
// window.location.href='<?php echo $baseUrl1;?>/user/login';
//}
</script>
		<!-- start preloader -->
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div>
		<!-- end preloader -->
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
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right text-uppercase">
						<li><a href="#home">Home</a></li>
						<li><a href="#feature">Services</a></li>
						<li><a href="#download">Login</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- end navigation -->
		<!-- start home -->
		<section id="home">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
							<h1 class="text-upper">Treasury Management System</h1>
							<p class="tm-white">Verare provides a wide range of services and tools to the finance industry. Our areas of expertise include valuation, performance tracking, risk managament, reporting and much more. The name of our main tool is Treasury Management System.</p>
							<img src="<?php echo $baseUrl;?>/images/computer_overview.png" class="img-responsive" alt="home img">
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div> 
		</section>
		<!-- end home -->
		<!-- start divider -->
		<section id="divider">
			<div class="container">
				<div class="row">
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-calculator"></i>
						<h3 class="text-uppercase">VALUATIONS</h3>
						<p>TMS valuation tools exists as standard versions depending on investment focus and portfolio complexity or can be customized to the exact needs of an investment manager providing a cost efficient system solution. All TMS tools are available as window or mac applications and via Internet. TMS also have an android app available in the play store, and an apple app in development.</p>
					</div>
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-calendar"></i>
						<h3 class="text-uppercase">CASH MANAGEMENT</h3>
						<p>Through TMS portals you will have up-to-date and accurate valuation of your portfolio and trades on demand.  By using TMS online platform you can add value added services like in depth analysis, efficiency calculations for portfolios and for due diligence. TMS provide basic risk analysis as standard and additional analysis on demand.</p>
					</div>
					<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
						<i class="fa fa-bar-chart"></i>
						<h3 class="text-uppercase">REPORTING</h3>
						<p>TMS provide standard reporting formats and possibilities to customize report functions to daily, monthly or ad hoc reports. TMS provide on demand services for longer and more in depth reporting, providing analysis for auditing and tax reporting.</p>
					</div>
				</div>
			</div>
		</section>
		<!-- end divider -->

		<!-- start feature -->
		<section id="feature">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
						<h2 class="text-uppercase">Valuations, Performance Tracking, and Risk</h2>
						<p>TMS provides a platform with state of the art calculators using the latest market standards to provide correct evaluations.</p>
						<p><span><i class="fa fa-mobile"></i></span>Using the most frequent market data available allows for immediate and speedy observations on valuation and risk.</p>
						<p><i class="fa fa-code"></i>TMS trade logs and trade history database allows for various ways of monitoring cash flows and portfolio events and provides tools to plan future events to ensure an efficient portfolio management.</p>
					</div>
					<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
					    <img src="<?php echo $baseUrl;?>/images/computer_piechart.png" class="img-responsive" alt="feature img">
					</div>
				</div>
			</div>
		</section>
		<!-- end feature -->

		<!-- start feature1 -->
		<section id="feature1">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
					    <img src="<?php echo $baseUrl;?>/images/computer_frontier.png" class="img-responsive" alt="feature img">
					</div>
					<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
						<h2 class="text-uppercase">Reporting, Cash Management, Case Analysis</h2>
						<p>TMS has standard reporting formats but allows for customization to meet the demand and requirements depending on investment focus.</p>
						<p><span><i class="fa fa-mobile"></i></span>Reporting analysis can be provided on a demand basis with market reports, in depth evaluation, event driven portfolio risks.</p>
						<p><i class="fa fa-code"></i>TMS can provide tools for measuring portfolio efficiency, allocation decisions, audit preparations and specialized reports for tax purposes.</p>
				        <p></p><a href="<?php echo $baseUrl;?>/images/Verare.pdf" target="_blank"><b>Mer om VERARE’s riskrapportering</b></a></p>
					</div>
				</div>
			</div>
		</section>
		<!-- end feature1 -->

		<!-- start login -->
		<section id="download">
			<div class="container">
				<div class="row">
					<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
						<h2 class="text-uppercase">Login</h2>
						
                        <?php
                        $model=new LoginForm;
                        $this->renderPartial('login', ['model'=>$model]);
                        ?>
                        
					</div>
					<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
					    <img src="<?php echo $baseUrl;?>/images/login4.jpg" class="img-responsive" alt="login img">
					</div>
				</div>
			</div>
		</section>
		<!-- end login -->
		
		<!-- start contact -->
		<section id="contact">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
							<h2 class="text-uppercase">Contact Us</h2>
							<p>Our office is in Sweden. Please, send us a message if you want to be contacted by a representative.</p>
							<address>
								<p><i class="fa fa-map-marker"></i>Riddargatan 30, 114 57 Stockholm, Sweden</p>
								<p><i class="fa fa-phone"></i> +46 730 489 756</p>
								<p><i class="fa fa-envelope-o"></i> info@verare.se</p>
							</address>
						</div>
						<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
							<div class="contact-form">
							    <form method="post" action="http://www.verare.se/cgi-bin/FormMail.pl" 
accept-charset="ISO-8859-1" onsubmit="var originalCharset = document.charset; 
document.charset = 'ISO-8859-1'; 
window.onbeforeunload = function () {document.charset=originalCharset;};">
									<div class="col-md-6">
										<input type="text" class="form-control" placeholder="Name" name="realname">
									</div>
									<div class="col-md-6">
										<input type="email" class="form-control" placeholder="Email" name="email">
									</div>
									<div class="col-md-12">
										<input type="text" class="form-control" placeholder="Subject" name="subject">
									</div>
									<div class="col-md-12">
										<textarea class="form-control" placeholder="Message" rows="4" name="Message"></textarea>
									</div>
									<input type="hidden" name="recipient" value="info@verare.se" />
									<input type="hidden" name="redirect" value="http://www.verare.se" />
                                    <input type="hidden" name="missing_fields_redirect" value="http://www.verare.se" />
                                    <input type="hidden" name="required" value="realname,email,Message" />
									<div class="col-md-12">
										<input type="submit" class="form-control text-uppercase" value="Send">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end contact -->

		<!-- start footer -->
        <!--
		<footer>
			<div class="container">
				<div class="row">
					<p>Copyright © 2015 Verare AB</p>
				</div>
			</div>
		</footer>
        -->
		<!-- end footer -->