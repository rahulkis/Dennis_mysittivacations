<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_POST['create_security_code'])){
	
	echo rand(1000,9999);
	die;
}


$titleofpage = "Add Event";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

// echo date('Y-m-d H:i:s');

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if($userType=='user' || !isset($_SESSION['user_id']) ){
	$Obj->Redirect("index.php");
}

$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;

$merchantID = $userArray[0]['merchant_id'];



?>

<style>
span.formw {
    float: right;
    text-align: left;
    width: 480px;
}
div.row {
    clear: both;
    padding-top: 5px
}


i.addRow {
	float: left;
	font-size: 20px;
	text-align: center;
	vertical-align: middle !important;
	width: 10%;
}

#addeventform .row .formw input[type="text"] {
	float: left;
	width: 100% ;
}

.addRow > img {
 	width: 20px;
}

#ticket_module, #pass_module{ display: none; }
</style>
<?php

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

<script type="text/javascript">
$(document).ready(function(){
        $('#add_streaming_ticket').click(function(){
            if($(this).prop("checked") == true){
                $('#ticket_module').show();
            }
            else if($(this).prop("checked") == false){
				$('#ticket_module').hide();
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
			$('#pass_module').hide();
			$('#max_download').val('');
			$('#amount').val('');
		}
	});
		
	$(".restrict_text").keypress(function (e) {
	   //if the letter is not digit then display error and don't type anything
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				 return false;
	  }
	 });

	$("input[type='radio']#yes_id").click(function(){
	      if($(this).attr("value")=="yes") {
	        $(".formw.open_yesDiv").show();
	      } 
	});
	$("input[type='radio']#no_id").click(function(){
		if($(this).attr("value")=="no") {
			$(".open_yesDiv").hide();
		}
	});

	$("input[type='radio']#yes_id2").click(function(){
	      if($(this).attr("value")=="yes2") {
	        $(".formw.open_ticketDiv").show();
	      } 
	});
	$("input[type='radio']#no_id2").click(function(){
		if($(this).attr("value")=="no2") {
			$(".open_ticketDiv").hide();
		}
	});

	$("input[type='radio']#yes_id3").click(function(){
	      if($(this).attr("value")=="yes3") {
	        $(".formw.open_artistDiv").show();
	      } 
	});
	$("input[type='radio']#no_id3").click(function(){
		if($(this).attr("value")=="no3") {
			$(".open_artistDiv").hide();
		}
	});
});
</script>
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


		$getCityHost = mysql_query("SELECT cc.*,clubs.club_address,clubs.type_of_club FROM  `capital_city` as cc, `clubs` as clubs WHERE `clubs`.`club_city` = `cc`.`city_id` AND `clubs`.`id` = '$userID' ");
		$fetchCityHost = mysql_fetch_assoc($getCityHost);
		$explode = explode($fetchCityHost['city_name'], $fetchCityHost['club_address']);
		$ClubAddress = trim($explode[0]);
		$ClubAddress = rtrim($ClubAddress,',');
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					<h3 id="title">Add Event</h3>
					<?php if($message['success'] != ""){ 

						echo '<div style="display:block;" id="successmessage" class="message" >'.$message['success']."</div>";
						}
						if($message['error'] != ""){ 

						echo '<div style="display:block;" id="errormessage" class="message" >'.$message['error']."</div>";
						} 

					?>

					<form style="max-width:100% !important;" method="POST" action="main/add_event.php" enctype="multipart/form-data" class="musicadd" id="addeventform" onsubmit="return validateForm_event_add();">

						<div class="row"> 
							<span class="label">
								<label >Enter Event Name:<b><font color='red'><em></em></font></b></label>
							</span>
							<span class="formw">
								<input type="text" name="forum" class="txt_box" value="" required placeholder="Enter Event Name">
							</span>
						</div>

						<div class="row"> 
							<!-- <span class="label"><label >Event Image:<b><font color='red'><em></em></font></b></label></span> -->
							<span class="formw">
							<img src="images/camera1.png">
							<input type="file" style="color: #fff; width: 20%;" name="forum_img" class="txt_box" id="add_post_imgae" onchange="return ValidateFileUploadae()"/>

							<!-- <span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span> -->
							</span>
						</div>

							

						<div id="EventStartDiv">
							<div class="row">
								<div class="col-sm-6 userInfo">
																	
										<label >Start Date &amp; Time:<b><font color='red'><em></em></font></b></label>
										<input readonly value="" type="text" name="event_date[]" class="txt_box" id="event_start_date" placeholder="Start Date & Time" required >
								</div>
								<div class="col-sm-6 userInfo">		
										<label >End Date &amp; Time:<b><font color='red'><em></em></font></b></label>
										<!-- <input autocomplete="off" type="text" name="event_end_date[]" value="" class="txt_box" id="event_end_date" placeholder="End Date & Time"> -->
										<input readonly value="" type="text" name="end_date" class="txt_box" id="event_end_date" placeholder="End Date & Time">
								
								</div>
							</div>
						</div> <!-- end Div EventStartDiv -->

						<div class="col-sm-12"> 
							<span class="label">

								<label >Description:<b><font color='red'><em></em></font></b></label>

							</span>
							<span class="formw">
								<div style="width:100%; overflow:auto;">
									<textarea id="eventDesc" name="event_description"  style="height:100px;" class="txt_box" required/></textarea>
								</div>
							</span>
						</div>
						

						<div class="row new_address">
							<div class="col-sm-6 userInfo">
								<span class="label">
								<label >Address:<b><font color='red'><em></em></font></b></label>
								</span>
								<?php $countrysql="select country_id,name from country where country_id IN ('223', '38')";
									$country_list = mysql_query($countrysql); ?>
									<span class="formw">
										<label>Country<b><font color='red'><em></em></font></b></label>
										   <select name="country_idd" id="country_idd" class="forumstate" onchange="showState_addevent(this.value);">

											<?php    while($row = mysql_fetch_array($country_list)){ ?>
											<option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
											<?php  } ?>
											</select>
									</span>

									<span class="formw">
										<label >Select Cities<b><font color='red'><em></em></font></b></label>
										<select multiple class="forumcity" name="forumcity[]" id="forumcit" onchange="getempty();" style="width: 100%;">
											<?php if(isset($_SESSION['state']) and $_SESSION['state'] != '')
											{
												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 
											}
											else
											{
												$allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";
											}
											
											$city_list1 = mysql_query($allcity);
											while($row_city = mysql_fetch_array($city_list1))
											{  
												if(strlen($row_city["city_name"]) > 2 && $row_city["city_name"] != "" && $row_city["city_name"] != " ")
												{
													?>
													<option value="<?php echo $row_city['city_id']; ?>" <?php if($_SESSION['id']==$row_city["city_id"]) { ?> selected="selected" <?php } ?>><?php echo $row_city["city_name"]; ?></option>
											<?php 	}
											}	?>
										</select>
									</span>
									<span class="formw"  >
										<label>Street Number<b><font color='red'><em></em></font></b></label>
										<input type="text" name="number" class="number_txt" />
									</span>
							</div>
							<div class="col-sm-6 userInfo">	
								<span class="formw">
									<label >State<b><font color='red'><em></em></font></b></label>
										<?php 
											$countrysql1="select zone_id,name from zone where country_id IN(".$_SESSION['country'].") and status ='1'";
											$country_list1 = @mysql_query($countrysql1);	
										?>
											<select class="forumstate" name="forumstate" id="forumst" onChange="getcity_addevent(this.value);" style="width: 100%;">
												<option value="">--Select State--</option>
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
									</span>
									
									<span class="formw">
										<label >Street Name<b><font color='red'><em></em></font></b></label>
										<input type="text" name="event_address" class="txt_box" required placeholder="Enter Street Address"/><?php //echo $ClubAddress; ?>
									</span>
							</div>
						</div>

						<?php $categorysql="SELECT * FROM `eventcategory`";
									$category_list = mysql_query($categorysql);      ?>
						<div class="row"> 
							<div class="col-sm-6 userInfo">
								<span class="label">
									<label>Event Category:<b><font color='red'><em></em></font></b></label>
								</span>
								<span class="formw"  >
								   <select name="category_id" id="category_id" class="forumstate" >
								   <option value="">--Select Caregory--</option>                         
									<?php    while($row = mysql_fetch_array($category_list)){ ?>
									<option <?php if($fetchCityHost['type_of_club'] == '101' && $row['id'] == '6' ){ echo 'selected';} ?>  value="<?php echo $row["id"]; ?>" ><?php echo $row["catname"]; ?></option>
									<?php  } ?>
									</select>
								</span>
							</div>	
						</div>
								
						<div class="row">
						<div class="col-sm-6 userInfo">
							<span class="label">
								<label >Recurring Event:<b><font color='red'><em></em></font></b></label>
							</span>
							<span class="formw">
								<input type="radio" name="recurring_yes" value="yes" id="yes_id" />Yes &nbsp;&nbsp;
								<input type="radio" name="recurring_yes" value="no" id="no_id" checked="checked" />No
							</span>
							<div class="row">
								<span class="label">
									<label> &nbsp; </label>
								</span>
								<span class="formw open_yesDiv" style="display: none;">
									<input type="radio" name="recurring_type" value="none" id="eventno" checked="checked" />No &nbsp;&nbsp;
									<input type="radio" name="recurring_type" value="weekly" id="eventweekly" />Weekly &nbsp;&nbsp;
									<input type="radio" name="recurring_type" value="repeat" id="repeat" />Repeat &nbsp;&nbsp;
									<input type="radio" id="recurring_type" value="cutom" name="recurring_type" />Custom&nbsp;&nbsp;
									<div class="RecurringMonth">
										<select name="weekNumber" id="WeekNumber" style="display:none">
											<option value="First">First</option>
											<option value="Second">Second</option>
											<option value="Third">Third</option>
											<option value="Last">Last</option>
										</select>
										<select name="weekDay" id="Weekday" style="display:none;" >
											<option value="Monday">Monday of every Month</option>
											<option value="Tuesday">Tuesday of every Month</option>
											<option value="Wednesday">Wednesday of every Month</option>
											<option value="Thursday">Thursday of every Month</option>
											<option value="Friday">Friday of every Month</option>
											<option value="Saturday">Saturday of every Month</option>
											<option value="Sunday" >Sunday of every Month</option>
										</select>
									</div>
								

									<div class="row NewRow_2" style="display:none;" id="repeat_input"> 
										
										<span class="formw">
											<i style="cursor:pointer;" class="addRow" onclick="addEventRow();"><input type="button" class="button" value="Add"/></i><br />
											<input placeholder="Episode 2" type="text" name="event_date[]" class="multipleEventAdd" id="NumRow_2" >
											<!-- <i style="cursor:pointer;" class="addRow" onclick="deleteEventRow('NumRow_0');">-</i> -->
										</span>
										<input type="hidden" id="CountRows" value="2" />
									</div>
								</span>
							</div>
							</div>
						</div>
						<style type="text/css">
							.RecurringMonth {
								float: left;
								width: 100%;
							}
							.RecurringMonth > select {
								margin: 2% 2% 2% 0;
								width: 40% !important;
							}
						</style>
						<script type="text/javascript">
							
							$('#recurring_type').click(function(){
								$('#WeekNumber,#Weekday').show();
								$('.NewRow_2').hide();
								$('#forumcit').prop('multiple',false);
							});
							$('#repeat').click(function(){
								$('.NewRow_2').show();
								$('#WeekNumber,#Weekday').hide();
								$('#forumcit').prop('multiple',false);
							});
							$('#eventno, #eventweekly').click(function(){
								$('#WeekNumber, #Weekday').hide();
								$('.NewRow_2').hide();
								$('#forumcit').prop('multiple',true);
							});
							function addEventRow()
							{
								var countrows = $('#CountRows').val();
								var ncountrows = parseInt(countrows) + 1;
								$('#CountRows').val(ncountrows);
								var URL = $('#siteURL').val();
								$.ajax({
									type: "POST",
									url: URL+"refreshajax.php",
									data: {
										'action': "getNewRow", 
										'rowscount' : countrows,
									},
									success: function( msg ) 
									{
										
										$('#repeat_input').append(msg);
									}
								});
								
							}
							function deleteEventRow(id)
							{
								var countrows = $('#CountRows').val();
								var ncountrows = parseInt(countrows) - 1;
								$('#CountRows').val(ncountrows);
								$('.NewRow_'+id).remove();
							}
						</script>

						<!-- <div class="row">
							<span class="label">
								<label>Selling Tickets <i>(optional)</i><b><font color="red"><em></em></font></b></label>
							</span>
							<span class="formw">
									<input type="radio" id="yes_id2" value="yes2" name="recurring_yes2">Yes &nbsp;&nbsp;
									<input type="radio" checked="checked" id="no_id2" value="no2" name="recurring_yes2">No
							</span>
							<span class="label">
								<label> &nbsp; </label>
							</span>
							<span class="formw open_ticketDiv" style="display: none;">
								<div class="row" id="assignDJS1"> 
									<span class="label">
										<label>Online Streaming Ticket :</label>
									</span>
									
									<span class="formw">
										<input <?php if(empty($merchantID)){ ?> onclick='addmerchantID("addEvent")'; <?php } ?> type="checkbox" id="add_streaming_ticket" name="add_streaming_ticket"/>
									</span>
									
									<span class="label">
										&nbsp;
									</span>
								</div>					
								
								<div id="ticket_module">
									<div class="row"> 
										<span class="label">
											<label >Max. Ticket Downloads : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											
											<input type="text" id="max_ticket_downloads" name="max_ticket_downloads" class="txt_box restrict_text" placeholder="Enter Number for Max. Ticket Download">
										</span>
									</div>
									<div class="row"> 
										<span class="label">
											<label >Ticket Price : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											
											<input type="text" id="ticket_price" name="ticket_price" class="txt_box restrict_text" placeholder="Enter Ticket Price">
										</span>
									</div>
								</div>
								<div class="row" id="assignDJS2"> 
									<span class="label">
										<label>Door Entry Ticket :</label>
									</span>
									
									<span class="formw">
										<input <?php if(empty($merchantID)){ ?> onclick='addmerchantID("addEvent")'; <?php } ?> type="checkbox" id="add_pass_ticket" name="add_pass_ticket"/>
									</span>
									
									<span class="label">
										&nbsp;
									</span>
								</div>					
								
								<div id="pass_module">
									<div class="row"> 
										<span class="label">
											<label >Number of Tickets : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											
											<input type="text" id="max_download" name="max_download" class="txt_box restrict_text" placeholder="Enter Number of Tickets">

										</span>
									</div>
									<div class="row"> 
										<span class="label">
											<label >Ticket Price : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											
											<input type="text" id="amount" name="amount" class="txt_box" placeholder="Enter Ticket Price">
										</span>
									</div>
									<div class="row"> 
										<span class="label">
											<label >Expiry Date : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											
											<input type="text" id="c_exp_date" name="c_exp_date" class="txt_box restrict_text dtpicker" placeholder="Select Expiry Date">
										</span>
									</div>
									<div class="row"> 
										<span class="label">
											<label >Security Code : <b><font color='red'><em></em></font></b></label>
										</span>
										<span class="formw">
											<a onclick="create_securitycode();" style="color: rgb(254, 205, 7); text-decoration: none; margin-right: 10px;" href="javascript: void(0);">Click here to generate secuity code</a> <input style="width: 15% !important;" type="text" id="security_code" name="security_code" readonly>
										</span>
									</div>										
								</div>
							</span>	
						</div> -->
							
							

							
							
							
							
							 
							
							
							  
							
							
											
							
							
							<!-- <div class="row"> 
							<span class="label"><label >Event Video:<b><font color='red'><em></em></font></b></label></span>
							<span class="formw">
							<input type="file" style="color: #fff; width:100%;" name="forum_video" class="txt_box" id="add_post_videoae"  onchange="return ValidateVideoUploadae()"/> 
							<span class="text_allowed"> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)</span>
							</span>
							</div> -->
								
								<div class="row" id="assignDJS"> 
								<div class="col-sm-6 userInfo">
									<link rel="stylesheet" href="css/jukebox.css" />
									<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
									<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
									<script src="autocomplete/jquery.ajaxcomplete.js"></script>
									<script type="text/javascript">
									$(document).ready(function(){
										$('#clubs_autocomplete').autocomplete("refreshajax.php?action=clubs_search_events");
									});
									</script>
									<!--<span class="label">
										<label>Assign :</label>
									</span>-->
									<span class="label">
									<label>Feature Artist <i>(optional)</i><b><font color="red"><em></em></font></b></label>
									</span>
									<span class="formw">
										<input type="radio" name="recurring_yes3" value="yes3" id="yes_id3">Yes &nbsp;&nbsp;
										<input type="radio" name="recurring_yes3" value="no3" id="no_id3" checked="checked">No
									</span>
									<div class="row">
										<span class="label">
											<label> &nbsp; </label>
										</span>
										<span class="formw open_artistDiv" style="display: none;">
											<input type="text" name="assign_DJ" value="" class="txt_box" id="clubs_autocomplete" placeholder="Add MySitti artist to this event">
										</span>
									</div>	
								</div>
								</div>


								
							

							<div class="btncenter" >

							</div>
							
							<ul class="btncenter_new">
							<li><input type="submit" name="submit" value="Submit" class="button addfrmbutton"  /></li>
							<li><?php if($_SESSION['user_type'] == "user"){ ?>				
							<a href="home_user.php" class="button">Cancel</a>		
							<?php }else{ ?>				
							<a href="eventscalendar.php" class="button" style="float: right;">Cancel</a>				
							<?php } ?></li>
							</ul>
							<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 
							</form>

					<?php  /* CODED ADDED BY SUMIT 9-MARCH */ ?>
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
						$('#assignDJ').click(function(){
							if($(this).is(':checked'))
							{
								$('#assignDJfield').show();
							}
							else
							{
								$('#assignDJfield').hide();
							}
						});
					});

					function ValidateFileUploadae(){
							var check_image_ext = $('#add_post_imgae').val().split('.').pop().toLowerCase();
							if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
								alert('Event Image only allows file types of GIF, PNG, JPG and JPEG');
								$('#add_post_imgae').val('');
							}
					}

					function ValidateVideoUploadae(){
							var check_image_ext = $('#add_post_videoae').val().split('.').pop().toLowerCase();
								if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
									alert('Event Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
										$('#add_post_videoae').val('');
							}
					}
						
					function validateForm_event_add(){
						
						if ($('#forumst').val() == "") {
							alert("Please select state");
							return false;
						}
						
						if ($('#forumcit').val() == "") {
							alert("Please select city");
							return false;
						}

						var endDateTime= $('#event_end_date').val();
						var startDateTime= $('#event_start_date').val();

						var splitStartDate = startDateTime.split(' ');
						var splitEndDate = endDateTime.split(' ');

						var startDateArray = splitStartDate[0].split('-');
						var endDateArray = splitEndDate[0].split('-');

						var startDateTime = new Date(startDateArray[0] + '/ ' + startDateArray[1] + '/' + startDateArray[2] + ' ' + splitStartDate[1]);
						var endDateTime = new Date(endDateArray[0] + '/ ' + endDateArray[1] + '/' + endDateArray[2] + ' ' + splitEndDate[1]);

						if (startDateTime > endDateTime) {
							alert('Event End date should be greater than Event Start date.');
							return false;
						}
						else {
							//$("#Error").text('Success');
						}		


					}

					function  disables()
					{
						if(jQuery('#eventname').val()!='' && jQuery('#eventDate').val()!='' && jQuery('#description').val()!=''){
						
						jQuery("#addevent").attr('disabled',true);
						jQuery('#addeventform').submit();
					}
					}	
					 function cancelEdit(){
					   window.location='listevent.php'
					 }
					 
					function getempty()
					{
						$('#zipcode').val("");
					}
					
					function create_securitycode(){
						$.post('', {'create_security_code':'create_security_code'}, function(response){
						
							if (response != "") {
								$('#security_code').val(response);
							}
						
						});
					}
					</script>
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<?php include('Footer.php'); ?>