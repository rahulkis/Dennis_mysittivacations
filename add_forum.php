<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


$para="";
if(isset($_REQUEST))
{
$para=$_REQUEST['msg'];
}
if($para=="error")
{
$message="The username or password you entered is incorrect.";
}

/*include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];*/
?>
 <script  type="text/javascript">
	
 
function validate_forum()
{
  if( document.forum.forum.value== "" )
   {
    alert( "Please provide Event Name!" );
      document.forum.forum.focus() ;
      return false;   
  }
  
  if( document.forum.event_address.value== "" )
   {
    alert( "Please provide Event Address!" );
      document.forum.event_address.focus() ;
      return false;   
  }
}

function ValidateFileUpload(){
		var check_image_ext = $('#add_post_img').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Forum Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#add_post_img').val('');
		}
}

function ValidateVideoUpload(){
		var check_image_ext = $('#add_post_video').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','MPEG','MPEG-4','avi']) == -1) {
			  alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
				$('#add_post_video').val('');
		}
}	


	
 

</script> 

<?php
$titleofpage="Add Forum";
include ('headhost.php');

$userID=$_SESSION['user_id'];
if(isset($userID)){ ?>
    <?php include('header.php') ?>
<div class="home_wrapper">
  <div class="main_home">
   <div class="home_content">     
       <div class="home_content_top">
       <div id="title" class="botmbordr">Add Event</div>
 		<div id="middle" class="middleaddfrm" >
				<form name="forum" action="main/add_forum.php" method="post" onsubmit="return validate_forum();" enctype="multipart/form-data">
				<div class="row"> 
					<span class="label">
						<label >Event Name:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
						<input type="text" name="forum" class="txt_box" value="" required >
					</span>
				</div>
				<div class="row"> 
					<span class="label">
						<label >Event Address:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw"  >
						<!--<div style="width:100%; overflow:auto;">-->
						<textarea name="event_address" style="height:50px;"  class="txt_box" required placeholder="Enter Street Address Only"/></textarea>
					     <!--</div>-->
					</span>
				</div>
				<div class="row"> 
					<span class="label">
						<label >State & City :<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
				<?php 
						 	$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1'";
   							$country_list1 = @mysql_query($countrysql1);	?>
                            <select class="forumstate" name="forumstate" id="forumst" onChange="getcity(this.value);">
							<option value="">------- Select -------</option>
				              <?php
                    						while($row = @mysql_fetch_array($country_list1))
                    						{
                    							if($row['zone_id'] == $_SESSION['state'])
                    							{
                    								$select = " selected";
                    							}
                    							else
                    							{
                    								$select = "";
                    							}
                    							echo "<option ".$select." value='".$row['zone_id']."' >".$row['name']."</option>";
                    						}
                    						?>
                    						</select>
                    						<select class="forumcity" name="forumcity" id="forumcit" onchange="getempty();">
                    							<option value="">------- Select -------</option>
                    					<?php 	if(isset($_SESSION['state']) and $_SESSION['state'] != '')
							{
								$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 
							}
							else
							{
								$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";
							}
							
						        	$city_list1 = mysql_query($allcity);
	            					while($row_city = mysql_fetch_array($city_list1))
	            					{  ?>
	            						<option value="<?php echo $row_city['city_id']; ?>" <?php if($_SESSION['id']==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
	                 <?php }	?></select>
					</span>
				</div>

				<div class="row"> 
					<span class="label">
						<label >Event Date & Time:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<input type="text" name="event_date" class="txt_box" id="datetimepicker4" required >
					</span>
				</div>
				<div class="row"> 
					<span class="label">

						<label >Event Description:<b><font color='red'><em></em></font></b></label>

					</span>
					<span class="formw">
												<!--<div style="width:100%; overflow:auto;">-->
				<textarea name="event_description"  style="height:100px;" class="txt_box" required/></textarea>
												<!--</div>-->
					</span>
				</div>
				<div class="row"> 
				<span class="label"><label >Event Image:<b><font color='red'><em></em></font></b></label></span>
				<span class="formw"><input type="file" style="color: #fff; width: 100%;" name="forum_img" class="txt_box" id="add_post_img" onchange="return ValidateFileUpload()"/>
				<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span></span>
                
				</div>
				<div class="row"> 
				<span class="label"><label >Event Video:<b><font color='red'><em></em></font></b></label></span>
				<span class="formw">
                <input type="file" style="color: #fff; width:100%;" name="forum_video" class="txt_box" id="add_post_video"  onchange="return ValidateVideoUpload()"/> 
				<span class="text_allowed"> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)</span>
				</span>
				</div>
				<div class="field_ss"> 
				<div class="field_out booksubmit">
				<input type="submit" name="submit" value="Submit" class="button addfrmbutton"  />				
				<?php if($_SESSION['user_type'] == "user"){ ?>				
				  <a href="home_user.php" class="button">Cancel</a>				
				<?php }else{ ?>				
				  <a href="forum.php" class="button" style="float: right;">Cancel</a>				
				<?php } ?>
				
				</div>
				</form>
				</div>	
       
      
       <?php 	
		/*	$adv_right1 = @mysql_query("select * from `advertise` where page_name='add-forum-right1'");
			$advright1 =@mysql_fetch_array($adv_right1) ; 
			$right_img1 =substr($advright1['adv_img'],6);
			$right_adv_link1 = $advright1['adv_link'];  
			
			$adv_right2 = @mysql_query("select * from `advertise` where page_name='add-forum-right2'");
			$advright2 =@mysql_fetch_array($adv_right2) ; 
			$right_img2 =substr($advright2['adv_img'],6);
			$right_adv_link2 = $advright2['adv_link'];  */
		?>
     <!--  <div id="right2">
         <div class="advertise" style="margin-top:30px;">
          <a href="<?php echo $right_adv_link1;?>" target="_blank">
         		<img src="<?php echo $right_img1; ?>"  />
            </a>
         </div>
         <div class="advertise">
          <a href="<?php echo $right_adv_link2;?>" target="_blank">
         		<img src="<?php echo $right_img2; ?>"  />
            </a>
         </div>
       </div>-->
       		<script type="text/javascript">
       		function getcity(x)
		{	
			$.get('getcity_sign.php?state_id='+x, function(data) {
				$('#forumcit').html(data);
			});
		}
       		</script>
    </div>
    </div>
    </div>
    </div>
    <?php include('footer.php') ?>
<?php
}
else
{
$Obj->Redirect("login.php");
}
?>
