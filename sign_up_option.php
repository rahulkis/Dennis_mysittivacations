<?php
include("Query.Inc.php");
$Obj = new Query($DBName) ;
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

$Obj->Redirect('index.php');
exit;

if($para!="");
{
	if($para=="duplicate")
	{
	$message="Already Registered With Entered Email ID. Try Another One";
	}
	if($para=="Captchaerror")
	{
	$message=" Please Enter Valid Captcha Code";
	}
	if($para=="failed")
	{
	$message=" Please Fill Proper Information";
	}
}

if(isset($_SESSION['user_id']))
{
$Obj->Redirect("index.php");
}
                $adv_left1 = @mysql_query("select * from `advertise` where page_name='registerl-left'");
				$advleft1 =@mysql_fetch_array($adv_left1) ; 
				$left_img1 =substr($advleft1['adv_img'],6);
				$left_afl1 =$advleft1['affiliate-code'];
				$left_adv_link1 = $advleft1['adv_link'];  
				
				$adv_left2 = @mysql_query("select * from `advertise` where page_name='registerl-right'");
				$advleft2 =@mysql_fetch_array($adv_left2) ; 
				$left_img2 =substr($advleft2['adv_img'],6);
				$left_adv_link2 = $advleft2['adv_link'];  
?>
<?php
if(isset($_POST['description'])){
	
$userID=$_SESSION['user_id'];
$eventname=$_POST['eventname'];
$eventDate=$_POST['eventDate'];
$description=$_POST['description'];
$date = date('Y-m-d H:i:s');

	
// CODE BY SUMIT

$postdate = trim($eventDate);

$postDate = str_replace("/","-",$eventDate);

$pdate = strtotime($postDate);

$curdate = date('d-m-Y');
$cdate = strtotime($curdate);


$eventDate = date('Y-m-d', $pdate);
if(trim($cdate) > trim($pdate)){
	
	$message['error'] = "Please select current or future date. ";
}else{

$sql = mysql_query("INSERT INTO `events` (`id`, `host_id`, `eventname`, `date`, `description`,`created_date`, `modified_date`)VALUES ('','$userID', '$eventname','$eventDate','$description','$date','$date')");
if($sql){
$_SESSION['eventadded']="yes";

$Obj->Redirect("listevent.php");
}else{
	
	$message['error'] = "Can not add event ";
}

}
}
  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 
<?
$titleofpage="Register Account";
include('headhost.php');
include('header.php');
?>
<script type="text/javascript">
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>

<script type="text/javascript">

function checkAcknowledgement(frm){
  var checked = frm.acknowledgement.checked;
  if (!checked){
    alert('Please agree to the privacy policy.');
  }
  return checked;
}

</script>


<script language="javascript" type="text/javascript">
var xmlhttp;
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
function showState(x)
{
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
              st = document.getElementById('state');
			    st.length=0; 
              for(i=0;i<sid.length-1;i++)
             {
              st[i] = new Option(sval[i],sid[i]);
              }              
        }
	});
}
function ChkUserId(email)
{

if(email!=""){
 ajaxFunction("ChkUserId.php?email_id="+email, function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
             var s = xmlhttp.responseText;
			 
			 if(s==0)
			 {
			 alert("Already Registered With Entered Email ID. Try Another One ");			 
			 document.signup.email.value="";
             document.signup.email.focus() ;
   			 return false;
			 }
             
        }
	});
}
}
</script>
<?PHP 
/***************************************************************************/
    FUNCTION DateSelector($useDate=0) 
    { 
			$months = array ('select','January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 
			'December');
			$days = range (1, 31);
			$years = range (1951, DATE("Y"));
			
			
			echo "<select name='date' style='width:75px;'>";
			echo '<option value="Select"> Select</option>\n';
			foreach ($days as $value) {
					echo '<option value="'.$value.'">'.$value.'</option>\n';
			}
			 echo '</select> &nbsp; ';
			
				echo "<select name='month' style='width:100px;'>";
				echo '<option value="Select"> Select</option>\n';
	            for ($month = 0; $month <= 12; $month++) 
				{
					echo '<option value="'.$month.'">'.$months[$month].'</option>\n';
				}
			echo '</select> &nbsp; ';
			
			
			echo "<select name='year' style='width:80px;'>";
			echo '<option value="Select"> Select</option>\n';
			foreach ($years as $value) {
					echo '<option value="'.$value.'">'.$value.'</option>\n';
			}  
			echo '</select> &nbsp; ';
    
    } 
?> 
<style>
.signupoptionhosttype
{
	background: none repeat scroll 0 0 #d0d0d0;
    .border: 1px solid #808080;
    margin-top: 10px;
    min-height: 300px;
    min-width: 300px;Obj
    }
.signupoptioncont {
  background: none repeat scroll 0 0 black;
  clear: both;
  float: right;
}
	
	
	
</style>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Select your account type</h2>
					<?php if($message){ 

					echo '<div id="successmessage" class="message" >'.$message."</div>";
					}
				?>
					<div class="login" style="float:left; width:50%; margin: 20% 30%;">
						<a class="button" href="sociallogin.php?type=user">Standard User</a>
						<a id="hostPlansuo" href="sociallogin.php?type=host" class="button" > Host</a>
						<!-- <a class="button" href="sign_up.php?plan=free#tabs1-html">Standard User</a>
						<a id="hostPlansuo" href="sign_up.php?plan=host_free#tabs1-js" class="button" > Host</a> -->
						<div style="clear:both;"></div>
					
					</div>
			</div>
	 	</div> 
	</div>
</div>
<?
include('footer.php');
?>


