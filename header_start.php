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
<html xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta name="ahrefs-site-verification" content="e50429e35aa0fa5ab3732ec89f118ae3efb55fce5d84b9311160c6c7af6b095c">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="apple-mobile-web-app-capable" content="yes" />

<?php
/*

if(($_SERVER['SCRIPT_NAME'] != "/profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/profile.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/private_zone.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/music_request.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/forum.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/home_user.php")
	&& ($_SERVER['SCRIPT_NAME'] != "/musicrequestlist.php"))
{
	?>


<meta property="og:title" content="<?php echo "Mysitti.com || Home"; ?>" />
<meta property="og:image" content="http://mysitti.com/<?php echo $meta_image; ?>" />
<meta property="og:description" content="<?php  echo $meta_description; ?>" />
<meta name="twitter:site:id" content="63359297" />
<meta name="twitter:card" content="summary" />
	<?php 

}



*/
?>
<!--script type="text/javascript" src="js/new_portal/smk-accordion.js"></script--> 


<? //} ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "149feadf-b97c-4052-a20e-b78764f1429e", popup: 'true'});</script>
<!--/* light box */-->

<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" language="javascript"></script> -->
<script src="js/datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>


<!-- end for toggle menu -->
<!-- for chat -->
<script>

 function ChkUserId(email,type)
{

	if(email!="")
	{
		
		ajaxFunction("ChkUserId.php?email_id="+email+"&type="+type, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var s = xmlhttp.responseText;

				if(s==0)
				{
					alert("The email address is already taken. Please choose another one2.");	
					if(type=='user')
					{
						document.signupd.email.value="";
						document.signupd.email.focus() ;
					}else{
						document.signupes.club_email.value="";
						document.signupes.club_email.focus() ;
					}
					return false;
				}

			}
		});
		
	}

}

 function ChkUserProfile(profilename,type)
{

	if(profilename!="")
	{
		
		ajaxFunction("ChkUserProfile.php?profilename="+profilename+"&type="+type, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var s = xmlhttp.responseText;

				if(s==0)
				{
					alert("The Username is not available.Please choose another.");	
					if(type=='user')
					{
						document.signupd.profilename.value="";
						document.signupd.profilename.focus() ;
					}else{
						document.signupes.club_name.value="";
						document.signupes.club_name.focus() ;
					}
					return false;
				}

			}
		});
		
	}

}



function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function checkAcknowledgement(frm){
  var checked = frm.acknowledgement.checked;
  if (!checked){
    alert('Please agree to the privacy policy.');
  }
  return checked;
}

function ajaxFunction(url,myReadyStateFunc)
{
   if (window.XMLHttpRequest)
   {
      // For IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   }
   else
   {
      // For IE5, IE6
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange= myReadyStateFunc;        // myReadyStateFunc = function
   xmlhttp.open("GET",url,true);
   xmlhttp.send();
}

function showState(x,id)
			{
				
			
            if(x=='223')
				{
					 $.get('getcity_sign.php?con=us', function(data) {
						
						 if(id=="state_id"){
					$('#cities').html(data);
				}if(id=="state_id_host"){
					$('#cities_host').html(data);
				}
					});
				}else
				{
					 $.get('getcity_sign.php?con=ca', function(data) {
						
					 if(id=="state_id"){
					$('#cities').html(data);
				}if(id=="state_id_host"){
					$('#cities_host').html(data);
				}
					});
				}
				ajaxFunction("getstate.php?country_id="+x, function()
				{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
				s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
				sid = s[0].split(",");  
				//  sid = [1,2,3,]
				sval = s[1].split(",");      
				//  sval = [state1, state2, state3,]
				st = document.getElementById(id);
				st.length=0; 
				for(i=0;i<sid.length-1;i++)
				{
				st[i] = new Option(sval[i],sid[i]);
				}              
				}
				});
				
			}

				
function other_city_show(val)
{
	
  if(val=='other')
  {
	 $('#other_c').show();
   }else
   {
	   $('#other_c').hide();
	 }
}
function other_city_show_host(val)
{
	
  if(val=='other')
  {
	 $('#other_c_host').show();
   }else
   {
	   $('#other_c_host').hide();
	 }
}
function getcity_host(x)
{	
$.get('getcity_sign.php?state_id='+x, function(data) {
$('#cities').html(data);
});
}
function getcity(x)
{
  alert('head');
$.get('getcity_sign.php?state_id='+x, function(data) {
$('#cities').html(data);
});
}
</script>
<script language="javascript" type="text/javascript">
  $(window).load(function() {
    $('#loading').hide();
	
  });
</script>
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');

</script>


<!--[if gte IE 9]>
<script type="text/javascript" src="placeholder_n.js"></script>
<![endif]-->

<!--[if gte IE 10]>
<script type="text/javascript" src="placeholder_n.js"></script>
<![endif]-->

<!--[if gte IE 11]>
<script type="text/javascript" src="placeholder_n.js"></script>
<![endif]-->

<!-- end for toggle menu -->
<style>
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
</head>
<body>
<div id="loading"><div class="wait"><img src="images/loading.gif" alt="Loading"><br />Loading..</div></div>
 

        
   
