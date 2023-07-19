<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );

$userType= $_SESSION['user_type'];
if(isset($_GET['cont_id']))
{
	$contestID = $_GET['cont_id'];
	$getContestInfo = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$contestID' ");
	$fetchContestInfo = mysql_fetch_array($getContestInfo);
	$titleofpage="Edit Contest";
}
else
{
	$titleofpage="Add Contest";
}


if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

if(isset($_POST['add_HostContest']))
{
	$host_id = $_SESSION['user_id'];
	$dateofbirth =$_POST['year']."-".$_POST['month']."-".$_POST['date'];
	$contest_title=mysql_escape_string($_POST['contest_title']);
	$contest_desc=mysql_escape_string($_POST['contest_desc']);
	$contest_rule=mysql_escape_string($_POST['contest_rule']);
	$start_date=trim($_POST['contest_start']);
	//$var_start=explode('/',$start_date);
	$contest_start = date('Y-m-d',strtotime($start_date));
	$end_date=trim($_POST['contest_end']);
	//$var_end=explode('/',$end_date);
	$contest_end = date('Y-m-d',strtotime($end_date));
	$regi_date=trim($_POST['contest_regi']);
	//$var_regi=explode('/',$regi_date);
	$contest_regi = date('Y-m-d',strtotime($regi_date));
	$contest_img= $_FILES["contest_img"]["name"];
	$tmp = $_FILES["contest_img"]["tmp_name"]; 
	$path = "contest_img/".time().strtotime(date("Y-m-d")).$contest_img;
	$thumbnail = "contest_img/thumb_".time().strtotime(date("Y-m-d")).$contest_img;
	move_uploaded_file($tmp,$path);
	
  	//indicate which file to resize (can be any type jpg/png/gif/etc...)
 	$file = $path;
	 
	 //indicate the path and name for the new resized file
	 $resizedFile = $thumbnail;
	 
	 //call the function (when passing path to pic)
	// smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
	 //call the function (when passing pic as string)
	// smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );


	 $resizeObj = new resize($file);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(300, 200, 'auto');

	// *** 3) Save image ('image-name', 'quality [int]')
	$resizeObj -> saveImage($resizedFile, 100);

	
	
	if($_POST['city_name']=="")
	{
		$contest_city=$_SESSION['id'];
		$contest_state=$_SESSION['state'];
		$contest_country=$_SESSION['country'];
	
	}else
	{
		$contest_country=$_POST['country'];
		$contest_state=$_POST['state'];
		$contest_city=$_POST['city_name'];
	}
	$status = 1;
	$today = date("Y-m-d h:i:s");
	$ThisPageTable='contest';
	$ValueArray = array($host_id,$contest_title,$contest_desc,$contest_rule,$contest_start,$contest_end,$contest_regi,$path,$contest_country,$contest_state,$contest_city,$status,$today);	
	$FieldArray = array('host_id','contest_title','contest_desc','contest_rule','contest_start','contest_end','contest_regi','contest_img','contest_country','contest_state','contest_city','status','addedOn');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	$lastContestId = mysql_insert_id();
	if($Success > 0)
	{
		$get_host_connections = mysql_query("select distinct(fs.friend_id),fs.status as freindstatus,u.first_name,u.image_nm,u.last_name,u.country,u.state,u.city,u.status,u.zipcode,fs.chat,fs.id as f_id from friends as fs, user as u where u.id=fs.friend_id AND fs.user_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.friend_type='user' AND fs.status IN ('active','block') GROUP BY friend_id ORDER BY u.zipcode ASC");
					
		$count_connections = mysql_num_rows($get_host_connections);
		$inserted_event_id = $lastContestId;
		
		if($count_connections > 0)
		{
			
			while($conn_row = mysql_fetch_assoc($get_host_connections))
			{
		
				$event_added_on = date('Y-m-d h:i:s');
				$c_identifier = "contest_".$inserted_event_id;
		
				mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$conn_row['friend_id']."', 'contest', '".$event_added_on."', '1', '".$c_identifier."', 'club', 'user')");
		
			}
		}


	  	/***** FACEBOOK POST SHARE *****/
		if(isset($_SESSION['fb_token']))
		{
			if(!empty($_FILES["contest_img"]["name"]))
			{	
				$share_link = $base_url.$thumbnail;
				$share_picture = $base_url.$thumbnail;
			}
			else
			{
				$share_link = $base_url;
				$share_picture = $base_url."images/logo.jpg";
			}
			$session = new FacebookSession( $_SESSION['fb_token'] );
			
			// graph api request for user data
			$request = new FacebookRequest( $session, 'POST', '/me/feed', array(
			   'name' => $_POST["contest_title"],
			   'caption' => 'mysittidev.com',
			   'link' => $share_link,
			   'message' => 'Created New Contest '.$_POST["contest_title"].' on Mysitti',
			   'picture' => $share_picture
			  ) );
			$response = $request->execute();
		}
				/***** FACEBOOK POST SHARE *****/

		/** TWITTER POST SHARE **/
		
		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
		{
			include_once("twitter/config.php");
			include_once("twitter/inc/twitteroauth.php");
			
			//Success, redirected back from process.php with varified status.
			//retrive variables
			$screenname 		= $_SESSION['request_vars']['screen_name'];
			$twitterid 			= $_SESSION['request_vars']['user_id'];
			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
		
			//Show welcome message
			echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
			
			//see if user wants to tweet using form.
			if(isset($_POST["contest_title"])) 
			{
				//Post text to twitter
				$my_update = $connection->post('statuses/update', array('status' => $contest_title));
				//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
			}
		}
		
		/**TWITTER POST SHARE**/	  

	  
		if($_GET['type']=='host_add')
		{
			//include("../email_sent.php");
			header("Location:contests_list.php?msg=success");
			die;
		}
		else
		{
			header("Location:my_contests.php?msg=success");
			die;
		}
	}
}


if(isset($_POST['update_HostContest']))
{
	$host_id = $_SESSION['user_id'];
	$dateofbirth =$_POST['year']."-".$_POST['month']."-".$_POST['date'];
	$contest_title=mysql_escape_string($_POST['contest_title']);
	$contest_desc=mysql_escape_string($_POST['contest_desc']);
	$contest_rule=mysql_escape_string($_POST['contest_rule']);
	$start_date=trim($_POST['contest_start']);
	//$var_start=explode('/',$start_date);
	$contest_start = trim($_POST['contest_start']);
	$end_date=trim($_POST['contest_end']);
	//$var_end=explode('/',$end_date);
	$contest_end = trim($_POST['contest_end']);
	$regi_date=trim($_POST['contest_regi']);
	//$var_regi=explode('/',$regi_date);
	$contest_regi = "";

	$getimagePath = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$contestID' ");
	$fetchimage = mysql_fetch_array($getimagePath);
	if(($_FILES["contest_img"]["name"]) != "")
	{

		$contest_img= $_FILES["contest_img"]["name"];
		$tmp = $_FILES["contest_img"]["tmp_name"]; 
		$path = "contest_img/".strtotime(date("Y-m-d")).$contest_img;
		$thumbnail = "contest_img/thumb_".strtotime(date("Y-m-d")).$contest_img;
		move_uploaded_file($tmp,$path);
		
		  //indicate which file to resize (can be any type jpg/png/gif/etc...)
		 $file = $path;
		 
		 //indicate the path and name for the new resized file
		 $resizedFile = $thumbnail;
		 
		 //call the function (when passing path to pic)
		// smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
		 //call the function (when passing pic as string)
		// smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
		$resizeObj = new resize($file);

		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage(300, 200, 'auto');

		// *** 3) Save image ('image-name', 'quality [int]')
		$resizeObj -> saveImage($resizedFile, 100);
	}
	else
	{
		$path = $fetchimage['contest_img'];
	}

// echo $path; die('dddddd');
	
	
	if($_POST['city_name']=="")
	{
		$contest_city=$_SESSION['id'];
		$contest_state=$_SESSION['state'];
		$contest_country=$_SESSION['country'];
	
	}else
	{
		$contest_country=$_POST['country'];
		$contest_state=$_POST['state'];
		$contest_city=$_POST['city_name'];
	}
	$status = 1;
	$today = date("Y-m-d h:i:s");
	$ThisPageTable='contest';
	$ValueArray = array($host_id,$contest_title,$contest_desc,$contest_rule,$contest_start,$contest_end,$contest_regi,$path,$contest_country,$contest_state,$contest_city,$status,$today);	
	$FieldArray = array('host_id','contest_title','contest_desc','contest_rule','contest_start','contest_end','contest_regi','contest_img','contest_country','contest_state','contest_city','status','addedOn');
	$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'contest_id',$contestID);
	if($Success > 0)
	{
		if($_GET['type']=='host_add')
		{
			//include("../email_sent.php");
			header("Location:contests_list.php?msg=success");
			die;
		}
		else
		{
			header("Location:my_contests.php?msg=success");
			die;
		}
	}
}

?>
 
<style>
#city_panel{ display: none; }   
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('club-right-panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php 
					if(isset($_GET['cont_id']))
					{
						echo "<h3 id='title'>Edit Contest</h3>";
					}
					else
					{
						echo "<h3 id='title'>Add Contest</h3>";
					}
				?>

					
					<?php  if($message!=""){ 

					echo '<div id="successmessage" class="message" >'.$message."</div>";
					}
					

					?>
                    <div class="v2_add_contst">
                    			<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
				<script>tinymce.init({
							selector:'.formw textarea',
							toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
							fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
							menubar: false
						});</script>
				<style type="text/css">
				.home_content_top button { background: none;}
				.hostdjinfo p span em strong {font-weight: bold;}
				.hostdjinfo p span em
				{
					font-style: italic;
				}


				</style>
					 	<form name="add_contest" onsubmit="return validate_contest1();"  method="post"  enctype="multipart/form-data">
							<div class="row">
							<span class="label">Contest Title:<font color='red'>*</font></span>
							<span class="formw">
							<textarea name="contest_title" style="width:240px" ><?php if(isset($_GET['cont_id'])){ echo mysql_real_escape_string($fetchContestInfo['contest_title']); }?></textarea>

							</span>
							</div>

							<div class="row">
							<span class="label">Contest Description:<font color='red'>*</font></span>
							<span class="formw">
							<textarea name="contest_desc" style="width:240px" ><?php if(isset($_GET['cont_id'])){ echo $fetchContestInfo['contest_desc']; }?></textarea>

							</span>
							</div>

							<div class="row">
							<span class="label">Contest Rule:<font color='red'>*</font></span>
							<span class="formw">
							<textarea name="contest_rule" style="width:240px" ><?php if(isset($_GET['cont_id'])){ echo $fetchContestInfo['contest_rule']; }?></textarea>
							</span>
							</div>
							<div class="row">
							<span class="label">Contest Start Date:<font color='red'>*</font></span>
							<span class="formw">
							<input id="datepicker_start" value="<?php if(isset($_GET['cont_id'])){ echo $fetchContestInfo['contest_start']; }?>"  name="contest_start" required type="text"    />

							</span>					
							</div>
							<div class="row">
							<span class="label">Contest Last Date:<font color='red'>*</font></span>
							<span class="formw">
							<input id="datepicker_end" value="<?php if(isset($_GET['cont_id'])){ echo $fetchContestInfo['contest_end']; }?>" required    name="contest_end" type="text"  onclick="Chk_Start_Date_exist();"  />

							</span>
							</div>
							<div class="row">
							<span class="label">Default City:<font color='red'>*</font></span>
							<span class="formw">
							<?php if(isset($_GET['cont_id'])){ $contestCity =  $fetchContestInfo['contest_title']; }else{ $contestCity = $_SESSION['id']; } ?>
							<?php


							$get_city_name=@mysql_query("select city_name from capital_city where city_id='".$contestCity."'"); 
							$city_n=@mysql_fetch_assoc($get_city_name);
							?>
							<?php echo $city_n['city_name']; ?> <a style="color: #fecd07;" href="javascript:void(0);" onclick="javascript:$('#city_panel').toggle();">[Change City] </a>


							</span>
							</div>

							<div id="city_panel">	   
							<div class="row">
							<span class="label">Country:<font color='red'>*</font></span>
							<span class="formw">
							<?php 
							$countrysql="select country_id,name from country where country_id IN ('223','38') ";
							$country_list = mysql_query($countrysql);

							?>
							<select name="country" id="country" onchange="showState_addevent(this.value);" onblur="Chk_Regi_Date();" onfocus="Chk_Regi_Date();" >
							<option value="">- - Select - -</option>
							<?php 
							while($row = mysql_fetch_array($country_list))
							{
							?>
							<option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
							<?php
							}
							?>
							</select>
							</span>
							</div> 

							<div class="row">
							<span class="label">State:<font color='red'>*</font></span>
							<span class="formw">
							<select name="state" id="forumst" onfocus="return validate_country();" onchange="getcity(this.value);">
							<option value="">- -Select- -</option>
							<?php 
							$countrysql1="select zone_id,name from zone where country_id=223 and status ='1'";
							$country_list1 = mysql_query($countrysql1);
							?>

							<?php 
							while($row1 = mysql_fetch_array($country_list1))
							{
							?>

							<option <?php if($_SESSION['state'] == $row1['zone_id']){ echo "selected"; } ?> value="<?php echo $row1["zone_id"]; ?>"  ><?php echo $row1["name"]; ?></option>
							<?php
							}

							?>
							</select>

							</span>
							</div>  
							<div class="row">
							<span class="label">City:<font color='red'>*</font></span>
							<span class="formw">
							<select name="city_name" id="city_name_g" >
							<option value="">- -Select- -</option>
							<?php 
							if(isset($_SESSION['state']) and $_SESSION['state'] != '')
							{
							$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 
							}
							else
							{
							$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";
							}
							$city_list1 = mysql_query($allcity);
							?>

							<?php 
							while($row_city = mysql_fetch_array($city_list1))
							{
							?>

							<option <?php if($_SESSION['id'] == $row_city['city_id']){ echo "selected"; } ?> value="<?php echo $row_city["city_id"]; ?>" ><?php echo $row_city["city_name"]; ?></option>
							<?php
							}

							?>
							</select>

							</span>
							</div>
							</div>		 
							<div class="row">
							<span class="label">Contest Image:<font color='red'>*</font></span>
							<span class="formw">
							<?php 	if(isset($_GET['cont_id']))
							{ 
							?>
							<img src="<?php echo $fetchContestInfo['contest_img']; ?>" width="300" alt="" /><br />
							<?php 
							}

							?>		
							<input name="contest_img" id="contest_img" type="file"<?php if(!isset($_GET['cont_id'])){ echo "required";} ?> style="color:#fff;" onchange="return Validate_add_cont_FileUpload()"/> (Allowed exts's gif, png, jpg & jpeg)
							</span>
							</div>   
							<?php 	if(isset($_GET['cont_id']))
							{ 
							?>
							<div id="submit_btn"><input name="update_HostContest" class="button" type="submit" value="Update Contest" id="submit3" /> &nbsp;&nbsp;&nbsp;
							<?php 	}
							else
							{
							?>
							<div id="submit_btn"><input name="add_HostContest" class="button" type="submit" value="Add Contest" id="submit3" /> &nbsp;&nbsp;&nbsp;
							<?php 	}	?>
							<a href="contests_list.php"><input name="cancel" class="button" type="button" value="Cancel"/></a></div>
						</form>
                        </div>
						<div id="right2">
					 		<div class="advertise" style="margin-top:30px; border:hidden"></div>
							<div class="advertise" style="border:hidden"></div>
						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
		 
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

function Chk_Start_Date_exist()
{
	//alert("asdf");
 var start_date= document.getElementById("datepicker_start").value;
 if(start_date!=""){
	 ajaxFunction("../../ChkstartDate.php?start_date="+start_date, function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				 var s = xmlhttp.responseText;
				 if(s==0)
				 {
				 alert("Contest is running for this date.");			 
				 document.add_contest.contest_start.value="";
				 document.add_contest.contest_start.focus() ;
					document.getElementById("datepicker_start").value="";
				// return false;
				 }
				 
			}
		});
	}
	var start_date= new Date(document.getElementById("datepicker_start").value);
		var dateNow = new Date();
		if(start_date!=""){
				if( start_date < dateNow)
				{ 
					alert('Please enter future date');
					document.add_contest.contest_start.focus() ;
					document.getElementById("datepicker_start").value="";
					//return false;
				}  
		}
}

function Chk_End_Date()
{
	var end_date= new Date(document.getElementById("datepicker_end").value);
	var start_date= new Date(document.getElementById("datepicker_start").value);
	var dateNow = new Date();
	if(end_date!=""){
		if( end_date < dateNow)
		{
			alert('Please enter future date');
			document.add_contest.contest_end.focus();
			document.add_contest.contest_end.value="" ;
			document.getElementById("datepicker_end").value="";
			//return false;
		} 
		if(end_date < start_date)
		{
			alert('End date should be greater than start date');
			document.add_contest.contest_end.value="" ;
			document.add_contest.contest_end.focus() ;
			document.getElementById("datepicker_end").value="";
			//return false;	
		}
	}		
}

function Chk_Regi_Date()
{
	var regi_date= new Date(document.getElementById("datepicker_regi").value);
	var start_date= new Date(document.getElementById("datepicker_start").value);
	var dateNow = new Date();
	if(regi_date!=""){
		if( regi_date < dateNow)
		{
			alert('Please enter future date');
			document.add_contest.contest_regi.focus() ;
			document.getElementById("datepicker_regi").value="";
			//return false;
		} 
		if(regi_date > start_date)
		{
			
			alert('Register date should be less than start date');
			document.add_contest.contest_regi.value="" ;
			document.add_contest.contest_regi.focus() ;
				document.getElementById("datepicker_regi").value="";
			//return false;	
		}
	}
}

function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name_g').html(data);
});
}
function validate_contest1(){
	//var start_date = $('#datepicker_start').val();
	//var end_date = $('#datepicker_end').val();
	
var from = $("#datepicker_start").val().split("-");
var f = new Date(from[0], from[1] - 1, from[2]);


var to = $("#datepicker_end").val().split("-");
var t = new Date(to[0], to[1] - 1, to[2]);
	
	  var dateOne = new Date(f);
	  var dateTwo = new Date(t);
	   
	  if (dateOne > dateTwo) {
		 
		 alert("Contest end date must be greater then Contest Start date");
		 $("#datepicker_end").focus();
		 return false;
	  }else{
		 
		 return true;
	  }	
}

function Validate_add_cont_FileUpload(){
		var check_image_ext = $('#contest_img').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#contest_img').val('');
		}
}
</script>
<?php include('Footer.php');?>



