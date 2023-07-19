<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(isset($_POST['getreport'])){
$startdate=$_POST['eventstartDate'];
 $startdate=date("Y-m-d",strtotime($startdate));
$enddate=$_POST['eventendDate'];
 $enddate=date("Y-m-d",strtotime($enddate));
 if(strtotime($startdate)>strtotime(date("Y-m-d")) || strtotime($enddate)>strtotime(date("Y-m-d")) ){
	 $Obj->Redirect("report.php?msg=f_error");die;
 }
 if(strtotime($startdate)>strtotime($enddate)){
	 	$Obj->Redirect("report.php?msg=d_error");die;
 }
	
}
//echo $sql="select purchases.posted_date,purchases.product_quantity, purchases.invoice, host_product.product_name, purchases.product_amount, purchases.payer_email, purchases.payer_address,purchases.payer_city, purchases.payer_state, purchases.payer_country, user.first_name, user.last_name from purchases join host_product on purchases.product_id=host_product.id AND purchases.host_id=".$_SESSION['user_id']." and purchases.product_type='product' and  purchases.posted_date between '".$startdate."' AND '".$enddate."' join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice order by purchases.id desc ";	
//die;
  $sql="select purchases.posted_date,purchases.product_quantity, purchases.invoice, host_product.product_name, purchases.product_amount, purchases.payer_email, purchases.payer_address,purchases.payer_city, purchases.payer_state, purchases.payer_country, purchases.payer_zip, user.first_name, user.last_name from purchases join host_product on purchases.host_id='".$_SESSION['user_id']."' and purchases.product_type='product' and purchases.posted_date between '".$startdate."' AND '".$enddate."' and purchases.product_id=host_product.id join user on purchases.user_id=user.id join store_order_status on purchases.invoice=store_order_status.invoice order by purchases.id desc ";

 
$info=mysql_query($sql);
if(mysql_num_rows($info)){

}
header('Content-type: application/excel');
$filename = 'filename.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>

<body>
   <table><tr>
		<td>Invoice</td>
		<td>Product Name</td>
		<td>Qty</td>
		<td>Amount</td>
		<td>Total Amount</td>
		<td>Status</td>
		<td>Order By</td>
		<td>Email Id</td>	
		<td>Address</td>
		<td>city</td>
		<td>state</td>
		<td>country</td>
		<td>zip</td>
		<td>Date</td>
		</tr></table>';
while($row=mysql_fetch_array($info)){
	 $cont="<table><tr><td>".$row['invoice']."</td><td>".$row['product_name']."</td><td>".$row['product_quantity']."</td>
	<td>".$row['product_amount']."</td>
	<td>".$row['product_quantity']*$row['product_amount']."</td>
	<td>".$row['invoice']."</td>
	<td>".$row['first_name']." ".$row['last_name']."</td>
	<td>".$row['payer_email']."</td>
	<td>".$row['payer_address']."</td>
	<td>".$row['payer_city']."</td>
	<td>".$row['payer_state']."</td>
	<td>". $row['payer_country']."</td>
	<td>".$row['payer_zip']."</td><td>".$row['posted_date']."</td>
	</tr></table>".$cont;
	
	
	}
		$data=$data.$cont.'</body></html>';


echo $data;
