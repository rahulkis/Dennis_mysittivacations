<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_POST['create_security_code'])){
	
	echo rand(1000,9999);
	die;
}
$titleofpage = "Edit Event";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
	$Obj->Redirect("index.php");
	
}
if($userType=='user'){
	$Obj->Redirect("index.php");
}

$sql = "select type_of_club from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;

if($userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}

if(isset($_POST['updateEvent'])){

			$eventname = $_POST['eventname'];
			$eventDate = $_POST['eventDate'];
			$eventDate = date('Y-m-d', strtotime($_POST['eventDate']));
			
			$description=$_POST['description'];
			$date = date('Y-m-d H:i:s');
			
			$end_date = $_POST['event_end_date'];
			
			$postdate = trim($eventDate);
			
			$postDate = str_replace("/","-",$eventDate);
			
			$pdate = strtotime($postDate);
			
			$curdate = date('d-m-Y');
			$cdate = strtotime($curdate);
			
			
			$row_id = $_POST['row_id'];
			$eventDate = date('Y-m-d', $pdate);
			
			if(trim($cdate) > trim($pdate)){
			
				$message['error'] = "Please select current or future date. ";
			}else{
				
					$sql="update `events` SET dj_id = '$djID' ,event_end_date = '$end_date',eventname='$eventname', date='$eventDate', description='$description' , modified_date='$date' where id='$row_id'";exit;
					
					mysql_query($sql);	
					
					$time=strtotime($eventDate);
					$month=date("F",$time);
					$year=date("Y",$time);
					
					// store session data
					$_SESSION['year_Edit']=$year;
					$_SESSION['month_Edit']=$month;
					$_SESSION['eventedited']="yes";
					$Obj->Redirect("eventscalendar.php");
			}

}

if($_GET['edit']){
	
$sql = 'SELECT * FROM `events` where id="'.$_GET['edit'].'"';
$retval = mysql_query($sql);
$row_result = mysql_fetch_array($retval);


}else{
$Obj->Redirect("listevent.php");
}
?>

<!--<script src='js/jquery.validate.js'></script>
<script src="js/register.js" type="text/javascript"></script>-->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({
			selector:'.formw #eventDesc',
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
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(!isset($_GET['host_id']))
		{
			include('club-right-panel.php');	
		}
		else
		{ 
			include('host_left_panel.php');
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					
					<h3 id="title">Edit Event</h3>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" style="display:block;" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" style="display:block;" class="message" >'.$message['error']."</div>";
					} 

					?>
					
					
					
					<form style="max-width:100%;" method="POST" action="main/edit_event.php" enctype="multipart/form-data" class="musicadd" id="addeventform" onsubmit= "return validateForm_event_add();">
				<div class="row"> 
					<span class="label">
						<label >Event Name:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
						<input type="text" name="forum" class="txt_box" value="<?php echo $row_result['eventname'] ;?>" required >
					</span>
				</div>
				<div class="row"> 
					<span class="label">
						<label >Event Address:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw"  >
						<!--<div style="width:100%; overflow:auto;">-->
						<textarea name="event_address" style="height:50px;"  class="txt_box" required placeholder="Enter Street Address Only"/><?php echo $row_result['event_address'] ;?></textarea>
					     <!--</div>-->
					</span>
				</div>
				
				
				<?php $categorysql="SELECT * FROM `eventcategory`";
                        $category_list = mysql_query($categorysql);      ?>
				<div class="row"> 
					<span class="label">
						<label>Event Category:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw"  >
                       <select name="category_id" id="category_id" class="forumstate" >                         
                        <?php    while($row = mysql_fetch_array($category_list)){ ?>
                        <option  value="<?php echo $row["id"]; ?>" <?php if($row_result['category_id']==$row["id"]){ ?> selected="selected" <?php } ?> ><?php echo $row["catname"]; ?></option>
                        <?php  } ?>
                        </select>
					</span>
				</div>
				
				 <?php $countrysql="select country_id,name from country where country_id IN ('223','38')";
                        $country_list = mysql_query($countrysql);      ?>
				<div class="row"> 
					<span class="label">
						<label>Country:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw"  >
                       <select name="country_idd" id="country_idd" class="forumstate" onchange="showState_addevent(this.value);">
                        <option value="">- - Select - -</option>
                        <?php    while($row = mysql_fetch_array($country_list)){ ?>
                        <option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
                        <?php  } ?>
                        </select>
					</span>
				</div>
				
				
				
				<div class="row"> 
					<span class="label">
						<label >State :<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
				<?php 
						 	$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1'";
   							$country_list1 = @mysql_query($countrysql1);	?>
                            <select class="forumstate" name="forumstate" id="forumst" onChange="getcity_addevent(this.value);" style="width: 100%;">
							<option value="">------- Select -------</option>
				              <?php
                    						while($row = @mysql_fetch_array($country_list1))
                    						{
                    							if($row['zone_id'] == $row_result['state_id'])
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
							
					</span>
				</div>
				
				<div class="row"> 
					<span class="label">
						<label >Event posted in corresponding cities :<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<?php
						$city_check_array = array();
						$city_name_array = array();
						$get_same_ids = mysql_query("SELECT * FROM events WHERE common_identifier = '".$row_result['common_identifier']."'");
						while($ci_row = mysql_fetch_assoc($get_same_ids)){
							
							$gt_cityname = mysql_query("SELECT city_id, city_name FROM capital_city WHERE city_id = '".$ci_row['city_id']."'");
							while($gct_row = mysql_fetch_assoc($gt_cityname)){
								$city_check_array[] = $gct_row['city_id'];
								$city_name_array[] = "<a style='color: #fecd07;' href='listevent.php?county=".$ci_row['country_id']."&state=".$ci_row['state_id']."&city=".$gct_row['city_id']."'>".$gct_row['city_name']."</a>";
								
							}
						}
						
						$arr_c_un = array_unique($city_name_array);
						echo implode(' , ', $arr_c_un);
						?>
						<div class="button" style="float: right; cursor: pointer;" onclick="add_more_cities();">Add more cities</div>
					</span>
				</div>
				
				<div class="row" id="admore_cities" style="display: none;"> 
					<span class="label">
						<label >Select more cities to event :<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						
						<select multiple class="forumcity" name="other_forumcity[]" id="other_forumcity" onchange="getempty();" style="width : 100%;">
							<?php //	if(isset($_SESSION['state']) and $_SESSION['state'] != '')
							//{
							$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$row_result['state_id']."' order by c.city_name"; 
							//}
							//else
							//{
							//$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";
							//}
							
							$city_list1 = mysql_query($allcity);
							while($row_city = mysql_fetch_array($city_list1))
							{
								if(strlen($row_city["city_name"]) > 2 && $row_city["city_name"] != "" && $row_city["city_name"] != " ")
								{
									if(!in_array($row_city['city_id'] ,$city_check_array))
									{ ?>
										<option value="<?php echo $row_city['city_id']; ?>" ><?php echo $row_city["city_name"]; ?></option>
									
								<?php }
								}
							}	?>
						</select>						
						
					</span>
				</div>					

				<div class="row"> 
					<span class="label">
						<label >Event Start Date & Time:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<input type="text" name="event_date" value="<?php echo $row_result['date'] ;?>" class="txt_box" id="event_start_date" required >
					</span>
				</div>
				<div class="row"> 
					<span class="label">
						<label >Recurring Event:<b><font color='red'><em></em></font></b></label>
					</span>
					<span class="formw">
						<input <?php if($row_result['recurring'] == 'weekly'){ echo "checked";} ?> type="radio" name="recurring_type" value="weekly" />Weekly &nbsp;&nbsp;
						<input <?php if($row_result['recurring'] == 'monthly'){ echo "checked";} ?> type="radio" name="recurring_type" value="monthly" />Monthly&nbsp;&nbsp;
						<input <?php if($row_result['recurring'] == 'none'){ echo "checked";} ?> type="radio" name="recurring_type" value="none" />No
					</span>
				</div>
				<div class="row"> 
					<span class="label">
						<label >Event End Date & Time:</label>
					</span>
					<span class="formw">
						<input type="text" name="event_end_date" value="<?php if($row_result['event_end_date'] != '1970-01-01 00:00:00' && !empty($row_result['event_end_date'])){ echo $row_result['event_end_date']; }?>" class="txt_box" id="event_end_date" >
					</span>
				</div>
				<div class="row"> 
					<span class="label">

						<label >Event Description:<b><font color='red'><em></em></font></b></label>

					</span>
					<span class="formw">
												<!--<div style="width:100%; overflow:auto;">-->
				<textarea id="eventDesc" name="event_description"  style="height:100px;" class="txt_box" required /><?php echo $row_result['description'] ;?></textarea>
												<!--</div>-->
					</span>
				</div>
				<div class="row"> 
				<span class="label"><label >Event Image:<b><font color='red'><em></em></font></b></label></span>
				<span class="formw"><input type="file" style="color: #fff; width: 100%;" name="forum_img" class="txt_box" id="add_post_imgee" onchange="return ValidateFileUploadee()"/>
				<input type="hidden" name="event_image" id="event_image" value="<?php echo $row_result['event_image']; ?>" />
				<input type="hidden" name="event_image_thumb" id="event_image_thumb" value="<?php echo $row_result['event_image_thumb']; ?>" />
				<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span></span>
				<?php if($row_result['event_image'] != ''){
					
				$exp_img = explode('../', $row_result['event_image_thumb']);
					
				?>
                <img src="<?php echo $exp_img['1']; ?>" style="width:150px; height:150px;" />
                <?php } ?>
				</div>
				<div class="row"> 
				<span class="label"><label >Event Video:<b><font color='red'><em></em></font></b></label></span>
				<span class="formw">
					<input type="hidden" name="video_name" id="video_name" value="<?php echo $row_result['event_video']; ?>" />
                <input type="file" style="color: #fff; width:100%;" name="forum_video" class="txt_box" id="add_post_videoee"  onchange="return ValidateVideoUploadee()"/> 
				<span class="text_allowed"> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)</span>
				
				<?php if($row_result['event_video'] != ''){ ?>
				 <a href="#dialogx_event" name="modal" style="">
                     <?php $url = str_replace('../','',$row_result['event_video']);	    ?>
                        <div id="a_event"></div>
                        <script type="text/javascript">
                         jwplayer("a_event").setup({
                            file: "<?php echo $url;?>",
                            height : 200 ,
                            width: 200
                            });
                            </script>
				</a>
				<?php } ?>
				
				
				
				</span>
				</div>

				<?php 
					$getEventinfo = mysql_query("SELECT * FROM `dj_confirmation` WHERE `event_id` = '$_GET[edit]' ");
					$eventCount  = mysql_num_rows($getEventinfo);
					$fetchEventinfo = mysql_fetch_array($getEventinfo);

					$getDJid = $fetchEventinfo['dj_id'];
					$getDjinfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$getDJid' ");
					$fetchDJinfo = mysql_fetch_array($getDjinfo);
					$djName = $fetchDJinfo['club_name'];

					$sql_forfrnd=mysql_query("SELECT `id`,`club_name` FROM `clubs` WHERE `non_member` = '0' AND `type_of_club` = '97' AND `deactivate_account` = '0' ");
					$count_sqlforfrnd=mysql_num_rows($sql_forfrnd);
					$frnd_sqlforfrnd=array();

					$getassignDJ = mysql_query("SELECT * FROM `dj_confirmation` WHERE `event_id` = '$_GET[edit]'  ");
					$countassignDJ = mysql_num_rows($getassignDJ);
					if($countassignDJ > 0 )
					{
						while($fetchassignDJ = mysql_fetch_array($getassignDJ))
						{
							$assignDJS[] = $fetchassignDJ['dj_id'];
						}
						$row_forfrnd=mysql_fetch_array($sql_forfrnd);
					}


				?>


				<div class="row"> 
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#clubs_autocomplete').autocomplete("refreshajax.php?action=clubs_search_events");
});
function create_securitycode(){
	$.post('', {'create_security_code':'create_security_code'}, function(response){
	
		if (response != "") {
			$('#security_code').val(response);
		}
	
	});
}

</script>
					<span class="label">
						<label>Assign :</label>
					</span>
					<span class="formw">
						<input type="text" name="assign_DJ" value ="<?php echo $djName; ?>" class="txt_box" id="clubs_autocomplete" >
					</span>
					<span class="label">
						&nbsp;
					</span>
				</div>
				
				<?php 
					$EventID = $_GET['edit'];
					$getStreamingTickets = mysql_query("SELECT * FROM `streaming_tickets` WHERE `event_id` = '$EventID' ");
					if(mysql_num_rows($getStreamingTickets) > 0)
					{
						$resultsStreamingtickets = mysql_fetch_assoc($getStreamingTickets);
				?>
						<div class="row" id="assignDJS1"> 
							<span class="label">
								<label>Edit Online Streaming Ticket :</label>
							</span>
							
							<span class="formw">
								<input checked type="checkbox" id="add_streaming_ticket" name="add_streaming_ticket"/>
							</span>
							
							<span class="label">
								&nbsp;
							</span>
						</div>	

						<div id="ticket_module">
							<input type="hidden" name="StreamingTicketID" value="<?php echo $resultsStreamingtickets['id']; ?>" />
							<div class="row"> 
								<span class="label">
									<label >Max. Ticket Downloads : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
									<input value="<?php echo $resultsStreamingtickets['max_download'];?>" type="text" id="max_ticket_downloads" name="max_ticket_downloads" class="txt_box restrict_text">
								</span>
							</div>
							<div class="row"> 
								<span class="label">
									<label >Ticket Price : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
									<input value="<?php echo $resultsStreamingtickets['ticket_price'];?>" type="text" id="ticket_price" name="ticket_price" class="txt_box restrict_text">
								</span>
							</div>
						</div>
				<?php 	}else{ ?>
				
						<style type="text/css">
					   #ticket_module{ display: none; }
						</style>
				
				<?php }	?>

				<?php 
					$getPaidTickets = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$EventID' ");
					if(mysql_num_rows($getPaidTickets) > 0)
					{
						$resultsPaidTickets = mysql_fetch_assoc($getPaidTickets);
				?>
						<div class="row" id="assignDJS2"> 
							<span class="label">
								<label>Edit Entry Pass/Ticket :</label>
							</span>
							
							<span class="formw">
								<input checked type="checkbox" id="add_pass_ticket" name="add_pass_ticket"/>
							</span>
							
							<span class="label">
								&nbsp;
							</span>
						</div>					
							
						<div id="pass_module">
						<input type="hidden" name="PassTicketID" value="<?php echo $resultsPaidTickets['pass_id']; ?>" />
							<div class="row"> 
								<span class="label">
									<label >Number of Tickets : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
									<input value="<?php echo $resultsPaidTickets['no_of_tickets'];?>" type="text" id="max_download" name="max_download" class="txt_box restrict_text">

								</span>
							</div>
							<div class="row"> 
								<span class="label">
									<label >Ticket Price : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea>-->
									<input value="<?php echo $resultsPaidTickets['amount'];?>" type="text" id="amount" name="amount" class="txt_box">
								</span>
							</div>
							<div class="row"> 
								<span class="label">
									<label >Expiry Date : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<!--<textarea name="forum" style="width:100%;" class="txt_box" required/></textarea> class="dtpicker"-->
									<input value="<?php echo $resultsPaidTickets['added_date'];?>" type="text" id="c_exp_date" name="c_exp_date" class="txt_box restrict_text dtpicker">
								</span>
							</div>
							<div class="row"> 
								<span class="label">
									<label >Security Code : <b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw">
									<a onclick="create_securitycode();" style="color: rgb(254, 205, 7); text-decoration: none; margin-right: 10px;" href="javascript: void(0);">Click here to generate security code</a> 
									<input value="<?php echo $resultsPaidTickets['security_code'];?>" style="width: 15% !important;" type="text" id="security_code" name="security_code" >
								</span>
							</div>										
						</div>
				<?php	}else{ ?>
				
						<style type="text/css">
					   #pass_module{ display: none; }
						</style>
				
				<?php } ?>


				<ul class="btncenter_new">
					<li>
						<input type="submit" name="submit" value="Submit" class="button addfrmbutton"  />
					</li>
					<li>				
					<?php if($_SESSION['user_type'] == "user"){ ?>				
					  <a href="home_user.php" class="button">Cancel</a>				
					<?php }else{ ?>				
					  <a href="eventscalendar.php" class="button" style="float: right;">Cancel</a>				
					<?php } ?>
					</li>
				</ul>
				<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 
				<input type="hidden" name="row_id" id="row_id" value="<? if($_GET['edit']) echo $_GET['edit']; ?>">
				<input type="hidden" name="common_identifier" value="<?php echo $row_result['common_identifier']; ?>">
				<input type="hidden" name="forumcity" value="<?php echo $row_result['city_id']; ?>">
				</form>

		 
<?php

/* CODED ADDED BY SUMIT 9-MARCH */

 ?>

 <style type="text/css">
/*#ticket_module, #pass_module{ display: none; }*/
 </style>
<script>
	var friendlist_forfrnd=new Array();
   
	<? if($frnd_sqlforfrnd){?>
	friendlist_forfrnd=<? echo json_encode($frnd_sqlforfrnd); ?>;
	
	<? } ?>
		
</script>

<!--<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>-->
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />

<script type="text/javascript">
$(document).ready(function(){
        $('#add_streaming_ticket').click(function(){
            if($(this).prop("checked") == true){
                $('#ticket_module').show();
            }
            else if($(this).prop("checked") == false){
				//$('#ticket_module').hide();
				$('#max_ticket_downloads').val('');
				$('#ticket_price').val('');
            }
        });
	$('#add_pass_ticket').click(function(){
		if($(this).prop("checked") == true)
		{
			$('#pass_module').show();
		}
		else if($(this).prop("checked") == false)
		{
			//$('#pass_module').hide();
			$('#max_download').val('');
			$('#amount').val('');
			$('#c_exp_date').val('');
			$('#security_code').val('');
		}
	});
		
	$(".restrict_text").keypress(function (e) {
	   //if the letter is not digit then display error and don't type anything
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				 return false;
	  }
	 });		
});

	function ValidateFileUploadee(){
			var check_image_ext = $('#add_post_imgee').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Event Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#add_post_imgee').val('');
			}
	}
	
	function ValidateVideoUploadee(){
			var check_image_ext = $('#add_post_videoee').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Event Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#add_post_videoee').val('');
			}
	}
	
function validateForm_event_add(){
	
	// if ($('#country_idd').val() == "") {
	// 	alert("Please select country");
	// 	return false;
	// }	
	
	// if ($('#forumst').val() == "") {
	// 	alert("Please select state");
	// 	return false;
	// }
	
	// if ($('#forumcit').val() == "") {
	// 	alert("Please select city");
	// 	return false;
	// }	
	var endDateTime= $('#event_end_date').val();
	var startDateTime= $('#event_start_date').val();

	var splitStartDate = startDateTime.split(' ');
	var splitEndDate = endDateTime.split(' ');

	var startDateArray = splitStartDate[0].split('-');
	var endDateArray = splitEndDate[0].split('-');

	var startDateTime = new Date(startDateArray[0] + '/ ' + startDateArray[1] + '/' + startDateArray[2] + ' ' + splitStartDate[1]);
	var endDateTime = new Date(endDateArray[0] + '/ ' + endDateArray[1] + '/' + endDateArray[2] + ' ' + splitEndDate[1]);




	// if (startDateTime > endDateTime) {
	//     alert('Event End date should be greater than Event Start date.');
	//     return false;
	// }
	// else {
	//     //$("#Error").text('Success');
	// }
	
}

 function cancelEdit(){
   window.location='listevent.php'
 }
 
 function add_more_cities(){
	$('#admore_cities').show();
	return false;
 }

function getempty()
{
	$('#zipcode').val("");
}
</script>					
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<?php include('Footer.php'); ?>