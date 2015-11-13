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
}
