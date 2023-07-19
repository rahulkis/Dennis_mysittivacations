<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
 $userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}

if(isset($userID))
{
//include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Profile</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script src="js_validation/add_user.js" type="text/javascript"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js_validation/update.js" type="text/javascript"></script>
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
<script>
$(function() {
$( "#datepicker" ).datepicker({
changeMonth: true,

changeYear: true
});
});
</script>
<style>
#profile_box ul li{
padding-bottom:15px;
color:#888787;
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
width:282px;
display:table-cell;
}
</style>
<!--/*******************************-->
<?PHP 

    FUNCTION DateSelector($useDate=0) 
    { 
			$months = array ('select','January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 
			
			'December');
			$days = range (0, 31);
			$years = range (1951, DATE("Y"));
			$userID=$_SESSION['user_id'];
			$sqldate=mysql_query("select DOB from user where id='".$userID."'") or die(mysql_error());
			$userArraydate = mysql_fetch_array($sqldate);
	 		$dob1= $userArraydate['DOB'];
	 $date_array=explode("-",$dob1);
	 
	 $dobday =INTVAL($date_array[2]);
	 $dobYear=INTVAL($date_array[0]);
	  $dobMonth=INTVAL($date_array[1]);
			
			echo "<select name='date' style='width:75px;'>";
			foreach ($days as $value) {

				if($value==$dobday){
					 $default = 'selected="selected"'; 
					echo '<option '.$default.' value="'.$value.'">'.$value.'</option>\n';
				}
				else{
					echo '<option value="'.$value.'">'.$value.'</option>\n';
				}
			}
			 echo '</select> &nbsp; ';
			
				echo "<select name='month' style='width:100px;'>";
	            for ($month = 0; $month <= 12; $month++) 
				{
					if($month==$dobMonth){ $default = 'selected="selected"';
	               echo ' <option '.$default.' value="' . $month . '">' . $months[$month] . '</option>'."\n";
           			 }
					 else{
					echo '<option value="'.$month.'">'.$months[$month].'</option>\n';
					}
				}
			echo '</select> &nbsp; ';
			
			
			echo "<select name='year' style='width:80px;'>";
			foreach ($years as $value) {
				if($value == $dobYear){ $default = 'selected="selected"';
				echo '<option '.$default.' value="'.$value.'">'.$value.'</option>\n';
			}
			else{
					echo '<option value="'.$value.'">'.$value.'</option>\n';
				}
			}  
			echo '</select> &nbsp; ';
    
    } 
?> 
<!--/***************************************************-->









<?php
  if($_POST['update'])
  {
	$dateofbirth =$_POST['year']."-".$_POST['month']."-".$_POST['date'];
	
/***************************imageupload*/
if($_FILES["profile_image"]["name"]!="")
{
 	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["profile_image"]["name"]);
	$extension = end($temp);
	
	if ((($_FILES["profile_image"]["type"] == "image/gif")
	|| ($_FILES["profile_image"]["type"] == "image/jpeg")
	|| ($_FILES["profile_image"]["type"] == "image/jpg")
	|| ($_FILES["profile_image"]["type"] == "image/png"))
	&& in_array($extension, $allowedExts))
  {
  if ($_FILES["profile_image"]["error"] > 0)
    {
    echo "Error: " . $_FILES["profile_image"]["error"] . "<br>";
    }
  else
    {
    /*echo "Upload: " . $_FILES["profile_image"]["name"] . "<br>";
    echo "Type: " . $_FILES["profile_image"]["type"] . "<br>";
    echo "Size: " . ($_FILES["profile_image"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["profile_image"]["tmp_name"];
	*/
	$name = $_FILES["profile_image"]["name"];
	$tmp = $_FILES["profile_image"]["tmp_name"];
	$path = "upload/".time().strtotime(date("Y-m-d")).$name;
	move_uploaded_file($tmp,$path);	
    }
  }
else
  {
  $Obj->Redirect("profile.php?msg=imagefail");
  }
}
/***********/

    if($_POST['fname'] ==""){ $first_name=" "; } else { $first_name=trim($_POST['fname']); };
	if($_POST['lname'] ==""){ $last_name=" "; } else { $last_name=trim($_POST['lname']); };
	if($_POST['country'] ==""){ $country=" "; } else { $country=trim($_POST['country']); };
	if($_POST['phone'] ==""){ $phone=" "; } else { $phone=trim($_POST['phone']); };
	if($dateofbirth ==""){ $dob="0000-00-00"; } else { $dob=$dateofbirth; };
	if($_POST['state'] ==""){ $state=" "; } else { $state=trim($_POST['state']); };
	if($_POST['city'] ==""){ $city=" "; } else { $city=trim($_POST['city']); };
	if($_POST['zipcode'] ==""){ $zipcode=" "; } else { $zipcode=trim($_POST['zipcode']); };
	if($_POST['email'] ==""){ $email=" "; } else { $email=trim($_POST['email']); };
	if($_POST['password'] ==""){ $password=" "; } else { $password=trim($_POST['password']); };
	
	if($_FILES["profile_image"]["name"]!="")
	  {
	 $update_sql="update user set first_name='".$first_name."',last_name='".$last_name."',country='".$country."',email='".$email."',city='".$city."',state='".$state."',DOB='".$dob."',zipcode='".$zipcode."',image_nm='".$path."',phone='".$phone."' where id='".$userID."'";
	}
	else
	{
	 $update_sql="update user set first_name='".$first_name."',last_name='".$last_name."',country='".$country."',email='".$email."',city='".$city."',state='".$state."',DOB='".$dob."',zipcode='".$zipcode."',phone='".$phone."' where id='".$userID."'";
	
	}

		 $update= mysql_query($update_sql);
		 $Obj->Redirect("profile.php?msg=success");
  }
  
  /******************/
 $sql = "select * from `user` where `id` = '".$userID."'";
 $userArray = $Obj->select($sql) ; 
  $first_name=$userArray[0]['first_name']; 
  $last_name=$userArray[0]['last_name'];
  $zipcode=$userArray[0]['zipcode'];
  $state=$userArray[0]['state'];
  $country=$userArray[0]['country'];
  if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
  $city=$userArray[0]['city'];
  $email=$userArray[0]['email'];
  $image_nm=$userArray[0]['image_nm'];
  $phone=$userArray[0]['phone'];
  
?> 

</head>

<body>
<div id="main">
    <div class="container">
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
    <form name="update_user" method="post" onsubmit="return updateuservalidate();" enctype="multipart/form-data">
       <div id="title">Profile</div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
	 if($image_nm!="")
	 {
      ?>
       <div id="pic2">
       <img src="<?php echo $image_nm; ?>" height="157" width="135" /><br />
     <?php } else { ?>
     <div id="pic2"><img src="images/man4.jpg" /><br />
     <?php } ?>	
     
     
        <input type="file" name="profile_image" id="selectedFile" style="display: none;" />
      <!--  <input type="button" value="Browse..." onclick="document.getElementById('selectedFile').click();" /> --->
         <br/>
         <a href="edit_profile.php">Edit Profile </a> <br/>
           
           <a href="upload_photo.php"> Upload Photos <a/><br/>
           <a href="upload_video.php"> Upload Video <a/> 
        </div>
          
       <div id="profile_box">
         <ul>
           <li>Profile Name:</li>
           <li><input name="pname" type="text" value="<?php echo ucfirst($first_name)." ".ucfirst($last_name); ?>" /></li>
         </ul>
         <ul>
           <li>First Name / Company Name:</li>
           <li><input name="fname" type="text" value="<?php echo ucfirst($first_name); ?>" /></li>
         </ul>
         <ul>  
           <li>Last Name:</li>
           <li><input name="lname" type="text" value="<? echo ucfirst($last_name); ?>" /></li>
         </ul>
          <ul>  
           <li>Email:</li>
           <li><input name="email" readonly="readonly" type="text" value="<? echo $email; ?>" /></li>
         </ul>
          <ul>  
           <li>Phone:</li>
           <li><input name="phone"  type="text" value="<? echo $phone; ?>" /></li>
         </ul>
          
        <ul>
           <li>Date of Birth:</li>
           <li><?PHP DateSelector(); ?> </li>
         </ul>
         <ul>
            <?php 
		 $countrysql="select country_id,name from country";
		 $country_list = mysql_query($countrysql);
		 
		 ?>
             <li>Country:</li>
             <li><select name="country" id="country" onChange="showState(this.value);">
             <option value="">- - Select - -</option>
             <?php 
          $country_nm_qry = mysql_query("SELECT `name` FROM `country` WHERE `country_id` = ".$row['country']." ORDER BY `name` ASC");
		  $country_nm = mysql_fetch_array($country_nm_qry);
		  $state_nm_qry = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = ".$row['state']." ORDER BY `name` ASC");
		  $state_nm = mysql_fetch_array($state_nm_qry);
		  
				while($row = mysql_fetch_array($country_list))
				{
				  ?>
				  <option value="<?php echo $row["country_id"]; ?>"
                   <?php if($row["country_id"]==$country) { echo "Selected"; } ?>><?php echo $row["name"]; ?></option>
				   <?php
				   }
				   ?>
                </select>
             </li>
         </ul>
         <ul>
           <li>State: </li>
           <?
            $statesql=mysql_query("select name,zone_id from zone where country_id ='".$country."'");
			?>
             <li><select name="state" id="state" onchange="getcity(this.value);">
            
			<option   value= "">- - Select - -</option> 
		<?php	while($row_s = mysql_fetch_array($statesql))
				{
				  ?>
				  <option value="<?php echo $row_s["zone_id"]; ?>"
                   <?php if($row_s["zone_id"]==$state) { echo "Selected"; } ?>><?php echo $row_s["name"]; ?></option>
				   <?php
				}
				   ?>
             </select>   
             </li>
         </ul>
         <ul>
           <li class="txt">City</li>
		
			   <li><select name="city" id="city_name" >
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
         </ul>
         <ul>
           <li>Zipcode:</li>
           <li><input name="zipcode" type="text" value="<? echo $zipcode; ?>" /></li>
         </ul>
          <ul>
           <li>Profile Image:</li>
           <li> <input type="file" name="profile_image" id="selectedFile"  /></li>
         </ul>
        <div id="submit_btn"><input name="update" type="submit" value="Submit" />
        
    </form>
    </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
<?php
}
else
{
$Obj->Redirect("index.php");
}
?>