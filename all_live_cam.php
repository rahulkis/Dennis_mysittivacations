<?
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
if(!$_SESSION['user_id'])
{
 header('location: login.php');
 exit;
}
?>

<?php 


 if(isset($_POST['submit']))
 {
  $cnd="id!='".$_SESSION['user_id']."'";
  if(trim($_POST['country'])!="")
  {
     $cnd .=" AND  club_country='".$_POST['country']."'";
  }
  if(trim($_POST['state'])!="")
  {
     $cnd .=" AND  club_state='".$_POST['state']."'";
	 $state=$_POST['state'];
  }
   if(trim($_POST['city'])!="")
  {
     $cnd .=" AND club_city='".$_POST['city']."'";
	 $_SESSION['id']=$_POST['city'];
	  $city=$_POST['city'];
  }
  if(trim($_POST['zipcode'])!="")
  {
     $cnd .=" AND zip_code='".$_POST['zipcode']."'";
  }
 }
 else
 { 
    $city=$_SESSION['id'];
	$state=$_SESSION['state'];
   $cnd="id!='".$_SESSION['user_id']."' AND club_city='".$city."' ";
  }

?>

<script>
function changecity(val)
{
$.get('set-session.php?city_id='+val, function(data) {
window.location='all_live_cam.php';
});
}
function changecity2()
		{
		val=$('#city_name').val();
		$.get('set-session.php?city_id='+val, function(data) {
		window.location='all_live_cam.php';
		});
		}
//function getcity(x)
//{
//$.get('getcity.php?state_id='+x, function(data) {
//$('#city_name').html(data);
//});
//}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');


function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}

</script>

<script type="text/javascript">
	function goto1(url)
	{
		window.open(url,'1396358792239','width=900,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
		return false;
	}
</script>


    <?php 
$titleofpage="Live Host Cam";
 include('headhost.php'); 
include('header.php');

?>

 <div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
       <div id="title" class="botmbordr">Live Host Cam
       <span style="">
	
         <?php echo $row_city_name['city_name']; ?> , <?php echo $row_state['code']; ?>
	   </span>
       </div>
	   <!---
       <div id="left">
         <div class="browse" style="margin-top:30px;">
		  <h1>Browse:</h1>
		        <form name="user_serach" action="" method="post">
			<div id="cam_search">
          <ul>
            <li class="txt">Country</li>
             <?php 
		 $countrysql="select country_id,name from country";
		 $country_list = mysql_query($countrysql);
		// $row["country_id"];
		 ?>
             <li><select name="country" id="country" onChange="showState(this.value);">
             <option value="">- - Select - -</option>
             <?php 
				while($row = mysql_fetch_array($country_list))
				{
				  if($row["country_id"] == 223)
				  {
				  ?>
                  <option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
                  <?php
				  }
				  else
				  {
					  ?>
                  
				  <option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
				   <?php
				   }
				}
				   ?>
                </select>
             </li>
            <li class="txt">States</li>
            <li><select name="state" id="state" onfocus="return validate_country();" onchange="getcity(this.value);">
            <option value="">- -Select- -</option>
              <?php 
		 $countrysql1="select zone_id,name from zone where country_id=223";
		 $country_list1 = mysql_query($countrysql1);
		 ?>
         
          <?php 
				while($row1 = mysql_fetch_array($country_list1))
				{
				  ?>
                  
				  <option value="<?php echo $row1["zone_id"]; ?>" <?php if($state==$row1["zone_id"]) { ?> selected="selected" <?php } ?> ><?php echo $row1["name"]; ?></option>
				   <?php
				   }
				
				   ?>
                </select>
            
            </select></li>
            <li class="txt">City</li>
		
			   <li><select name="city_name" id="city_name" >
            <option value="">- -Select- -</option>
              <?php 
		$allcity="select city_name,city_id from capital_city"; 
		 $city_list1 = mysql_query($allcity);
		 ?>
         
          <?php 
				while($row_city = mysql_fetch_array($city_list1))
				{
				  ?>
                  
				  <option value="<?php echo $row_city["city_id"]; ?>" <?php if($city==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
				   <?php
				   }
				
				   ?>
                </select>
            
            </select></li>
           
            <li class="txt">OR</li>
            <li class="txt">Zip Code</li>
            <li><input name="zipcode" value="<?php echo $_POST['zipcode'];?>"  type="text" /></li>
            <li class="txt"></li>
            <li><input type="submit" value="Search" name="submit" id="submit" /></li>
          </ul>
        </form>
      </div>
		 
		 
		 </div>
		<? 	$adv_sql2 = @mysql_query("select * from `advertise` where page_name='cam'");
	$advArray2 =@mysql_fetch_array($adv_sql2) ; 
	$adv_img2= substr($advArray2['adv_img'],6); 
	$adv_link2= $advArray2['adv_link']; 
	?>
         <div class="advertise"><img src="<?php echo $adv_img2; ?>" /></div>
       </div>
	   -->
       <div id="right1">
	     <div id="user_content" class="user-launch all_live_cam">
	    
		 	 <?php 
			 $sql_u="select * from  clubs where ".$cnd." AND is_launch='1' ";
			 //echo $sql_u;
			$sql_all_u=mysql_query($sql_u);
			 $cnt=@mysql_num_rows($sql_all_u);
			 $i=0;
			 if($cnt > 0) {
			 while($online_u=mysql_fetch_array($sql_all_u)) { 
			  $username = $online_u['club_name'];
			   
			    $chk_u="select * from  cam_invite where created_by=".$_SESSION['user_id']." AND  sent_to=".$online_u['id']." OR(
				created_by=".$online_u['id']." AND  sent_to=".$_SESSION['user_id'].")";
		     	$chk_u_avl=mysql_query($chk_u);
				$is_inv=mysql_fetch_array($chk_u_avl);

				$checksub = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$username."' ");
				$countchecksub = @mysql_num_rows($checksub);
				$getres = @mysql_fetch_array($checksub);
				if($countchecksub > 0)
				{
					$gethostowner = @mysql_query("SELECT * FROM `clubs` WHERE id = '".$getres['host_id']."' ");
					$gethostname = @mysql_fetch_array($gethostowner);
					//$username = $gethostname['club_name']."-".$getres['username'];
					$username = $getres['username'];
				}
				else
				{
					$username = $username;
				}


			  ?>
		 <div class="user_box">
			 <?php if($online_u['image_nm']=="") {?>
		     <img src="images/user.jpg"  height="129" width="137"/>
			 <?php } else { ?>
			 <img src="<?php echo $online_u['image_nm']; ?>"  height="129" width="137"/>
			 <?php } ?>
		   <div class="name" style="text-align: center;">
		   <?php 
		   		echo $username; 
				$pieces = explode(" ", $username);
				$username_dash_separated = implode("-", $pieces);
				$username_dash_separated = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '', $username_dash_separated);
				
			?></div>
		    <div class="user_webcam" style="margin-top:8px;">
		 
		    <?php
		    

  
$mobile = detect_mobile();
if($mobile === true) { 
?>
 <a class="button" onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')"  href="javascript:void(0);"  style="width:120px;" > Live Streaming</a>

<? } else { ?>

<a class="button" onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>')"  href="javascript:void(0);"  style="width:120px;" > Live Streaming</a>

<?php } ?>

		    
		    
		  
			
			</div>
			
		 </div>
		<?php $i++;} } else {		?>
		<p align="center" style=" color: white; font-size: 16px;">Currently there is no club broadcasting their webcam.</p>
		<?php }  ?>
		 </div>
		
	   </div>
    </div>
   </div> 
    </div>
    </div>
    </div>
    </div>
    <?php include('footer.php') ?>

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

//function getcity(x)
//{
//$.get('getcity.php?state_id='+x, function(data) {
//$('#city_name').html(data);
//});
//}
</script>
<script type="text/javascript">
function validate_country(){
if( document.user_serach.country.value== "" )
   {
		alert( "Please provide country!" );
     	document.user_serach.country.focus() ;
     	return false;   
	}	
	
	
}
function sendsession(id)
{ 
 $.get('send-invite.php?user_id='+id, function(data) {
  window.location='live_cam.php';
});

}

</script> 
