<?php 

$fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
$fetchmetacontent = @mysql_fetch_array($fetmetaquery);
$countinfo = @mysql_num_rows($fetmetaquery);

if($countinfo > 0)
{
  $meta_image = $fetchmetacontent['image'];
  $meta_description = $fetchmetacontent['description'];
}
else
{
  $meta_image = "images/mySittiLogo.jpg";
  $meta_description = "Making Every City Your City";
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="apple-mobile-web-app-capable" content="yes" />
<? //if($titleofpage){ ?>
<title><?php echo "mysittidev.com || ".$titleofpage ;?></title>
<!-- <meta property="fb:app_id" content="688073574590787" />
<meta property="og:url" content="http://mysittidev.com/" />
<meta property="og:site_name" content="mysittidev.com" /> -->
<?php
if(($_SERVER['SCRIPT_NAME'] != "/profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/private_zone.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/music_request.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/forum.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/home_user.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/musicrequestlist.php"))
{
	?>


<? } ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0" />
<link href="css/new_portal/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/jquery-1.11.0-beta2.js" language="javascript"></script>
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="css/new_portal/jquery.bxslider.css" />
<link rel="stylesheet" href="css/new_portal/animate.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!-- for html5 support ie8 -->
<script type="text/javascript"> 
document.createElement('header'); 
document.createElement('nav'); 
document.createElement('menu');  
document.createElement('section');  
document.createElement('article'); 
document.createElement('aside');  
document.createElement('footer'); 
</script>
<!-- End for html5 support ie8 -->
<!-- for header animation -->

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script type="text/javascript" src="js/chat.js"></script>
<!--/* light box */-->

<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" language="javascript"></script> -->
<script src="js/datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>
<!-- <script src="js/add.js"></script> -->



<!--for  responsive toggle menu -->
<!-- <script type="text/javascript">
// $(document).ready(function(){
//   $(".menu").click(function(){
//     $("nav").slideToggle();
//   });
//     $('#Search_box').hide().before('<a href="#" id="toggle-menu" class="menu">City<img src="images/new_portal/menu.png" alt="Menu" /></a>');

//    	$('a#toggle-menu').click(function (e) {
//        	e.preventDefault();
//        	$('#Search_box').slideToggle(200);
//    	});


// });
// </script>-->

<!-- end for toggle menu -->
<!-- for chat -->
<script language="javascript">           
 function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}

</script>
<script>
  function getMonthName(v) {
    var n = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return n[v]
}
    function get_event_by_month(){    
		jQuery("#loader").show();
		jQuery('#get_revrs_event_by_month').show();
		
		$curnt = (new Date).getMonth() + 1;
		$curnt_year=(new Date).getFullYear() ;

		$current_month=     jQuery('#current_month_for_venue').val();
		$current_month=parseInt($current_month);
		$current_month=$current_month+1;

		$current_year=     jQuery('#current_year_for_venue').val();
		$type_of_user=jQuery('#hostOruser').val();
		$hostid=jQuery('#hostid').val();
		
		jQuery('#current_month_for_venue').val($current_month);
  
  
   if($current_month==13){
	$current_month=1;   
	$curnt_year=jQuery('#current_year_for_venue').val();
	$curnt_year=parseInt($curnt_year);
	$curnt_year=$curnt_year+1;
	$current_year=parseInt($current_year)+1;
	jQuery('#current_month_for_venue').val($current_month);
	jQuery('#current_year_for_venue').val( $curnt_year);	
    }
     $type_of_user=jQuery('#hostOruser').val();
		$hostid=jQuery('#hostid').val();  
     $val= jQuery('#current_month_for_venue').val();
   $.ajax({
    type: "POST",
    url: "get_event_by_month.php",
    data:"month="+$val+"&year="+$current_year+"&hostOruser="+$type_of_user+"&hostid="+$hostid,
    success:  function(data){
    jQuery("#loader").hide();
        jQuery('#listvenue_tab').html(data);
        
    if($current_month==0){
		$name=  getMonthName($current_month);
	}else{
	$name=  getMonthName($current_month-1);
     }
	$curntyear= jQuery('#current_year_for_venue').val()
	jQuery('#date_month_venue').html($name+" "+$curntyear)
    }
   
    }); 
    
    }  
   function get_revrs_event_month(){
	
	var now = new Date();
	
	var full_year = now.getMonth() + 1;
	var get_value_month = $('#current_month_for_venue').val();
	var previous_month = get_value_month - 1;
	
	//alert(full_year);
	//alert(get_value_month);
	//
	//if (get_value_month == 1 && full_year == 12) {
	//  alert("first");
	//	$('#get_revrs_event_by_month').hide(); //code
	//}else if (full_year < get_value_month) {
	//	alert("second");
	//	$('#get_revrs_event_by_month').hide(); //code
	//}
	
	if (full_year == previous_month) {
	  //alert('if');
	  $('#get_revrs_event_by_month').hide();
	}else{
	  //alert('else');
	  $('#get_revrs_event_by_month').show();
	}

	   jQuery("#loader").show();
     $curnt = (new Date).getMonth() + 1;

        $curnt_year=(new Date).getFullYear() ;
        $current_month=     jQuery('#current_month_for_venue').val();         
        $current_year=     jQuery('#current_year_for_venue').val();

        	if( ($curnt != $current_month-1 )&& ( $curnt_year != $current_year) )
        	{

		$type_of_user=jQuery('#hostOruser').val();
		$hostid=jQuery('#hostid').val();
		$current_year=parseInt($current_year);
		$current_month=parseInt($current_month);  
	    	if($current_month==0 && $current_year!=$curnt_year) 
	    	{
		
			jQuery('#current_month_for_venue').val('12');
			jQuery('#current_year_for_venue').val( $current_year-1);
	  	}else if($current_month==1)
	  	{
			jQuery('#current_month_for_venue').val('12');
			jQuery('#current_year_for_venue').val( $current_year-1);
	 	}
	 	else
	 	{
	    		$current_month=$current_month-1;
        			jQuery('#current_month_for_venue').val($current_month);		
        		}
	  	$val= jQuery('#current_month_for_venue').val();
	    	$current_year=     jQuery('#current_year_for_venue').val();
		  
			
	   	$.ajax({
			type: "POST",
			url: "get_event_by_month.php",
			data:"rmonth="+$val+"&ryear="+$current_year+"&hostOruser="+$type_of_user+"&hostid="+$hostid,
			success:  function(data)
			{
				jQuery("#loader").hide();
				jQuery('#listvenue_tab').html(data);
				// window.location.reload(true);
				if($current_month==$curnt && $curnt_year==$current_year)
				{
					jQuery('#current_month_for_venue').val()==$curnt;
					jQuery('#get_revrs_event_by_month').hide();
				}	
				if($current_month==0)
				{
					$asd=11;
					$name=  getMonthName($asd);
					$current_y=$current_year-1;
					jQuery('#date_month_venue').html($name+" "+$current_y);
				}if($val==12)
				{
					$asd=11;
					$name=  getMonthName($asd);
					jQuery('#date_month_venue').html($name+" "+$current_year);
				}
				else
				{
					$name=  getMonthName($current_month-1);
					jQuery('#date_month_venue').html($name+" "+$current_year);
				}
			}
		});
    	}else if ($curnt == 1) {
		

		$type_of_user=jQuery('#hostOruser').val();
		$hostid=jQuery('#hostid').val();
		$current_year=parseInt($current_year);
		$current_month=parseInt($current_month);  
	    	if($current_month==0 && $current_year!=$curnt_year) 
	    	{
		
			jQuery('#current_month_for_venue').val('12');
			jQuery('#current_year_for_venue').val( $current_year-1);
	  	}else if($current_month==1)
	  	{
			jQuery('#current_month_for_venue').val('12');
			jQuery('#current_year_for_venue').val( $current_year-1);
	 	}
	 	else
	 	{
	    		$current_month=$current_month-1;
        			jQuery('#current_month_for_venue').val($current_month);		
        		}
	  	$val= jQuery('#current_month_for_venue').val();
	    	$current_year=     jQuery('#current_year_for_venue').val();
		  
			
	   	$.ajax({
			type: "POST",
			url: "get_event_by_month.php",
			data:"rmonth="+$val+"&ryear="+$current_year+"&hostOruser="+$type_of_user+"&hostid="+$hostid,
			success:  function(data)
			{
			  
				jQuery("#loader").hide();
				jQuery('#listvenue_tab').html(data);
				// window.location.reload(true);
				if($current_month==$curnt && $curnt_year==$current_year)
				{
				  
				  
					jQuery('#current_month_for_venue').val()==$curnt;
					jQuery('#get_revrs_event_by_month').hide();
				}	
				if($current_month==0)
				{
				  
					$asd=11;
					$name=  getMonthName($asd);
					$current_y=$current_year-1;
					jQuery('#date_month_venue').html($name+" "+$current_y);
				}if($val==12)
				{
				  

					$asd=11;
					$name=  getMonthName($asd);
					jQuery('#date_month_venue').html($name+" "+$current_year);
				}
				else
				{

				  
				  
					$name=  getMonthName($current_month-1);
					jQuery('#date_month_venue').html($name+" "+$current_year);
					//jQuery('#get_revrs_event_by_month').show();
				}

			}
		});
		}
    	else
    	{
		  alert("gjhjhj");
    		jQuery('#get_revrs_event_by_month').css('display','none');
    	}
    }
    </script>
   
</head>
<body>
<style type="text/css">

.main_home {
    margin: 10px auto auto;
}
@media only screen and  (max-width:1024px) {

#loading {width:100%; height:100%; margin:auto; position:fixed; left:0; top:0;background:rgba(0, 0, 0, 0.8); right:0; bottom:0; z-index:99999999999; } 
.wait {
  bottom: 0;
  height: 80px;
  left: 0;
  margin: auto;
  position: fixed;
  right: 0;
  top: 0;
  width: 80px;
  z-index: 2147483647;
  text-align: center;
  color: #fff;
}
}
</style>
<div id="loading"><div class="wait"><img src="images/loading.gif" alt="Loading"> <br />Loading..</div></div>
