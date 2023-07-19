<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

 $qty=$_REQUEST['qty'];
$price=$_REQUEST['price'];
if($_REQUEST['title']=='Track'){
	if($_REQUEST['action']=='add'){
	$_SESSION['cart_value'][] = $_REQUEST['id'];
	}
	if($_REQUEST['action']=='sub'){
		$c_values=$_SESSION['cart_value'];
		$cart_item_qty=array_count_values($_SESSION['cart_value']);
		$ex_qty=$cart_item_qty[$_REQUEST['id']];
		$ex_qty2=$ex_qty-1;
		$_SESSION['cart_value']=array_diff($c_values, array($_REQUEST['id']));
		for ($i = 1; $i <= $ex_qty2; $i++) {
			
		 $_SESSION['cart_value'][]=$_REQUEST['id'];	
		}
		//$_SESSION['cart_value'][]=array_splice( $c_values,0,$ex_qty2, $_REQUEST['id']);
		//$_SESSION['cart_value']=array_splice($c_values, array_search($_REQUEST['id'], $c_values ), 1);
	}//print_r($_SESSION['cart_value']);
}
if($_REQUEST['title']=='Cd'){
	if($_REQUEST['action']=='add'){
	$_SESSION['cartcd_value'][] = $_REQUEST['id'];
	}
	if($_REQUEST['action']=='sub'){
		$c_values=$_SESSION['cartcd_value'];
		$cart_item_qty=array_count_values($_SESSION['cartcd_value']);
		$ex_qty=$cart_item_qty[$_REQUEST['id']];
		$ex_qty2=$ex_qty-1;
		$_SESSION['cartcd_value']=array_diff($c_values, array($_REQUEST['id']));
		for ($i = 1; $i <= $ex_qty2; $i++) {
			
		 $_SESSION['cartcd_value'][]=$_REQUEST['id'];	
		}
		//$_SESSION['cart_value'][]=array_splice( $c_values,0,$ex_qty2, $_REQUEST['id']);
		//$_SESSION['cart_value']=array_splice($c_values, array_search($_REQUEST['id'], $c_values ), 1);
	}//print_r($_SESSION['cart_value']);	
}
echo '$'.$actual_price=$qty*$price;

?>