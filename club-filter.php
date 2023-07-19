<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
// if(!isset($_SESSION['user_id'])){
// $Obj->Redirect("login.php");
// }
error_reporting(0);

unset($_SESSION['main_clubs_filter1']);
unset($_SESSION['main_clubs_filter']);
unset($_SESSION['inner_clubs_filter1']);
unset($_SESSION['inner_clubs_filter']);
unset($_SESSION['miles']);
//unset($_SESSION['longitude']);
//unset($_SESSION['latitude']);



$sql_main_club=mysql_query("select * from club_category where parrent_id='0' ORDER BY name ASC");

   if(isset($_POST['filter']))
  {

	
		$_SESSION['filtered_values'] = "set";
	
		$first_array = array();
		$second_array = array();
		
		$first_array1 = array();
		$second_array1 = array();
	
		foreach($_POST['inner_clubs'] as $single_club){
			
			$exp = explode("_main_" , $single_club);
			
			
			$first_array[] = $exp[0];
			$second_array[] = $exp[1];

		}
		
			
		foreach($_POST['mian_clubs'] as $single_club){
			
			$exp = explode("_main_" , $single_club);
			
			
			$first_array1[] = $exp[0];
			$second_array1[] = $exp[1];

		}

	$final_main_club_array = array_unique($first_array);
	$final_inner_club_array = array_unique($second_array);
	
	$implod_inner_array = implode("','",$final_inner_club_array);
	
	$last_inner_club_array = "'$implod_inner_array'";
	
	
	$final_main_club_array1 = array_unique($first_array1);
	$final_inner_club_array1 = array_unique($second_array1);
	
	$implod_inner_array1 = implode("','",$final_inner_club_array1);
	
	$last_inner_club_array1 = "'$implod_inner_array1'";

	
		if(!empty($_POST['other_miles'])){ $_SESSION['miles']=$_POST['other_miles']; }
		if(!empty($_POST['miles'])){ $_SESSION['miles']=$_POST['miles']; }
		
		if(!empty($_POST['longitude'])){ $_SESSION['longitude']=$_POST['longitude']; }
		if(!empty($_POST['latitude'])){ $_SESSION['latitude']=$_POST['latitude']; }
		
		if(!empty($final_main_club_array)){ $_SESSION['main_clubs_filter'] = implode(",",$final_main_club_array); }
		if(!empty($final_inner_club_array)){ $_SESSION['inner_clubs_filter'] = $last_inner_club_array; }
		
		
		if(!empty($final_main_club_array1)){ $_SESSION['main_clubs_filter1'] = implode(",",$final_main_club_array1); }
		if(!empty($final_inner_club_array1)){ $_SESSION['inner_clubs_filter1'] = $last_inner_club_array1; }
	  
	  //
	  //echo "<pre>";
	  //print_r($_SESSION);
	  //echo "</pre>";
	  //die;
	  
	  echo "<script>self.close();window.opener.location.reload();</script>";
  }
?>

<style>
.cl_filter {
    float: left;
    margin-top: 10px;
    width: 100%;
}

.cl_filter span {
    float: left;
    width: 12%;
}


#locator {
    float: left;
}

#loc_checkbox {
    float: left;
    width: 25px;
}

#auto_loc {
    float: left;
    margin-left: 15px;
    width: 10px;
}

#first_address {
    float: left;
    width: 25%;
}

#or_select {
    float: left;
    margin-top: 15px;
    width: 100%;
}

.upper_main {
    float: left;
    width: 100%;
}

.upper_inner {
    float: left;
    margin-left: 2%;
    width: 99%;
}

.upper_main > li {
    float: left;
    width: 100%;
}

.upper_inner > li {
    float: left;
    width: 100%;
}

#other_miles {
    float: left;
    margin-left: 20px;
    width: 25%;
}

select {
    float: left;
}

.selectize-control.single .selectize-input:after {
    border-color: #808080 transparent transparent;
    border-style: solid;
    border-width: 5px 5px 0;
    content: " ";
    display: block;
    height: 0;
    margin-top: -3px;
    position: absolute;
    right: 15px;
    top: 50%;
    width: 0;
}
.selectize-input:after {
    clear: left;
    content: " ";
    display: block;
}
.selectize-control.single .selectize-input, .selectize-dropdown.single {
    border-color: #b8b8b8;
}
.selectize-control.single .selectize-input {
    background-color: #f9f9f9;
    background-image: linear-gradient(to bottom, #fefefe, #f2f2f2);
    background-repeat: repeat-x;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.05), 0 1px 0 rgba(255, 255, 255, 0.8) inset;
}
.selectize-control.single .selectize-input, .selectize-control.single .selectize-input input {
    cursor: pointer;
}
.selectize-input {
    border: 1px solid #d0d0d0;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1) inset;
    box-sizing: border-box;
    display: inline-block;
    overflow: hidden;
    padding: 8px;
    position: relative;
    width: 100%;
    z-index: 1;
}
.selectize-input, .selectize-control.single .selectize-input.input-active {
    background: none repeat scroll 0 0 #ffffff;
    cursor: text;
    display: inline-block;
}
.selectize-dropdown, .selectize-input, .selectize-input input {
    color: #303030;
    font-family: inherit;
    font-size: 13px;
    line-height: 18px;
}

.selectize-control.single .selectize-input, .selectize-control.single .selectize-input input {
    cursor: pointer;
}
.selectize-input > input {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    border: 0 none !important;
    box-shadow: none !important;
    display: inline-block !important;
    line-height: inherit !important;
    margin: 0 1px !important;
    max-height: none !important;
    max-width: 100% !important;
    min-height: 0 !important;
    padding: 0 !important;
    text-indent: 0 !important;
}
.selectize-dropdown, .selectize-input, .selectize-input input {
    color: #303030;
    font-family: inherit;
    font-size: 13px;
    line-height: 18px;
}
.selectize-input > * {
    display: inline-block;
    vertical-align: baseline;
}
.popupContainer {width:100%; max-width:400px; margin:auto; position:absolute; left:0; right:0; top:0; bottom:0; border:1px solid #fecd07}
@media only screen and (max-width:479px) {
 .popupContainer {max-width:280px;}
}
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<script src="js_validation/add_contest.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js_validation/add_contest.js" type="text/javascript"></script>
<script src="http://malsup.github.io/jquery.blockUI.js" type="text/javascript"></script>
<script src="js/selectsize/selectize.js"></script>
<script src="js/selectsize/index.js"></script>

<script type="text/javascript">	
function get_current_val(val){
	  if (val == "other") {
			$('#other_miles').show();
	  }else{
		      $('#other_miles').hide();
			  $('#other_miles').val('');
	  }
   }   
function check_inner_checkboxes(id){
   	
	
	$('ul#inner_'+id).slideToggle('slow');

   	if ( $(".main_"+id).prop( "checked" ) )
   	{
	  
	  	$(".inner_"+id).prop("checked", true);
	}
	else
	{
	   	$(".inner_"+id).prop('checked', false);
  	}
}   
   
function get_address(){
   $('#location_finder').attr('checked', false);
   
   var address =  $('#first_address').val();
   
          $.blockUI({ css: {
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#fecd07', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: 'black' 
        },
		message : "Searching Location"
		});
		
		jQuery.post('ajaxcall.php', {'search_address':address}, function(response){

			var res = response.split("&details&");
			
			$('#latitude').val(res[0]);
			$('#longitude').val(res[1]);
		 
			setTimeout($.unblockUI, 2000); 
		 });
   }   
$(document).ready(function() {
	
	$('#select-beast').selectize({
		create: true
	});
	
	
   
   $('#location_finder').click(function(){
		if ($("#location_finder").prop("checked")) {
		  $('#first_address').val("");
   
			$.blockUI({ css: {
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#fecd07', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: 'black' 
			},
			message : "Sharing your current location with mysitti.com"
			});
			
			jQuery.post('ajaxcall.php', {'remote_address':'<?php echo $_SERVER['REMOTE_ADDR']; ?>'}, function(response){
			   
			   var res = response.split("&details&");
			   
				$('#latitude').val("");
				$('#longitude').val("");			   
			   
			   $('#latitude').val(res[0]);
			   $('#longitude').val(res[1]);
			
			  setTimeout($.unblockUI, 2000); 
			 });
	  }
	 });
		 
   $('#auto_loc').click(function() {
   $('#first_address').val("");

	  $.blockUI({ css: {
		  border: 'none', 
		  padding: '15px', 
		  backgroundColor: '#fecd07', 
		  '-webkit-border-radius': '10px', 
		  '-moz-border-radius': '10px', 
		  opacity: .5, 
		  color: 'black' 
	  },
	  message : "Sharing your current location with mysitti.com"
	  });
	  
	  jQuery.post('ajaxcall.php', {'remote_address':'<?php echo $_SERVER['REMOTE_ADDR']; ?>'}, function(response){
		 
			var res = response.split("&details&");
			
			$('#latitude').val("");
			$('#longitude').val("");
			
			$('#latitude').val(res[0]);
			$('#longitude').val(res[1]);		 
			
			setTimeout($.unblockUI, 2000); 
	   });
  
}); 
}); 
</script>
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script> 
<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".filter").smk_Accordion({
				closeAble: true, //boolean
		
			});			
		});
	</script> 

 <div id="modal" class="popupContainer" >
		<section class="popupBody">
		 
      <div id="title" class="popuptitle"><h2  style="border-bottom: 1px solid #808080;
    color: #FECD07;
    float: left;
    font-size: 22px;
    padding: 10px 0;
    text-align: left;
    width: 100%;">Filter</h2></div>
			<!-- Social Login -->
			<div class="user_register" style="float: left; width: 100%;margin: 20px 0;" >
				
				<?php
				if($_SESSION['user_type'] == "user"){
					
						$get_lat_lon = mysql_query("SELECT longitude, latitude FROM user WHERE id ='".$_SESSION['user_id']."'");
						while($lat_long_row = mysql_fetch_assoc($get_lat_lon)){
							
							$current_user_longitude = $lat_long_row['longitude'];
							$current_user_latitude = $lat_long_row['latitude'];
							
						}
					
					}else{
						

						$get_lat_lon = mysql_query("SELECT longitude, latitude FROM clubs WHERE id ='".$_SESSION['user_id']."'");
						while($lat_long_row = mysql_fetch_assoc($get_lat_lon)){
							
							$current_user_longitude = $lat_long_row['longitude'];
							$current_user_latitude = $lat_long_row['latitude'];
						
					}
				}
				?>
          
                    <form id="filtersearchpop" name="add_contest" onsubmit="return validate_contest1();"  method="post"  enctype="multipart/form-data">
						<div class="cl_filter" id="milesfield">
						   <span>Number of Miles :</span>
						   <select name="miles" id="select-beast" class="demo-default" placeholder="Select">
							  <option value="">Select</option>
							  <?php for($i=0.5; $i<=12; $i+=0.5){ ?>
							   <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							  <?php } ?>
						   </select>
						   
			<!--			
							 <select name="add_contest" id="select-beast" class="demo-default" placeholder="Select a person...">
								 <option value="">Select a person...</option>
								 <option value="4">Thomas Edison</option>
								 <option value="1">Nikola</option>
								 <option value="3">Nikola Tesla</option>
								 <option value="5">Arnold Schwarzenegger</option>
							 </select>						   
						   -->
						   
						   
						   
						</div>

						<div class="cl_filter">
						   <span>From this Address:</span>
						   <!--input type="text" name="address" id="first_address" placeholder="Address, City, State, Zip Code" onchange="get_address();">
						-->
							<textarea rows="5" id="first_address" name="address" placeholder="Address, City, State, Zip Code" onchange="get_address();"></textarea>
						</div> 
<!--						
						<div id="or_select"> or </div>

						<div class="cl_filter">
						   <span>From this location : </span>
						   <span id="loc_checkbox"><input type="checkbox" id="location_finder"></span>
						   <label id="locator">Auto Locator </label><div id="auto_loc" style="cursor: pointer;">&#63</div>
						</div>-->
						 
                        <!--<label>Miles :</label>  <input  name="miles" size="20" type="text" style="width:10%;" />-->
                        <br>
                          <?php //while($clubs=@mysql_fetch_assoc($sql_main_club)) { ?>
                      
                      	<!--<input type="checkbox" name="clubs[]" value="<?php  echo $clubs['id'];  ?>">  <?php  echo $clubs['name'];  ?>   <br> <br>-->
                        <? //} ?>
						
						
									
						   <ul class="upper_main filter1">
						   
							  <?php while($row = mysql_fetch_assoc($sql_main_club)){  ?>
							  
								 <li id="main_<?php echo $row['id'];?>">
									
									<input onclick="check_inner_checkboxes('<?php echo $row['id']; ?>');" class="main_<?php echo $row['id']; ?>" type="checkbox" name="mian_clubs[]" value="<?php echo $row['id']; ?>_main_<?php  echo $row['name'];  ?>">  <?php  echo $row['name'];  ?>
									
									<?php
									$sql_inner_main_club=mysql_query("select * from club_category where parrent_id='".$row['id']."' ORDER BY name ASC");
									
									?>
									   <ul class="upper_inner" id="inner_<?php echo $row['id'];?>" style="display: none;"><?php
									   
									   while($row_inner = mysql_fetch_assoc($sql_inner_main_club)){ ?>
										  <li>
										  
										  <input class="inner_<?php echo $row['id']; ?>" type="checkbox" name="inner_clubs[]" value="<?php echo $row['id']; ?>_main_<?php  echo $row_inner['name'];  ?>">  <?php  echo $row_inner['name'];  ?>
										  </li>
									   <?php } ?>
									   </ul>
								 </li>
							  
							  <?php } ?>
							  
						   </ul>						
                       
					   
					   <input type="hidden" id="longitude" name="longitude" value="<?php echo $current_user_longitude; ?>">
					   <input type="hidden" id="latitude" name="latitude" value="<?php echo $current_user_latitude; ?>">
                        <div id="submit_btn"><input class="button" name="filter" type="submit" value="Filter" id="submit3" /> &nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Cancel"/></a></div>
                    </form>
			</div>

		</section>
	</div>
 

               
