<?php
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="duplicate")
	{
	$message="The email address is already taken. Please choose another one.";
	}
	if($para=="Captchaerror")
	{
	$message=" Please enter a valid CAPTCHA value.";
	}
	if($para=="failed")
	{
	$message="Please fill in the form with proper information.";
	}
}
include("Query.Inc.php");
$Obj = new Query($DBName) ;
if(isset($_SESSION['user_id']))
{
$Obj->Redirect("index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HOST Member Signup</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src='js/jquery.validate.js'></script>
<!-- <script src="js_validation/signup.js" type="text/javascript"></script> --->
 <script src="js/register.js" type="text/javascript"></script> 


<script type="text/javascript">
$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<style>        
			#mask {
			position:fixed;
			left:0;
			top:0;
			z-index:500;
			background-color:#000;
			display:none;
			}
			
			.window {
			position:fixed;
			left:0;
			top:0;
			display:none;
			z-index:9000;
			padding:20px;
			height: 450px;
			width: 450px;
			border: 5px solid  #06F;
			background-color:#FFF;
			
			}
			.holder{        
			width:100%;
			position:absolute;
			left:0;
			top:0px;
			display:block;  
			}
			.popup{
			width:800px;
			margin:0 auto;
			border-radius: 7px;
			background:#97BCE5;
			margin:30px auto 0;
			padding:6px;
			}
			
			.content{
			background:#fff;
			padding: 28px 26px 33px 25px;
			}
        
        </style>

<script type="text/javascript">

function checkAcknowledgement(frm){
	
	if( document.signup.name_club.value== "" )
   {
		alert( "Please enter host name." );
     	document.signup.name_club.focus() ;
     	return false;   
	}
	
	if( document.signup.club_email.value== "" )
   {
		alert( "Please enter host email." );
     	document.signup.club_email.focus() ;
     	return false;   
	}
	
	if( document.signup.phone.value== "" )
   {
		alert( "Please enter the phone number in correct format xxx-xxx-xxxx" );
     	document.signup.phone.focus() ;
     	return false;   
	}
	
	var phoneno = /^\(?([0-9]{3}[-. ])\)?[-. ]?([0-9]{3}[-. ])[-. ]?([0-9]{4})$/; 
  if(document.signup.phone.value.match(phoneno))  
        {  
      //return true;  
        }  
      else  
        {  
        alert("Please enter the phone number in correct format xxx-xxx-xxxx");  
		document.signup.phone.focus() ;
        return false;  
        }  
	if (document.signup.phone.value.length < 10)
           {
                alert("Enter 10 digit ");
				document.signup.phone.focus() ;
                return false;
           }
		   	 var cc=document.getElementById("acknowledgement").checked; 
	  if (cc == '0'){
    alert('Please agree to the privacy policy.');
	return false;
  }
		 
 /* var checked = frm.acknowledgement.checked;
  if (!checked){
    alert('Please agree to the privacy policy.');
  }
  return checked;*/
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
				if(x=='223')
				{
					 $.get('getcity_sign.php?con=us', function(data) {
					$('#cities').html(data);
					});
				}else
				{
					 $.get('getcity_sign.php?con=ca', function(data) {
					$('#cities').html(data);
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
				st = document.getElementById('state_id');
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
				 alert("The email address is already taken. Please choose another one.");			 
				 document.signup.club_email.value="";
				 document.signup.club_email.focus() ;
				 return false;
			 }
             
        }
	});
}
}

function getcity(x)
{
$.get('getcity_sign.php?state_id='+x, function(data) {
$('#cities').html(data);
});
}
</script>

<!--/***************************************************-->

</head>

<body>
<div id="main">
    <div class="container">
    <?php 
	 include('header.php')
	?>
    <div id="wrapper" class="space">
       <div id="title">Registration of host user</div>
       <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
       ?>
       <?php 	
			$adv_left1 = @mysql_query("select * from `advertise` where page_name='host-user-left-1'");
				$advleft1 =@mysql_fetch_array($adv_left1) ; 
				$left_img1 =substr($advleft1['adv_img'],6);
				$left_afl1 =$advleft1['affiliate-code'];
				$left_adv_link1 = $advleft1['adv_link'];  
				
				$adv_left2 = @mysql_query("select * from `advertise` where page_name='host-user-left-2'");
				$advleft2 =@mysql_fetch_array($adv_left2) ; 
				$left_img2 =substr($advleft2['adv_img'],6);
				$left_adv_link2 = $advleft2['adv_link'];  
	?>
       <div id="left">
         <div class="advertise" style="margin-top:30px;"> <?php if($advleft1['adv_type']=='image') {  ?>
         	<a href="<?php echo $left_adv_link1;?>" target="_blank">
         		<img src="<?php echo $left_img1; ?>" alt="Left Ad Top" />
            </a>
             <?php } else { 
          echo $advleft1['affiliate-code'];
     	    } ?></div>
         <div class="advertise"><?php if($advleft2['adv_type']=='image') {  ?>
             <a href="<?php echo $left_adv_link2;?>" target="_blank">         	
             	<img src="<?php echo $left_img2; ?>" alt="Left Ad Bottom"  />
             </a>
                <?php } else { 
          echo $advleft2['affiliate-code'];
     	    } ?></div>
       </div>
       <div id="middle" style="min-height:0; background-color:#97BCE5; width:455px;">
         <div class="login" style="padding:15px 15px 30px 15px;">
           <h2>Please Fill HOST Details.</h2>
         <form name="signup" id="signup"  method="post"  action="main/signup_club.php">
           <ul>
               <li>Name of HOST:</li>
               <li><input type="text" name="name_club" id="name_club" class="txt_box"  /> </li>
             </ul>
           <ul>
             <li> Email:</li>
             <li><input type="text" name="club_email" id="club_email" class="txt_box"  /></li>
           </ul>
            <ul>
             <li>Password:</li>
             <li><input type="password" name="password" id="password" class="txt_box" /></li>
           </ul>
            <ul>
             <li>Confirm Password:</li>
             <li><input type="password" name="cpassword" id="cpassword"  class="txt_box" /></li>
           </ul>
            
              
        	 <ul>
             <li>HOST Contact No:(e.g. xxx-xxx-xxxx)</li>
             <li><input type="text" name="phone" id="phone"  maxlength="15" class="txt_box" /></li>
           </ul>
         
          
          <ul>
             <li>HOST Address:</li>
             <li><textarea name="club_add" id="club_add" style="width:200px;"></textarea></li>
           </ul>
           <ul>
            <?php 
		 $countrysql="select country_id,name from country where country_id IN(223,38)";
		 $country_list = mysql_query($countrysql);
		 
		 ?>
             <li>Country:</li>
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
         </ul>
          <ul>
             <li>State<span class="error">*</span>:</li>
            <? $state_sql="select zone_id,name from zone where country_id IN(223)";
		 $state_list = mysql_query($state_sql); ?>
              <li><select name="state" id="state_id"  onchange="getcity(this.value);">
   
   <option value="">- - Select - -</option>
 	  <?php 
    	while($row_s = mysql_fetch_array($state_list))
				{ ?>
                  <option  value="<?php echo $row_s["zone_id"]; ?>" ><?php echo $row_s["name"]; ?></option>
				<? }
				   ?>
            </select>
            </li>
           </ul>
        	
            	 <ul>
            <?php 
		 $citylist="SELECT city_name, city_id FROM `capital_city` 
	    LEFT JOIN zone on(zone.zone_id=capital_city.state_id)
		WHERE country_id='223' ORDER BY `city_name` ASC";
		 $citylist_all = @mysql_query($citylist);
		 
		 ?>
             <li>City:</li>
             <li id="cities"><select name="city_name" id="city_name" onchange="other_city_show(this.value);" >
             <option value="">- - Select - -</option>
               <option value="other">Enter Other City</option>
             <?php 
				while($row1 = mysql_fetch_array($citylist_all))
				{
				  ?>
				  <option value="<?php echo $row1["city_id"]; ?>" ><?php echo $row1["city_name"]; ?></option>
				   <?php
				   }
				   ?>
                </select>
             </li>
         </ul>	
         
           <ul id="other_c" style="display:none;">
             <li>Enter Your City:</li>
             <li><input type="text" name="other_city" id="other_city"  class="txt_box" style="width:200px;" /></li>
           </ul>
        
         
           <ul>
             <li>Zipcode:</li>
             <li><input type="text" name="zipcode" required="" class="txt_box" style="width:200px;" /></li>
           </ul>
            <ul>
             <li>Type of HOST:</li>
             <?php 
			 $cnd=" parrent_id='0'";
			 $sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); 
			 ?>
               	  <?php while($clubs=@mysql_fetch_assoc($sql_main_club)) { ?>
             <li><input type="radio" name="type_of_club" value="<?php echo $clubs['id'];?>"  />  <?php  echo $clubs['name'];  ?>  
					 <?php 
                     $cnd=" parrent_id='0'";
                     $sql_sub_cat=mysql_query("select * from club_category where parrent_id='".$clubs['id']."' ORDER BY name ASC"); 
                     ?>
             		<ul style="margin-left:20px;display:none;" id="club_<?php echo $clubs['id'];?>" class="details">
                     <?php while($clubs_sub=@mysql_fetch_assoc($sql_sub_cat)) { ?>
                    	<li>
                        	<input type="checkbox" name="subcat[]" value="<?php echo $clubs_sub['id']; ?>" /><?php echo $clubs_sub['name']; ?>
                        </li>
                          <?php } ?>
                    </ul>
               </li>
               <?php } ?>
             
           </ul>
           <ul>
             <li>HOST Google Map URL(NOTE: How to get the URL
             <a href="#dialogx" name="modal">Click here</a>):</li>
             
             <li><textarea name="club_google_map" required="" cols="50" rows="7"></textarea></li>
           </ul>
           <ul>
             <li>Enter the code:</li>
             <li style="display:table-cell;">
         <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' >&nbsp;&nbsp;&nbsp;&nbsp;
             </li>
             <li style="display:table-cell; vertical-align:top;">
             	<input id="letters_code" name="letters_code" type="text"><br>
              <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
             </li>
           </ul>
           <ul>
             <li><input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" style="margin:0 10px 0 0;" />I have read and agree to the
              <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a></li>
             <li>&nbsp;</li>
             <li><input type="submit" name="submit" value="Continue" class="button" /></li>
           </ul>
           </form>
         </div>
       </div>
        <?php 	
	   $adv_right1 = @mysql_query("select * from `advertise` where page_name='host-user-right-1'");
	$advright1 =@mysql_fetch_array($adv_right1) ; 
	$right_img1 =substr($advright1['adv_img'],6); 
	$right_adv_link1 = $advright1['adv_link']; 
	
	$adv_right2 = @mysql_query("select * from `advertise` where page_name='host-user-right-2'");
	$advright2 =@mysql_fetch_array($adv_right2) ; 
	$right_img2 =substr($advright2['adv_img'],6);  
	$right_adv_link2 = $advright2['adv_link']; 
	?>
       <div id="right2">
          <div class="advertise" style="margin-top:30px;">
           <?php if($advright1['adv_type']=='image') {  ?>
         <a href="<?php echo $right_adv_link1;?>" target="_blank">
         <img src="<?php echo $right_img1; ?>" />
         </a>
          <?php } else { 
          echo $advright1['affiliate-code'];
     	    } ?>
         </div>
         <div class="advertise">
           <?php if($advright2['adv_type']=='image') {  ?>
          <a href="<?php echo $right_adv_link2;?>" target="_blank">
         <img src="<?php echo $right_img2; ?>" />
         </a>
          <?php }
		   else { 
          echo $advright2['affiliate-code'];
     	    } ?>
          </div>
       </div>
       
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
<script type="application/javascript">
$("input:radio[name=type_of_club]").click(function() {
    var value = $(this).val();
	//alert(value);
	//alert(value);
	   $('.details').hide('slow');
		  $('#club_'+value).show('slow');
	
});
</script>

<div id="dialogx" class="window">
    <div class="modal" >
        <a href="#"class="close" style="float:right;"/><img src="images/remove.png"/></a>
        <img src="images/how_to_get_url_screenshot.png" width="403" height="390" />
    </div>
</div>
</body>
</html>
