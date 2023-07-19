<?
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
if(!$_SESSION['user_id'])
{
 header('location: login.php');exit;
}
?>

<?php 
 if(isset($_POST['submit']))
 {
  $cnd="id!='".$_SESSION['user_id']."'";
  if($_POST['country']!="")
  {
     $cnd .=" AND  country='".$_POST['country']."'";
  }
  if($_POST['state']!="")
  {
     $cnd .=" AND  state='".$_POST['state']."'";
  }
   if($_POST['city']!="")
  {
     $cnd .=" AND city='".$_POST['city']."'";
  }
  if($_POST['zipcode']!="")
  {
     $cnd .=" AND zipcode='".$_POST['zipcode']."'";
  }
 }else
 {
	$_POST['city']=
   $cnd="id!='".$_SESSION['user_id']."'";
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Live Host Cam</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


</head>

<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ?>
    <div id="wrapper" class="space">
       <div id="title">Live Host Cam</div>
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
            <li class="txt">State/ Province</li>
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
                  
				  <option value="<?php echo $row1["zone_id"]; ?>" <?php if($_POST['state']==$row1["zone_id"]) { ?> selected="selected" <?php } ?> ><?php echo $row1["name"]; ?></option>
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
                  
				  <option value="<?php echo $row_city["city_id"]; ?>" <?php if($_POST['city_name']==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
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
         <div class="advertise"><img src="images/advertise1.jpg" /></div>
       </div>
       <div id="right1">
	     <div id="user_content">
	    
		 	 <?php  $sql_u="select * from  user where ".$cnd." AND is_online='1'";
			$sql_all_u=mysql_query($sql_u);
			 $cnt=@mysql_num_rows($sql_all_u);
			 $i=0;
			 if($cnt > 0) {
			 while($online_u=mysql_fetch_array($sql_all_u)) { 
			  $username = $online_u['first_name'].$online_u['last_name']; 
			    $chk_u="select * from  cam_invite where created_by=".$_SESSION['user_id']." AND  sent_to=".$online_u['id']." OR(
				created_by=".$online_u['id']." AND  sent_to=".$_SESSION['user_id'].")";
		     	$chk_u_avl=mysql_query($chk_u);
				$is_inv=mysql_fetch_array($chk_u_avl)
			  ?>
		 <div class="user_box">
			 <?php if($online_u['image_nm']=="") {?>
		     <img src="images/user.jpg"  height="129" width="137"/>
			 <?php } else { ?>
			 <img src="<?php echo $online_u['image_nm']; ?>"  height="129" width="137"/>
			 <?php } ?>
		   <div class="name"><?php echo $username; ?></div>
		    <div class="btn" style="margin-top:8px;">
			 <?php if($is_inv['session'] > 0) { ?>
			<a href="camstart.php?session=<?php echo $is_inv['session'];?>&token=<?php echo $is_inv['token'];?>&sent_to=<?php  echo  $online_u['id'];?>" target="_blank" style="width:120px;" > Start Cam</a>
			 <?php }else { ?>
			<input type="button" value="View Web Cam" onclick="sendsession('<?php echo $online_u['id']; ?>');" style="width:120px;">
			<?php } ?>
			</div>
			
		 </div>
		<?php $i++;} } else {		?>
		<p align="center">There is no result found for your criteria</p>
		<?php }  ?>
		 </div>
		
	   </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
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

function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}
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
</html>
