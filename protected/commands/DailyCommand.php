<?php
class DailyCommand extends CConsoleCommand {
    
    public function run() 
    {
        Calculators::CurrenyRatesUpdate();
    }
}
?>