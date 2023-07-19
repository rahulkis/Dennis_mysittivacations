<?
// SANDBOX API
		// $LOGINKEY = '5R7hq33ZZf6';// x_login
		// $TRANSKEY = '8DfKq6p6XN564s49';//x_tran_key

// LIVE API
		$LOGINKEY = '84nnqA8Jq';// x_login
		$TRANSKEY = '7N2tMCpMM28d659C';//x_tran_key

		
		$firstName =urlencode( $_POST['firstname']);
		$upgradeorfresh =$_POST['upgradeorfresh'];
		$contid=$_POST['contid'];
		$lastName =urlencode($_POST['lastname']);
		$creditCardType =urlencode( $_POST['cardtype']);
		$creditCardNumber = urlencode($_POST['cardnumber']);
		$expDateMonth =urlencode( $_POST['cardmonth']);		
		// Month must be padded with leading zero
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);		
		$expDateYear =urlencode( $_POST['cardyear']);
		$cvv2Number = urlencode($_POST['cardcvv']);
		$address1 = urlencode($_POST['address']);
		$city = urlencode($_POST['city']);
		$state =urlencode( $_POST['state']);
		$zip = urlencode($_POST['zip']);
		//give the actual amount below
		$amount = urlencode($_POST['amount']);
		$currencyCode="USD";
		$paymentType="Sale";
		$date = $expDateMonth.$expDateYear;
		
	$post_values = array(
	 	"x_login"			=> "$LOGINKEY",
		"x_tran_key"		=> "$TRANSKEY",
	 	"x_version"			=> "3.1",
		"x_delim_data"		=> "TRUE",
		"x_delim_char"		=> "|",
		"x_relay_response"	=> "FALSE",
		"x_market_type"		=> "2",
		"x_device_type"		=> "1",
	  	"x_type"			=> "AUTH_CAPTURE",
		"x_method"			=> "CC",
		"x_card_num"		=> $creditCardNumber,
		//"x_exp_date"		=> "0115",
		"x_exp_date"		=> $date,
	 	"x_amount"			=> $amount,
		//"x_description"		=> "Sample Transaction",
	 	"x_first_name"		=> $firstName,
		"x_last_name"		=> $lastName,
		"x_address"			=> $address1,
		"x_state"			=> $state,
		"x_response_format"	=> "1",
	 	"x_zip"				=> $zip
		// Additional fields can be added here as outlined in the AIM integration
		// guide at: http://developer.authorize.net
	);
	
	//echo '<pre>'; echo 'Request values'; print_r($post_values);
	//comment the above line. i have given this just for testing purpose.

	$post_string = "";
	foreach( $post_values as $key => $value )$post_string .= "$key=" . urlencode( $value ) . "&";
	$post_string = rtrim($post_string,"& ");

	//for test mode use the followin url
	//$post_url = "https://test.authorize.net/gateway/transact.dll";
	//for live use this url
	$post_url = "https://secure.authorize.net/gateway/transact.dll"; 

	$request = curl_init($post_url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
	// curl_setopt($handle, CURLOPT_SSLVERSION, 1);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
	$post_response = curl_exec($request); // execute curl post and store results in $post_response
	// additional options may be required depending upon your server configuration
	// you can find documentation on curl options at http://www.php.net/curl_setopt
	curl_close ($request); // close curl object

	// This line takes the response and breaks it into an array using the specified delimiting character
	$response_array = explode($post_values["x_delim_char"],$post_response);

	//echo '<br><br> Response Array'; print_r($response_array);
	//remove this line. i have used this just print the response array

	if($response_array[0]==2||$response_array[0]==3) 
	{
		//success 
				echo '<b>Payment Failure</b>. <br>';
		echo '<b>Error String</b>: '.$response_array[3];
		echo '<br><br>Press back button to go back to the previous page';
		
	}
	else
	{
		///echo "<pre>";print_r($response_array);die;
		$ptid = $response_array[6];
		$paymentStatus = $response_array[3];
		if($response_array[3]=="This transaction has been approved" && $upgradeorfresh=='largecontest'){
			//echo "1234".$response_array[3].$upgradeorfresh;
			//$Obj->Redirect('http://'.$_SERVER['HTTP_HOST'].'/contestForm.php?id='.$contid);	
		}//echo "123a".$response_array[3].$upgradeorfresh;
		$ptidmd5 = $response_array[7];
		
	}
?>
