<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysittivacations.com ||<?php echo $titleofpage; ?></title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<title>Mysittivacations |  Other Terms & Conditions</title>
<link rel="stylesheet" type="text/css" href="<?php echo $SiteURL;?>css/v2style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $SiteURL;?>slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $SiteURL;?>slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $SiteURL;?>slider2/css/custom.css" />
<script src="<?php echo $SiteURL;?>slider2/js/modernizr.custom.17475.js"></script>
<script src="<?php echo $SiteURL;?>js_validation/signup.js" type="text/javascript"></script>
<?php
 $sql = "select * from `pages` where page_name like '%Other Terms & Conditions%'";
 $policyArray = $Obj->select($sql) ; 
 $policy=$policyArray[0]['page_data'];
 ?>

</head>
<style type="text/css">
  .content_txt {
	float: left;  
	text-align: justify;
	width: 100%;
}

.content_txt a
{
	color: #1c50b3;
}
h3#title {
  background: #1c50b3;
   color: #fff;
  float: left;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 10px;
  margin-top: 20px;
  padding: 10px 0;
  text-align: center;
  width: 100%;
}
body
{
	background: #fff;
}
</style>
<body>
<div id="main">
	
		
		<div id="wrapper" class="space policy">
			  
				   <div class="v2_container">
 <h3 id="title"> Other Terms & Conditions</h3>
					   <div class="" style=" color: #333 !important;">
						 <p><?php echo $policy; ?></p>
					   </div>
				   </div>
			   </div>
		   </div>
	   </div>
   
</div>
</body>
</html>
