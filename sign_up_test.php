<?php
session_start();
$_SESSION['count'] = time();
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
  $message=" Please Enter Valid Captcha Code";
  }
  if($para=="failed")
  {
  $message=" Please Fill Proper Information";
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
<title>Standard User Signup</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src='js/jquery.validate.js'></script>
<script src="slider2/js/modernizr.custom.17475.js"></script>
<!-- <script src="js_validation/signup.js" type="text/javascript"></script> -->
 <script src="js/register.js" type="text/javascript"></script> 

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
       document.signup.email.value="";
             document.signup.email.focus() ;
         return false;
       }
             
        }
  });
}
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

function getcity(x)
{
$.get('getcity_sign.php?state_id='+x, function(data) {
$('#cities').html(data);
});
}



</script>
<?PHP 
/***************************************************************************/
    FUNCTION DateSelector($useDate=0) 
    { 
      $months = array ('January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 
      'December');
      $days = range (1, 31);
      $years = range (1951, DATE("Y"));
      
          echo "<select name='month' style='width:100px;'>";
        echo '<option value="Select"> Select</option>\n';
              for ($month = 0; $month <= 12; $month++) 
        {
          echo '<option value="'.$month.'">'.$months[$month].'</option>\n';
        }
      echo '</select> &nbsp; ';
      
      echo "<select name='date' style='width:75px;'>";
      echo '<option value="Select"> Select</option>\n';
      foreach ($days as $value) {
          echo '<option value="'.$value.'">'.$value.'</option>\n';
      }
       echo '</select> &nbsp; ';
      
    
      
      
      echo "<select name='year' style='width:80px;'>";
      echo '<option value="Select"> Select</option>\n';
      foreach ($years as $value) {
          echo '<option value="'.$value.'">'.$value.'</option>\n';
      }  
      echo '</select> &nbsp; ';
    
    } 

//function create_image()
//{

//Settings: You can customize the captcha here
$image_width = 120;
$image_height = 40;
$characters_on_image = 6;
$font = './monofont.ttf';
global $image;
//The characters that can be used in the CAPTCHA code.
//avoid confusing characters (l 1 and i for example)
$possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
$random_dots = 0;
$random_lines = 20;
$captcha_text_color="0x142864";
$captcha_noice_color = "0x142864";

$code = '';


$i = 0;
while ($i < $characters_on_image) { 
$code .= substr($possible_letters, mt_rand(0, strlen($possible_letters)-1), 1);
$i++;
}


$font_size = $image_height * 0.75;
$image = @imagecreate($image_width, $image_height);


/* setting the background, text and noise colours here */
$background_color = imagecolorallocate($image, 255, 255, 255);

$arr_text_color = hexrgb($captcha_text_color);
$text_color = imagecolorallocate($image, $arr_text_color['red'], 
    $arr_text_color['green'], $arr_text_color['blue']);

$arr_noice_color = hexrgb($captcha_noice_color);
$image_noise_color = imagecolorallocate($image, $arr_noice_color['red'], 
    $arr_noice_color['green'], $arr_noice_color['blue']);


/* generating the dots randomly in background */
for( $i=0; $i<$random_dots; $i++ ) {
imagefilledellipse($image, mt_rand(0,$image_width),
 mt_rand(0,$image_height), 2, 3, $image_noise_color);
}


/* generating lines randomly in background of image */
for( $i=0; $i<$random_lines; $i++ ) {
imageline($image, mt_rand(0,$image_width), mt_rand(0,$image_height),
 mt_rand(0,$image_width), mt_rand(0,$image_height), $image_noise_color);
}


/* create a text box and add 6 letters code in it */
$textbox = imagettfbbox($font_size, 0, $font, $code); 
$x = ($image_width - $textbox[4])/2;
$y = ($image_height - $textbox[5])/2;
echo $_SESSION['letters_code'] = $code;
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font ,$code);

$images = glob("*.png");
foreach ($images as $image_to_delete) {
    @unlink($image_to_delete);
}
    imagepng($image, "captcha/image" . $_SESSION['count'] . ".png");
/* Show captcha image in the page html page */
//header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
//imagejpeg($image);//showing the image
//imagedestroy($image);//destroying the image instance

//}
function hexrgb ($hexstr)
{
  $int = hexdec($hexstr);

  return array("red" => 0xFF & ($int >> 0x10),
               "green" => 0xFF & ($int >> 0x8),
               "blue" => 0xFF & $int);
}



?> 
</head>

<body>
<div id="main">
    <div class="container">
    <?php 
   include('header.php')
  ?>
    <div id="wrapper" class="space">
       <div id="title">Registration of standard user</div>
       <?php
     if($message!="")
     {
     ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
   
   
       ?>
       <?php  
      $adv_left1 = @mysql_query("select * from `advertise` where page_name='standard-user-left-1'");
        $advleft1 =@mysql_fetch_array($adv_left1) ; 
        $left_img1 =substr($advleft1['adv_img'],6);
        $left_afl1 =$advleft1['affiliate-code'];
        $left_adv_link1 = $advleft1['adv_link'];  
        
        $adv_left2 = @mysql_query("select * from `advertise` where page_name='standard-user-left-2'");
        $advleft2 =@mysql_fetch_array($adv_left2) ; 
        $left_img2 =substr($advleft2['adv_img'],6);
        $left_adv_link2 = $advleft2['adv_link'];  
  ?>
       <div id="left">
         <div class="advertise" style="margin-top:30px;">  <?php if($advleft1['adv_type']=='image') {  ?>
          <a href="<?php echo $left_adv_link1;?>" target="_blank"><img src="<?php echo $left_img1; ?>" alt="Left Ad Top" /></a>
             <?php } else { 
          echo $advleft1['affiliate-code'];
          } ?></div>
         <div class="advertise">  <?php if($advleft2['adv_type']=='image') {  ?>
          <a href="<?php echo $left_adv_link2;?>" target="_blank"><img src="<?php echo $left_img2; ?>" alt="Left Ad Top" /></a>
             <?php } else { 
          echo $advleft2['affiliate-code'];
          } ?></div>
       </div>
       <div id="middle" style="min-height:0; background-color:#97BCE5; width:455px;">
         <div class="login" style="padding:15px 15px 30px 15px;">
           <h2>Please fill your details.</h2>
         <form name="signup" id="signup"  method="post"   action="main/signup.php" >
           <ul>
             <li>First Name<span class="error">*</span>:</li>
             <li><input name="fname" id="fname" type="text" class="txt_box" /></li>
           </ul>
           <ul>
             <li>Last Name<span class="error">*</span>:</li>
             <li><input type="text" name="lname" class="txt_box" /></li>
           </ul>
           <ul>
             <li>Email<span class="error">*</span>:</li>
             <li><input type="text" name="email" class="txt_box" onblur="ChkUserId(this.value);"/></li>
           </ul>
            <ul>
             <li>Password<span class="error">*</span>:</li>
             <li><input type="password" name="password" id="password" class="txt_box" /></li>
           </ul>
            <ul>
             <li>Confirm Password<span class="error">*</span>:</li>
             <li><input type="password" name="cpassword" class="txt_box" /></li>
           </ul>
             <ul>
               <li>Date of Birth:</li>
               <li><?PHP DateSelector(); ?> </li>
             </ul>
           <ul>
             <li>Phone:(e.g. xxx-xxx-xxxx)</li>
             <li><input type="text" name="phone" maxlength="15" class="txt_box" />
       </li>
           </ul>
           <ul>
            <?php 
     $countrysql="select country_id,name from country where country_id IN(223,38)";
     $country_list = mysql_query($countrysql);
     
     ?>
             <li>Country<span class="error">*</span>:</li>
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
             <li>City<span class="error">*</span>:</li>
             <li id="cities">
             <select name="city_name" id="city_name" onchange="other_city_show(this.value);" >
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
             <li><input type="text" name="other_city" id="other_city" required="" class="txt_box" style="width:200px;" /></li>
           </ul>
        

           <ul>
             <li>Zipcode<span class="error">*</span>:</li>
             <li><input type="text" name="zipcode" id="zipcode" class="txt_box" style="width:200px;" /></li>
           </ul>
           <ul>
             <li>Enter the code<span class="error">*</span>:</li>
             <li style="display:table-cell;">
         <!-- <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' > -->
<img src="image<?php echo $_SESSION['count'] ?>.png">
         &nbsp;&nbsp;&nbsp;&nbsp;
         
             </li>
             <li style="display:table-cell; vertical-align:top;">
              <input id="letters_code" name="letters_code" type="text"><br>
              <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
              <div id="captch_error" class="error"></div>
             </li>
           </ul>
           <ul>
             <li><input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" style="margin:0 10px 0 0;" />I have read and agree to the
              <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a><span class="error">*</span></li>
             <li>&nbsp;</li>
             <li><input type="submit" name="submit" value="Continue" class="button"  /></li>
           </ul>
           </form>
         </div>
       </div>
        <?php   
     $adv_right1 = @mysql_query("select * from `advertise` where page_name='standard-user-right-1'");
  $advright1 =@mysql_fetch_array($adv_right1) ; 
  $right_img1 =substr($advright1['adv_img'],6); 
  $right_adv_link1 = $advright1['adv_link']; 
  
  $adv_right2 = @mysql_query("select * from `advertise` where page_name='standard-user-right-2'");
  $advright2 =@mysql_fetch_array($adv_right2) ; 
  $right_img2 =substr($advright2['adv_img'],6);  
  $right_adv_link2 = $advright2['adv_link']; 
  ?>
       <div id="right2">
         <div class="advertise" style="margin-top:30px;">  <?php if($advright1['adv_type']=='image') {  ?>
         <a href="<?php echo $right_adv_link1;?>" target="_blank">
         <img src="<?php echo $right_img1; ?>" />
         </a>
          <?php } else { 
          echo $advright1['affiliate-code'];
          } ?></div>
         <div class="advertise"><?php if($advright2['adv_type']=='image') {  ?>
          <a href="<?php echo $right_adv_link2;?>" target="_blank">
         <img src="<?php echo $right_img2; ?>" />
         </a>
          <?php }
       else { 
          echo $advright2['affiliate-code'];
          } ?></div>
       </div>
       
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
