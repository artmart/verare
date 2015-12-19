<?php
Yii::import('ext.phpexcel.XPHPExcel');
XPHPExcel::init();

class Calculators {
   ///regression example// 
     public static function coeff($ankax_id, $kaxyal_id, $update_year)
     {  
        $n = 0; 
        $k = 0;
        for($y = 2003; $y<$update_year+1; $y++)
        {
        $year_name = "y".$y;
        
        $ankax1[$n] = floatval(SyunikScenarioBase::model()->find('id = :id',array(':id'=>$ankax_id))->$year_name);
        $kaxyal1[$n] = floatval(SyunikScenarioBase::model()->find('id = :id',array(':id'=>$kaxyal_id))->$year_name);
        if($ankax1[$n]>0 && $kaxyal1[$n]>0){
            $ankax[$k]= $ankax1[$n];
            $kaxyal[$k] = $kaxyal1[$n]; 
            $k = $k+1;
        }
            
        $n = $n +1;
        }
        
        $ab = PHPExcel_Calculation_Statistical::LINEST($kaxyal, $ankax,TRUE, FALSE);
        return array(floatval($ab['1']), floatval($ab['0']));
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
}
