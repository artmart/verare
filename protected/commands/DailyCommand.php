<?php

class DailyCommand extends CConsoleCommand {
    
    public function run() 
    {
    //here we are doing what we need to do
    //set_time_limit(50000);
	ini_set('max_execution_time', 50000);
		
		//updating item list
		$mssql="SELECT distinct 'SE' + CAST([id] as varchar) item_key, 'Service' product_type, InvoiceDescription as invoice_description, 
								description, ProductNumber as product_number FROM Services where status = 'A' 
				Union All
				SELECT distinct 'ME' + CAST([id] as varchar) item_key, 'Metal' product_type, InvoiceDescription as invoice_description, 
								metal_type as description, ProductNumber as product_number FROM MetalMaster where status = 'A'";
		
		$products_mssql = Yii::app()->msdb->createCommand($mssql)->queryAll();
		
		foreach ($products_mssql as $pr)
		{	
			$item_key = $pr['item_key'];
			$product_type = $pr['product_type'];
			$invoice_description = $pr['invoice_description'];
			$description = $pr['description'];
			$product_number = $pr['product_number'];
			 
			$duplicates = "select id from products where item_key = '$item_key' and product_type = '$product_type' 
							and invoice_description = '$invoice_description' and description = '$description' and product_number = '$product_number'";
			$search_mysql = Yii::app()->db->createCommand($duplicates)->queryAll();

			if (count($search_mysql)==0){				
				$sql = "insert into products (item_key, product_type, invoice_description, description, product_number) 
						values (:item_key, :product_type, :invoice_description, :description, :product_number)";
				$parameters = array(':item_key'=>$item_key, ':product_type'=>$product_type, ':invoice_description'=>$invoice_description, 
									':description' => $description, ':product_number' => $product_number); 
				
				Yii::app()->db->createCommand($sql)->execute($parameters);
			}
		} 
	//Updating Customers list
	$mssql="SELECT Cust.custseqno, Cust.status, Cust.title, Cust.sname, Cust.LName, Cust.FName, Cl.City, SC.StateName, CL.zipcd FROM Cust 
			left JOIN Custloc CL WITH (NOLOCK) ON Cust.Custseqno = CL.custseqno and CL.BillToFlag = 1
			left JOIN StateCodes SC WITH (NOLOCK) ON CL.StateCD = SC.StateCode where Cust.status = 'A'";	
		
	$cust_mssql = Yii::app()->msdb->createCommand($mssql)->queryAll();
		
		foreach ($cust_mssql as $cust)
		{	
			$custseqno = $cust['custseqno'];
			$status = $cust['status'];
			$title = $cust['title'];
			$sname = $cust['sname'];
			$fname = $cust['FName'];
			$lname = $cust['LName'];
			$city = $cust['City'];
			$state = $cust['StateName'];
			$zipcode = $cust['zipcd'];
			 
			$duplicates = "select id from customers where custseqno = '$custseqno'";
			$search_mysql = Yii::app()->db->createCommand($duplicates)->queryAll();

			if (count($search_mysql)==0){				
				$sql = "insert into customers (custseqno, status, title, sname, fname, lname, city, state, zip_code) 
						values (:custseqno, :status, :title, :sname, :fname, :lname, :city, :state, :zip_code)";
				$parameters = array(':custseqno'=>$custseqno, ':status'=>$status, ':title'=>$title, ':sname' => $sname, ':fname' => $fname, ':lname' => $lname,
									'city' => $city, 'state' => $state, 'zip_code' => $zipcode ); 
				
			Yii::app()->db->createCommand($sql)->execute($parameters);	
			}
		}
		
		/////update alerts/////
		$sql = "SELECT Cust.custseqno, 
			SUM(case when DATEDIFF(month, AAPS.SaleDate, GETDATE())<3 and Month(AAPS.SaleDate)<>Month(GETDATE()) then AAPS.SalesAmount else 0 end) amount2month,
			SUM(case when DATEDIFF(month, AAPS.SaleDate, GETDATE())<7 and Month(AAPS.SaleDate)<>Month(GETDATE()) then AAPS.SalesAmount else 0 end) amount6month,
			SUM(case when DATEDIFF(month, AAPS.SaleDate, GETDATE())<13 and Month(AAPS.SaleDate)<>Month(GETDATE()) then AAPS.SalesAmount else 0 end) amount12month
			FROM absAccountProductSales AAPS WITH (NOLOCK) 
			INNER JOIN absAccountSales AAS WITH (NOLOCK) ON  AAPS.absAccountSalesId_fk = AAS.[id]
			INNER JOIN Cust WITH (NOLOCK) ON AAS.CustId_fk = Cust.custseqno
			INNER JOIN Custloc CL WITH (NOLOCK) ON Cust.Custseqno = CL.custseqno and CL.BillToFlag = 1
			INNER JOIN StateCodes SC WITH (NOLOCK) ON CL.StateCD = SC.StateCode
			WHERE AAPS.SaleDate IS NOT NULL and Cust.status = 'A' Group by Cust.custseqno";
			
		$alerts = Yii::app()->msdb->createCommand($sql)->queryAll(true);

		foreach ($alerts as $alert){
			$amount2month1=$alert['amount2month'];
			$amount6month1=$alert['amount6month'];
			$amount12month=$alert['amount12month'];
			$custseqno = $alert['custseqno'];
			
			if($amount6month1>0){$amount2month=(3*$amount2month1/$amount6month1 -1)*100;
								}else {$amount2month= 0;}
			 if($amount12month>0){$amount6month=(2*$amount6month1/$amount12month -1)*100;
								}else {$amount6month= 0;}
			
			$sql_update="update customers set amount2month=$amount2month, amount6month = $amount6month, amount12month = $amount12month where custseqno=$custseqno";
			Yii::app()->db->createCommand($sql_update)->execute();
		}
		
		//logging cron status
		$cron_log = "insert into cron_logs (log) values (:log)";
		$parameters_log = array(':log'=>'Updated successfully'); 
				
		Yii::app()->db->createCommand($cron_log)->execute($parameters_log);
    }
}

?>