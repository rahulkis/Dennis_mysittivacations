<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/"; ?>
<script src="<?php echo $SiteURL; ?>js/custom.js"></script>
<?php
$manyTeam = trim($_POST['manyTeam']); // for click in sports image icon
$formatedcity = trim($_POST['formatedcity']);
$sitti = explode(",", $formatedcity);

	$sitt = $sitti[0];
	if($sitt == "Washington") {
	$sitthy = "washington-dc";
	$sittsp = "washington%20dc";
	} else {
		$sitthy = str_replace(' ', '-', strtolower($sitti[0]));
		$sittsp = str_replace(' ', '%20', strtolower($sitti[0]));
		$sitttn = str_replace(' ', '', $sitti[1]);
	}

$sqlTeam = "SELECT * FROM `sportsTeam` WHERE state_code = '".$sitttn."' OR state_name = '".$sitt."'";
$teamResult = mysql_query($sqlTeam);

while($teamRow = mysql_fetch_assoc($teamResult))
{
	$teamPart = explode(",", trim($teamRow[$manyTeam]));
	$stateName = $teamRow['state_name'];
}




$teamwith = trim($_POST['teamValue']); // for search box in sidebar
$checkw = substr_count($teamwith, '-');
if($checkw == 1)
{

	$res = explode(" - ", $teamwith);
	$teamValue = $res[1];

} else {
	$teamValue = $teamwith;
}




$firstd = $_POST['da1']; // for date range filter
$secd = $_POST['da2'];



$datecin=date_create($firstd);

$date1 = date_format($datecin,"Y-m-d");

$dateout=date_create($secd);

$date2 = date_format($dateout,"Y-m-d");


$datacity  = $_POST['teamnm'];
$city  = trim($datacity);


$teamnmme = $_POST['teamnm']; // for sidebar team list
if($teamnmme == 'Chicago Cubs'){
	$teamnmme = 'Chicago Cubs Baseball Apparels';
}else if($teamnmme == 'Chicago Fire'){
   $teamnmme = 'Chicago Fire Soccer Apparels';	
}else{
   $teamnmme = $_POST['teamnm']; // for sidebar team list
}

$teamnm = trim($teamnmme);


$value = $_POST['deal1']; // Main search box from banner
	$exp = explode(",", $value);

	$cy = $exp[0];
	if($cy == "Washington") {
	$cyhy = "washington-dc";
	$cysp = "washington%20dc";
	} else {
		$cyhy = str_replace(' ', '-', strtolower($exp[0]));
		$cysp = str_replace(' ', '%20', strtolower($exp[0]));
		$tn = str_replace(' ', '', $exp[1]);
	}

$start=0;
$limit = 30;
	// if(isset($_GET['page']))
	// {
	// $page = $_GET['page'];
	// $start = ($page-1)*$limit;
	// }
	
		// Your Access Key ID, as taken from the Your Account page
		$access_key_id = "AKIAJQAN4KM4OYIJI5LQ";

		// Your Secret Key corresponding to the above ID, as taken from the Your Account page
		$secret_key = "ijyb48jW7pYQhRgblos6XLPM+TA1c54tPbRuKh3t";

		// The region you are interested in
		$endpoint = "webservices.amazon.com";

		$uri = "/onca/xml";
		if(!empty($value))
		{
			$params = array(
			    "Service" => "AWSECommerceService",
			    "Operation" => "ItemSearch",
			    "AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
			    "AssociateTag" => "348905mysitti-20",
			    "SearchIndex" => "All",
			    "Keywords" => "$cy NBA",
			    "ResponseGroup" => "Images,ItemAttributes,Offers"
			);
		} elseif (!empty($teamnm)) 
		{
			$params = array(
			    "Service" => "AWSECommerceService",
			    "Operation" => "ItemSearch",
			    "AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
			    "AssociateTag" => "348905mysitti-20",
			    "SearchIndex" => "All",
			    "Keywords" => "$teamnm",
			    "ResponseGroup" => "Images,ItemAttributes,Offers"
			);
		} elseif (!empty($teamValue)) {
			$params = array(
			    "Service" => "AWSECommerceService",
			    "Operation" => "ItemSearch",
			    "AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
			    "AssociateTag" => "348905mysitti-20",
			    "SearchIndex" => "All",
			    "Keywords" => "$teamValue",
			    "ResponseGroup" => "Images,ItemAttributes,Offers"
			);
		} elseif(!empty($city)){
			$params = array(
			    "Service" => "AWSECommerceService",
			    "Operation" => "ItemSearch",
			    "AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
			    "AssociateTag" => "348905mysitti-20",
			    "SearchIndex" => "All",
			    "Keywords" => "$city",
			    "ResponseGroup" => "Images,ItemAttributes,Offers"
			);
		}

		// Set current timestamp if not set
		if (!isset($params["Timestamp"])) {
		    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
		}

		// Sort the parameters by key
		ksort($params);

		$pairs = array();

		foreach ($params as $key => $value) {
		    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

		// Generate the signed URL
		$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

		$pxml = simplexml_load_file($request_url);


		
		$html = "<div class='row bxslider-deals'>";
		

	    foreach ($pxml->Items->Item as $value) 
	    {
	    
	    	$html .= "<li class='col-md-4 col-sm-4 col-xs-12 b_oder'>
						<div class='m_1'>		 
							<a href='".$value->DetailPageURL."' target='_blank'><img src="; 
									if($value->MediumImage->URL) {
										$html .= $value->MediumImage->URL;
									} else {
										$html .= "http://webservices.amazon.com/scratchpad/assets/images/amazon-no-image.jpg"; 
										}
									$html .= "></a>
						</div>
					
						<div class='s_l'>
							<h3 class='up'><a href='".$value->DetailPageURL."' target='_blank'>";
							$tournamelen = $value->ItemAttributes->Title; 
							$out = strlen($tournamelen) > 44 ? substr($tournamelen,0,44)."..." : $tournamelen;
							$html .= $out;
							$html .= "</a></h3>
							<h3 class='pr-i'>";
							
										if($value->ItemAttributes->ListPrice->FormattedPrice)
										{
											$html .= $value->ItemAttributes->ListPrice->FormattedPrice;
										} else {
											$html .= 'N/A';
										}
								$html .= "</h3>
						</div>
					</li>";
			}
  		$html .= "</div>";
    	echo $html;
    	
    	
?>
