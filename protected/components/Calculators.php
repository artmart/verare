<?php
Yii::import('ext.phpexcel.XPHPExcel');
XPHPExcel::init();

class Calculators {


////////////////////////cron functions////////////////////////////    
    public static function url_get_contents ($Url) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get the code of request
        curl_close($ch);
    
        if($httpCode == 400) 
           return 0;
    
        if($httpCode == 200) //is ok?
           return $output;
    }
    
    public static function CurrenyRatesUpdate()
    { 
        ini_set('max_execution_time', 150000);
        ini_set("memory_limit","128M"); 

        $max_date_sql = "select MAX(day) day from currency_rates";
        $max_date_res = Yii::app()->db->createCommand($max_date_sql)->queryAll(true);
        
        //var_dump($max_date_res[0]["day"]);
        //exit;

        $start_date = date($max_date_res[0]["day"]); // date("2000-01-01"); //  date('Y-m-d', strtotime('-1 years'));
        $start_date = strtotime($start_date);
        $start_date = strtotime("+1 day", $start_date);
        $start_date = date('Y-m-d', $start_date); 

       $currencies = ['EUR', 'JPY', 'GBP', 'AUD', 'CHF', 'CAD', 'MXN', 'CNY', 'CNH', 'NZD', 'SEK', 'RUB', 'DKK', 'NOK', 'HKD', 'SGD', 'TRY', 'KRW', 'ZAR', 'BRL', 'INR'];
        
        while(strtotime($start_date)<= strtotime("now")){
            $currency_rates = New CurrencyRates;
            $currency_rates->day = $start_date;
                        
            foreach($currencies as $cur){
                $currency_rates->{$cur} = 0;
                               
                $Url = "http://currencies.apps.grandtrunk.net/getrate/".$start_date."/".$cur."/USD";
                $get_rate = Self::url_get_contents ($Url);
                                
                if($get_rate>=0){$currency_rates->{$cur} = $get_rate;}
            }
            $currency_rates->save();
  
            ///+one day//             
            $start_date = strtotime($start_date);
            $start_date = strtotime("+1 day", $start_date);
            $start_date = date('Y-m-d', $start_date); 
        }
    }
 //////////////////////////////////////////////////////////////////////////////
 
 
    
     public static function PNL($start_date, $end_date, $portfolio)
     {  
        $sql1 = "select trade_date, nominal*price nav from ledger
                where portfolio_id = '$portfolio' and trade_date > '$start_date' and trade_date<'$end_date' and ledger.trade_status_id = 2 
                order by trade_date desc";
        $results1 = Yii::app()->db->createCommand($sql1)->queryAll(true);
        $nav_today = 0;
        $nav_yesterday = 0;
        $i = 0;
        foreach($results1 as $res1){
            $nav_today = $nav_today + $res1['nav'];
            if($i>0){
                $nav_yesterday = $nav_yesterday + $res1['nav'];
            }
            $i++;
        }
        $onpl = $nav_today - $nav_yesterday;
        return [$onpl, $nav_today];
    }    
    
    public static function ReturnAllAndYTD($portfolio)
     {  
        
        $sql = "select pr.trade_date, pr.return, if(pr.trade_date >= MAKEDATE(year(now()),1), pr.return, 1) ytd  from portfolio_returns pr where pr.portfolio_id = '$portfolio'";
        $results = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        $product = 1;
        $all_time_return = 1;
        $year_to_date_return = 1;
        foreach($results as $res){
            $all_time_return = $all_time_return * $res['return'];
            $year_to_date_return = $year_to_date_return * $res['ytd'];            
        }

        return [($all_time_return - 1)*100, ($year_to_date_return - 1)*100];
    }
        
    public static function CalcAllStats($data, $benchmark)
    {  
            $cnt=0;
    		$sumP=0;
    		$sumB=0;
    		$sumX=0;
    		$sumY=0;
    		$sumZ=0;
    		$sumPB=0;
    		$sumP2=0;
    		$sumB2=0;
    		$retP=1;
    		$tmpB=0;
    		$K=0;
    		$varP=0;
    		$varB=0;
    		$varX=0;
    		$retMax=-100000;
    		$retMin=100000;
            
            $sumP = array_sum($data);
            $retP = array_product($data);
            $sumB = array_sum($benchmark);
            $sumX = $sumP - $sumB;
            $retP-=1;
            
            $cnt1 = count($data);
            $meanP=$sumP/$cnt1;
            $meanB=$sumB/$cnt1;
            $meanX=$sumX/$cnt1;
            
    		foreach($data as $d) {	
    			//$sumP+=$d;
    			//$retP*=$d;
    			//$sumB+=$benchmark[$cnt];
    			//$sumX+=$d-$benchmark[$cnt];
    			$sumPB+=$d*$benchmark[$cnt];
    			$sumP2+=pow($d,2);
    			$sumB2+=pow($benchmark[$cnt],2);
    			if($d>$benchmark[$cnt]) {
    				$K++;
    			}
    			if($d<1) { //threshold = 0
    				$sumY+=$benchmark[$cnt]-$d;
    				$sumZ+=pow($benchmark[$cnt]-$d,2);
    			}
    			if($d>$retMax) {
    				$retMax=$d;
    			}
    			if($d<$retMin) {
    				$retMin=$d;
    			}
       
                $varP+=pow($d-$meanP, 2);
    			$varB+=pow($benchmark[$cnt]-$meanB, 2);
    			$varX+=pow($d-$benchmark[$cnt]-$meanX, 2);
    			
                $cnt++;
    		}
    		
    		$meanY=$sumY/$cnt;
    		$meanZ=$sumZ/$cnt;

    		$tmpC=$sumP*$sumB/$cnt;
    		$covarPB=($sumPB-$tmpC)/($cnt-1);
    		$i=0;

    		$varP/=($cnt-1);
    		$varB/=($cnt-1);
    		$varX/=($cnt-1);
    		$volP=sqrt($varP)*sqrt(240);
    	//	$volB=sqrt($varB)*sqrt(240); // do i need this?
    		$volX=sqrt($varX)*sqrt(240);
    		$beta=$covarPB/$varB;
    		$sharpe=$retP/$volP;
    		$alpha=$meanP-$beta*$meanB;
    		$treynor=$retP/$beta;
    		$TE=$volX;
    		$IK=($retP-$retB)/$volX;
    		$K/=$cnt;
    		$R2=pow(($cnt*$sumPB-$sumP*$sumB)/pow(($cnt*$sumP2-pow($sumP,2))*($cnt*$sumB2-pow($sumB,2)),1/2),2);
    		$omega=1+$meanX/$meanY;
    		$sortino=$meanX/pow($meanY, 1/2);
    		//$VaR=$meanX+$volP*NormSInv(0.01);
    		$VaR=$meanX+$volP*$this->inverse_ncdf(0.01);
		    return array($volP, $sharpe, $alpha, $beta, $treynor, $TE, $IK, $K, $R2, $VaR,($meanP-1), ($retMax-1), ($retMin-1), $sortino, $omega, $meanX, $meanY);
    }
    
    

	///////////////////////////////////////////////////////////////////////////////////////////////////
	//
	//	returnTarget is the return of an instrument or group that we want to evaluate
	//	returnBenchmark is the instrument or group that we are comparing against
	//	The general idea is to minimize the number of loops, making the calculations as fast as possible
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
    public static function CalcAllStats1_my($returnTarget, $returnBenchmark) {
		// initialize the variables
		$returnCount = 0;
		$sumTarget = 0;
		$sumBench = 0;
		$sumTargetMinusBench = 0;
		$sumTargetTimesBench = 0;
		$sumBenchMinusTargetOnBadDays = 0;
		$sumBenchMinusTargetSquaredOnBadDays = 0;
		$sumTargetSquared = 0;
		$sumBenchSquared = 0;
		$returnTargetCumulative = 0;
		$returnBenchCumulative = 0;
		$countGoodDays = 0;
		$returnMax = -10000;
		$returnMin = 10000;
		$varianceTarget = 0;
		$varianceBench = 0;
		$varianceTargetMinusBench = 0;
		
		// do the first loop
		foreach($returnTarget as $r) {
			
			$sumTarget += $r;
			$sumBench += $returnBenchmark[$returnCount];
			$returnTargetCumulative *= $r;
			$returnBenchCumulative *= $returnBenchmark[$returnCount];
			$sumTargetMinusBench += $r-$returnBenchmark[$returnCount];
			$sumTargetTimesBench += $r*$returnBenchmark[$returnCount];
			$sumTargetSquared += pow($r,2);
			$sumBenchSquared += pow($returnBenchmark[$returnCount],2);
			if($r>$returnBenchmark[$returnCount]) { // A good day
				$countGoodDays++;
			}
			if($r<1) { //threshold = 0
				$sumBenchMinusTargetOnBadDays += $returnBenchmark[$returnCount]-$r;
				$sumBenchMinusTargetSquaredOnBadDays += pow($returnBenchmark[$returnCount]-$r,2);
			}
			if($r>$returnMax) {
				$returnMax=$r;
			}
			if($r<$returnMin) {
				$returnMin=$r;
			}
            
            $returnCount++;
		}
		
		// calculate some figures
		$returnTargetCumulative--;
		$returnBenchCumulative--;
		$averageTarget = $sumTarget/$returnCount;
		$averageBench = $sumBench/$returnCount;
		$averageTargetMinusBench = $sumTargetMinusBench/$returnCount;
		$averageBenchMinusTargetOnBadDays = $sumBenchMinusTargetOnBadDays/$returnCount;
		$averageBenchMinusTargetSquaredOnBadDays = $sumBenchMinusTargetSquaredOnBadDays/$returnCount;
		$covarTargetBench = ($sumTargetTimesBench-$sumTarget*$sumBench/$returnCount)/($returnCount-1);
		
		// second loop
		$i = 0;
		foreach($returnTarget as $r) {
			$varianceTarget += pow($r-$averageTarget, 2);
			$varianceBench += pow($r-$averageBench, 2);
			$varianceTargetMinusBench += pow($r-$averageBench-$averageTargetMinusBench, 2);
			$i++;
		}
		
		// calculate the output
		$varianceTarget /= ($returnCount-1);
		$varianceBench /= ($returnCount-1);
		$varianceTargetMinusBench /= ($returnCount-1);
		$volTarget = sqrt($varianceTarget)*sqrt(240);
		$volBench = sqrt($varianceBench)*sqrt(240);
		$volTargetMinusBench = sqrt($varianceTargetMinusBench)*sqrt(240);
		$beta = $covarTargetBench/$varianceBench;
		$sharpe = $returnTargetCumulative/$volTarget;
		$alpha = $averageTarget-$beta*$averageBench;
		$treynor = $returnTargetCumulative/$beta;
		$trackingError = $volTargetMinusBench;
		$infoQuota = ($returnTargetCumulative-$returnBenchCumulative)/$volTargetMinusBench;
		$consistency = $countGoodDays/$returnCount;
		$R2 = pow(($returnCount*$sumTargetTimesBench-$sumTarget*$sumBench)/pow(($returnCount*$sumTargetSquared-pow($sumTarget,2))*($returnCount*$sumBenchSquared-pow($sumBench,2)),1/2),2);
		
        if($averageBenchMinusTargetOnBadDays !== 0){
            $omega=1+$averageTargetMinusBench/$averageBenchMinusTargetOnBadDays;
            $sortino=$averageTargetMinusBench/pow($averageBenchMinusTargetOnBadDays, 1/2);
        }else{$omega = "Div/Null!"; $sortino= "Div/Null!";}
		
		$VaR=$averageTargetMinusBench+$volTarget*PHPExcel_Calculation_Statistical::NORMSINV(0.01);
		//$VaR=$averageTargetMinusBench+$volTarget*$this->inverse_ncdf(0.01);
		return array($volTarget, $sharpe, $alpha, $beta, $treynor, $trackingError, $infoQuota, $consistency, $R2, $VaR, ($averageTarget-1), ($returnMax-1), ($returnMin-1), $sortino, $omega, $averageTargetMinusBench, $averageBenchMinusTargetOnBadDays);
    }
    
    
    public static function CalcAllStats1($returnTarget, $returnBenchmark) {
		// initialize the variables
		$returnCount = 0;
		$sumTarget = 0;
		$sumBench = 0;
		$sumTargetMinusBench = 0;
		$sumTargetTimesBench = 0;
		$sumBenchMinusTargetOnBadDays = 0;
		$sumBenchMinusTargetSquaredOnBadDays = 0;
		$sumTargetSquared = 0;
		$sumBenchSquared = 0;
		$returnTargetCumulative = 0;
		$returnBenchCumulative = 0;
		$countGoodDays = 0;
		$returnMax = -10000;
		$returnMin = 10000;
		$varianceTarget = 0;
		$varianceBench = 0;
		$varianceTargetMinusBench = 0;
		
		// do the first loop
		foreach($returnTarget as $r) {
			
			$sumTarget += $r;
			$sumBench += $returnBenchmark[$returnCount];
			$returnTargetCumulative *= $r;
			$returnBenchCumulative *= $returnBenchmark[$returnCount];
			$sumTargetMinusBench += $r-$returnBenchmark[$returnCount];
			$sumTargetTimesBench += $r*$returnBenchmark[$returnCount];
			$sumTargetSquared += pow($r,2);
			$sumBenchSquared += pow($returnBenchmark[$returnCount],2);
			if($r>$returnBenchmark[$returnCount]) { // A good day
				$countGoodDays++;
			}
			if($r<1) { //threshold = 0
				$sumBenchMinusTargetOnBadDays += $returnBenchmark[$returnCount]-$r;
				$sumBenchMinusTargetSquaredOnBadDays += pow($returnBenchmark[$returnCount]-$r,2);
			}
			if($r>$returnMax) {
				$returnMax=$r;
			}
			if($r<$returnMin) {
				$returnMin=$r;
			}
            
            $returnCount++;
		}
        		
		if($returnCount>1)
		{
			// calculate some figures
			$returnTargetCumulative--;
			$returnBenchCumulative--;
			$averageTarget = $sumTarget/$returnCount;
			$averageBench = $sumBench/$returnCount;
			$averageTargetMinusBench = $sumTargetMinusBench/$returnCount;
			$averageBenchMinusTargetOnBadDays = $sumBenchMinusTargetOnBadDays/$returnCount;
			$averageBenchMinusTargetSquaredOnBadDays = $sumBenchMinusTargetSquaredOnBadDays/$returnCount;
			$covarTargetBench = ($sumTargetTimesBench-$sumTarget*$sumBench/$returnCount)/($returnCount-1);
			
			// second loop
			$i = 0;
			foreach($returnTarget as $r) {
				$varianceTarget += pow($r-$averageTarget, 2);
				$varianceBench += pow($r-$averageBench, 2);
				$varianceTargetMinusBench += pow($r-$averageBench-$averageTargetMinusBench, 2);
				$i++;
			}
			
			// calculate the output
			$varianceTarget /= ($returnCount-1);
			$varianceBench /= ($returnCount-1);
			$varianceTargetMinusBench /= ($returnCount-1);
			$volTarget = sqrt($varianceTarget)*sqrt(240);
			$volBench = sqrt($varianceBench)*sqrt(240);
			$volTargetMinusBench = sqrt($varianceTargetMinusBench)*sqrt(240);
			if($varianceBench > 0)
			{
				$beta = $covarTargetBench/$varianceBench;
			}
			else
			{
				$beta = 0;
			}
			if($volTarget > 0)
			{
				$sharpe = $returnTargetCumulative/$volTarget;
			}
			else
			{
				$sharpe = 0;
			}
			$alpha = $averageTarget-$beta*$averageBench;
			if($beta > 0)
			{
				$treynor = $returnTargetCumulative/$beta;
			}
			else
			{
				$treynor = 0;
			}
			$trackingError = $volTargetMinusBench;
			if($volTargetMinusBench > 0)
			{
				$infoQuota = ($returnTargetCumulative-$returnBenchCumulative)/$volTargetMinusBench;
			}
			else
			{
				$infoQuota = 0;
			}
			$consistency = $countGoodDays/$returnCount;
			$x = pow(($returnCount*$sumTargetSquared-pow($sumTarget,2))*($returnCount*$sumBenchSquared-pow($sumBench,2)),1/2);
			//$x = pow(($returnCount*$sumTargetTimesBench-$sumTarget*$sumBench)/pow(($returnCount*$sumTargetSquared-pow($sumTarget,2))*($returnCount*$sumBenchSquared-pow($sumBench,2)),1/2),2);
			if($x > 0)
			{
				$R2 = pow(($returnCount*$sumTargetTimesBench-$sumTarget*$sumBench)/$x,2);
			}
			else
			{
				$R2 = 0;
			}
			
			if($averageBenchMinusTargetOnBadDays !== 0){
				$omega=1+$averageTargetMinusBench/$averageBenchMinusTargetOnBadDays;
				$sortino=$averageTargetMinusBench/pow($averageBenchMinusTargetOnBadDays, 1/2);
			}else{$omega = 0;
            // "Div/Null!"; 
            $sortino= 0; // "Div/Null!";
            }
			
			$VaR=$averageTargetMinusBench+$volTarget*PHPExcel_Calculation_Statistical::NORMSINV(0.01);
			//$VaR=$averageTargetMinusBench+$volTarget*$this->inverse_ncdf(0.01);
		}
		else
		{
			$volTarget = 0;
			$sharpe = 0;
			$beta = 0;
			$treynor = 0;
			$trackingError = 0;
			$infoQuota = 0;
			$consistency = 0;
			$R2 = 0;
			$VaR = 0;
			$averageTarget = 1;
			$returnMax = 1;
			$returnMin = 1;
			$sortino = 0;
			$omega = 0;
			$averageTargetMinusBench = 0;
			$averageBenchMinusTargetOnBadDays = 0;
		}
		return array($volTarget, $sharpe, $alpha, $beta, $treynor, $trackingError, $infoQuota, $consistency, $R2, $VaR, ($averageTarget-1), ($returnMax-1), ($returnMin-1), $sortino, $omega, $averageTargetMinusBench, $averageBenchMinusTargetOnBadDays);
    }
    
    public static function CalcAllStats_bench($returnTarget, $returnBenchmark) {
		// initialize the variables
		$returnCount = 0;
		$sumTarget = 0;
		$sumBench = 0;
		$sumTargetMinusBench = 0;
		$sumTargetTimesBench = 0;
		$sumBenchMinusTargetOnBadDays = 0;
		$sumBenchMinusTargetSquaredOnBadDays = 0;
		$sumTargetSquared = 0;
		$sumBenchSquared = 0;
		$returnTargetCumulative = 0;
		$returnBenchCumulative = 0;
		$countGoodDays = 0;
		$returnMax = -10000;
		$returnMin = 10000;
		$varianceTarget = 0;
		$varianceBench = 0;
		$varianceTargetMinusBench = 0;
		
		// do the first loop
		foreach($returnTarget as $r) {
			
			$sumTarget += $r;
			$sumBench += $returnBenchmark[$returnCount];
			$returnTargetCumulative *= $r;
			$returnBenchCumulative *= $returnBenchmark[$returnCount];
			$sumTargetMinusBench += $r-$returnBenchmark[$returnCount];
			$sumTargetTimesBench += $r*$returnBenchmark[$returnCount];
			$sumTargetSquared += pow($r,2);
			$sumBenchSquared += pow($returnBenchmark[$returnCount],2);
			if($r>$returnBenchmark[$returnCount]) { // A good day
				$countGoodDays++;
			}
			if($r<1) { //threshold = 0
				$sumBenchMinusTargetOnBadDays += $returnBenchmark[$returnCount]-$r;
				$sumBenchMinusTargetSquaredOnBadDays += pow($returnBenchmark[$returnCount]-$r,2);
			}
			if($r>$returnMax) {
				$returnMax=$r;
			}
			if($r<$returnMin) {
				$returnMin=$r;
			}
            
            $returnCount++;
		}
		
		if($returnCount > 1)
		{
			// calculate some figures
			$returnTargetCumulative--;
			$returnBenchCumulative--;
			$averageTarget = $sumTarget/$returnCount;
			$averageBench = $sumBench/$returnCount;
			$averageTargetMinusBench = $sumTargetMinusBench/$returnCount;
			$averageBenchMinusTargetOnBadDays = $sumBenchMinusTargetOnBadDays/$returnCount;
			$averageBenchMinusTargetSquaredOnBadDays = $sumBenchMinusTargetSquaredOnBadDays/$returnCount;
			$covarTargetBench = ($sumTargetTimesBench-$sumTarget*$sumBench/$returnCount)/($returnCount-1);
			
			// second loop
			$i = 0;
			foreach($returnTarget as $r) {
				$varianceTarget += pow($r-$averageTarget, 2);
				$varianceBench += pow($r-$averageBench, 2);
				$varianceTargetMinusBench += pow($r-$averageBench-$averageTargetMinusBench, 2);
				$i++;
			}
			
			// calculate the output
			$varianceTarget /= ($returnCount-1);
			$varianceBench /= ($returnCount-1);
			$varianceTargetMinusBench /= ($returnCount-1);
			$volTarget = sqrt($varianceTarget)*sqrt(240);
			$volBench = sqrt($varianceBench)*sqrt(240);
			$volTargetMinusBench = sqrt($varianceTargetMinusBench)*sqrt(240);
			$sharpe = $returnTargetCumulative/$volTarget;
		}
		else
		{
			$volTarget = 0;
			$sharpe = 0;
		}

		return array($volTarget, $sharpe);
        //, $alpha, $beta, $treynor, $trackingError, $infoQuota, $consistency, $R2, $VaR, ($averageTarget-1), ($returnMax-1), ($returnMin-1), $sortino, $omega, $averageTargetMinusBench, $averageBenchMinusTargetOnBadDays
    }
    
    
    public static function CalcAllStats_bench_my($returnTarget, $returnBenchmark) {
		// initialize the variables
		$returnCount = 0;
		$sumTarget = 0;
		$sumBench = 0;
		$sumTargetMinusBench = 0;
		$sumTargetTimesBench = 0;
		$sumBenchMinusTargetOnBadDays = 0;
		$sumBenchMinusTargetSquaredOnBadDays = 0;
		$sumTargetSquared = 0;
		$sumBenchSquared = 0;
		$returnTargetCumulative = 0;
		$returnBenchCumulative = 0;
		$countGoodDays = 0;
		$returnMax = -10000;
		$returnMin = 10000;
		$varianceTarget = 0;
		$varianceBench = 0;
		$varianceTargetMinusBench = 0;
		
		// do the first loop
		foreach($returnTarget as $r) {
			
			$sumTarget += $r;
			$sumBench += $returnBenchmark[$returnCount];
			$returnTargetCumulative *= $r;
			$returnBenchCumulative *= $returnBenchmark[$returnCount];
			$sumTargetMinusBench += $r-$returnBenchmark[$returnCount];
			$sumTargetTimesBench += $r*$returnBenchmark[$returnCount];
			$sumTargetSquared += pow($r,2);
			$sumBenchSquared += pow($returnBenchmark[$returnCount],2);
			if($r>$returnBenchmark[$returnCount]) { // A good day
				$countGoodDays++;
			}
			if($r<1) { //threshold = 0
				$sumBenchMinusTargetOnBadDays += $returnBenchmark[$returnCount]-$r;
				$sumBenchMinusTargetSquaredOnBadDays += pow($returnBenchmark[$returnCount]-$r,2);
			}
			if($r>$returnMax) {
				$returnMax=$r;
			}
			if($r<$returnMin) {
				$returnMin=$r;
			}
            
            $returnCount++;
		}
		
		// calculate some figures
		$returnTargetCumulative--;
		$returnBenchCumulative--;
		$averageTarget = $sumTarget/$returnCount;
		$averageBench = $sumBench/$returnCount;
		$averageTargetMinusBench = $sumTargetMinusBench/$returnCount;
		$averageBenchMinusTargetOnBadDays = $sumBenchMinusTargetOnBadDays/$returnCount;
		$averageBenchMinusTargetSquaredOnBadDays = $sumBenchMinusTargetSquaredOnBadDays/$returnCount;
		$covarTargetBench = ($sumTargetTimesBench-$sumTarget*$sumBench/$returnCount)/($returnCount-1);
		
		// second loop
		$i = 0;
		foreach($returnTarget as $r) {
			$varianceTarget += pow($r-$averageTarget, 2);
			$varianceBench += pow($r-$averageBench, 2);
			$varianceTargetMinusBench += pow($r-$averageBench-$averageTargetMinusBench, 2);
			$i++;
		}
		
		// calculate the output
		$varianceTarget /= ($returnCount-1);
		$varianceBench /= ($returnCount-1);
		$varianceTargetMinusBench /= ($returnCount-1);
		$volTarget = sqrt($varianceTarget)*sqrt(240);
		$volBench = sqrt($varianceBench)*sqrt(240);
		$volTargetMinusBench = sqrt($varianceTargetMinusBench)*sqrt(240);
		$sharpe = $returnTargetCumulative/$volTarget;

		return array($volTarget, $sharpe);
        //, $alpha, $beta, $treynor, $trackingError, $infoQuota, $consistency, $R2, $VaR, ($averageTarget-1), ($returnMax-1), ($returnMin-1), $sortino, $omega, $averageTargetMinusBench, $averageBenchMinusTargetOnBadDays
    }
}
