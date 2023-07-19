<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

// get user groups 
  $get_groups=mysql_query("select g.group_name,g.id from  chat_users_groups as cgs 
   join chat_groups as g on(g.id=cgs.group_id) where user_id='".$_SESSION['user_id']."'");
// end here 
// get all friends
  $get_friends=mysql_query("select u.first_name,u.last_name,u.id from   friends as f 
   join user as u on(u.id=f.friend_id) where f.user_id 	='".$_SESSION['user_id']."' group by f.friend_id");
// end here 
?>
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

<script>
$(function() {
				  
 $('#datepicker_start').bind('copy paste cut',function(e) { 
 e.preventDefault(); //disable cut,copy,paste
 alert('cut,copy & paste options are disabled !!');
 });
 
  $('#datepicker_end').bind('copy paste cut',function(e) { 
 e.preventDefault(); //disable cut,copy,paste
 alert('cut,copy & paste options are disabled !!');
 });
  
   $('#datepicker_regi').bind('copy paste cut',function(e) { 
 e.preventDefault(); //disable cut,copy,paste
 alert('cut,copy & paste options are disabled !!');
 });
	
$( "#datepicker_start" ).datepicker({
changeMonth: true,
changeYear: true
});
});
$(function() {
$( "#datepicker_end" ).datepicker({
changeMonth: true,
changeYear: true
});
});
$(function() {
$( "#datepicker_regi" ).datepicker({
changeMonth: true,
changeYear: true
});
});
</script>

<script>
$(function() {
				  
                  <?php 
				  $i=0;
				  while($rs=@mysql_fetch_assoc($get_groups)) {
					  $val[$i]['id']=$rs['id'];
                	 $val[$i]['label']=$rs['group_name'];
					 $i++;
                  }
				 $js_array = json_encode($val); 
				 
				   ?>
		var availableTags = <?php echo $js_array ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt2').val($('#txt2').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
			
			   <?php 
				  $l=0;
				  while($rs2=@mysql_fetch_assoc($get_friends)) {
					  $val2[$l]['id']=$rs2['id'];
                	 $val2[$l]['label']=$rs2['first_name']." ".$rs2['last_name'];
					 $l++;
                  }
				 $js_array2 = json_encode($val2); 
				 
				   ?>
		var availableTags2 = <?php echo $js_array2 ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val2" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags2, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt_f').val($('#txt_f').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
	});
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
		
	}
}

function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}

function ValidateFileUpload(){
		var check_image_ext = $('#contest_img2').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Contest Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#contest_img2').val('');
		}
}
</script>
<style>
#modal{ overflow-x:hidden !important;}

#ui-datepicker-div{
	z-index: 99 !important;			  
}
</style>
<?php
include('image_upload_resize.php');

include('resize-class.php');

   if(isset($_POST['add_HostContest']))
  {
 
 	$host_id = $_SESSION['user_id'];
	
	$dateofbirth =$_POST['year']."-".$_POST['month']."-".$_POST['date'];
  	$contest_title=mysql_escape_string($_POST['contest_title']);
	$contest_desc=mysql_escape_string($_POST['contest_desc']);
	$contest_rule=mysql_escape_string($_POST['contest_rule']);
	
	$start_date=trim($_POST['contest_start']);
	$var_start=explode('/',$start_date);
	$contest_start=$var_start[2]."-".$var_start[0]."-".$var_start[1];
	
	$end_date=trim($_POST['contest_end']);
	$var_end=explode('/',$end_date);
	$contest_end=$var_end[2]."-".$var_end[0]."-".$var_end[1];
	
	$regi_date=trim($_POST['contest_regi']);
	$var_regi=explode('/',$regi_date);
	$contest_regi=$var_regi[2]."-".$var_regi[0]."-".$var_regi[1];
	
	 $contest_img= $_FILES["contest_img2"]["name"];
	 
	 if(!empty($contest_img)){
				  $tmp = $_FILES["contest_img2"]["tmp_name"];  
				  $path = "contest_img/".time().strtotime(date("Y-m-d")).$contest_img;
				  $thumbnail = "contest_img/thumb_".time().strtotime(date("Y-m-d")).$contest_img;
				  move_uploaded_file($tmp,$path);
				  
				   //indicate which file to resize (can be any type jpg/png/gif/etc...)
				 // $file = $path;
				  
				  //indicate the path and name for the new resized file
				//  $resizedFile = $thumbnail;
				  
				  //call the function (when passing path to pic)
				//  smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
				//  //call the function (when passing pic as string)
				//  smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );				  
			 	$file = $path;
						
				//indicate the path and name for the new resized file
				$resizedFile = $thumbnail;
				
				//call the function (when passing path to pic)
				//smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
				//call the function (when passing pic as string)
				//smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
				$resizeObj = new resize($file);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				$resizeObj -> resizeImage(300,200, 'auto');

				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);	
				  
				  
				  
	 }

	if((isset($_POST['country'])) && ($_POST['country'] != ""))
	{
		$contest_country=$_POST['country'];
		$contest_state=$_POST['state'];
		$contest_city=$_POST['city_name'];
	}
	else
	{
		$contest_country=$_SESSION['country'];
		$contest_state=$_SESSION['state'];
		$contest_city=$_SESSION['usercity'];
	}	
	
	$status = 1;
	$today = date("Y-m-d h:i:s");
	$ThisPageTable='contest';
	
	 $shout_type=$_POST['shout_type'];
				 if(isset($_POST['group']))
				 {
				   $groups=$_POST['group'];
				 }else
				 {
				   $groups="";
				 }
				  if(isset($_POST['friend']))
				 {
				   $friend=$_POST['friend'];
				 }else
				 {
				   $friend="";
				 }

	$ValueArray = array($host_id,$contest_title,$contest_desc,$contest_rule,$contest_start,$contest_end,$contest_regi,$path,$contest_country,$contest_state,$contest_city,$status,$today,$shout_type,$groups,$friend);	
	
	$FieldArray = array('user_id','contest_title','contest_desc','contest_rule','contest_start','contest_end','contest_regi','contest_img','contest_country','contest_state','contest_city','status','addedOn','challenge_type','group_id','friends_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				 $ValueArray_o = array($host_id,'content',$Success,$host_id);	
				 $FieldArray_o = array('user_id','cont_type','cont_id','owner_id');
				 $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_o,$FieldArray_o);
				 
				 $inserted_challenge_id = mysql_insert_id();
				 
	if($Success > 0)
	{
		 $challenge_added_on = date('Y-m-d h:i:s');
		 $c_identifier = "contest_".$inserted_challenge_id;
				 
		 if($shout_type=='public')
		 {
			 $get_fds=mysql_query("select f.friend_id from  friends as f 
			  where f.user_id ='".$_SESSION['user_id']."' AND friend_type='user' group by f.friend_id");
			   while($al_fr=@mysql_fetch_assoc($get_fds)){
				 $ValueArray_f = array($al_fr['friend_id'],'content',$Success,$host_id);	
				 $FieldArray_f = array('user_id','cont_type','cont_id','owner_id');
				 $Success2 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_f,$FieldArray_f);

				  mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$host_id."', '".$al_fr['friend_id']."', 'challenge', '".$challenge_added_on."', '1', '".$c_identifier."', 'user', 'user')");

	     		}
		 }else
		 {
			  if(isset($_POST['group']))
				 {
				  $g_user=mysql_query("SELECT user_id	FROM `chat_users_groups`WHERE `group_id` IN ( ".$_POST['group'].",0"." ) group by user_id");
				  while($al_gr=@mysql_fetch_assoc($g_user)){
				  $ValueArray_g = array($al_gr['user_id'],'content',$Success,$host_id);	
				   $FieldArray_g = array('user_id','cont_type','cont_id','owner_id');
				   $Success3 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_g,$FieldArray_g);
				   
				   mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$host_id."', '".$al_gr['user_id']."', 'challenge', '".$challenge_added_on."', '1', '".$c_identifier."', 'user', 'user')");
				   
			   		}
				 }
				  if(isset($_POST['friend']))
				 {
				   $friend=explode(",",$_POST['friend']);
				   for($i=0;$i<count($friend);$i++)
				   {
					   $ValueArray_pf = array($friend[$i],'content',$Success,$host_id);	
					   $FieldArray_pf = array('user_id','cont_type','cont_id','owner_id');
					   $Success4 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_pf,$FieldArray_pf);
					   
					   mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$host_id."', '".$friend[$i]."', 'challenge', '".$challenge_added_on."', '1', '".$c_identifier."', 'user', 'user')");
				   }
				 }
	      }
		  
		  $_SESSION['popup_add_post'] = "added";
		  echo "<script>opener.location.reload(true);self.close();</script>";	
	}
}

 ?>  
 <div id="modal" class="popupContainer" style=" width:99%;  height: auto; left: 1%;  top:5px;max-width:550px" >
		<header class="popupHeader">
			<span class="header_title">Add Challenge</span>

		</header>
		<section class="popupBody">
			<!-- Social Login -->
			<div class="user_register">
          
                    <form name="add_contest" onsubmit="return validate_contest1();"  method="post"  enctype="multipart/form-data">
               			<div>
                          <label>Contest Title:</label>
                        <textarea name="contest_title" style="width:98%" ></textarea>
                        </div>
                        
                        <div>
                        <label>Contest Description:</label>
                        <textarea  name="contest_desc" style="width:98%"></textarea>
                        </div>
                        
                        <div>
                        <label>Contest Rule:</label>
                       <textarea  name="contest_rule" style="width:98%"></textarea>
                        </div>
                        
                        <div>
                        <label>Contest Start Date:</label>
                       <input id="datepicker_start" name="contest_start"  type="text" style="width:22%; padding:0;" />
                        </div>
                        
                        <div>
                        <label>Contest Last Date:</label>
                        <input id="datepicker_end" name="contest_end" type="text"  onclick="Chk_Start_Date_exist();" style="width:22%; padding:0;"  />
                        </div>
                        
                        <div>
                          <label>Register Till Date:</label>
                          <input id="datepicker_regi" name="contest_regi" type="text " onclick="Chk_End_Date();" />
                        </div>
                        
                        <?php 
                        $countrysql="select country_id,name from country where country_id='223'";
                        $country_list = mysql_query($countrysql);
                        
                        ?>
                       <div>
                         <label>Default City</label>
                         <?php
						  $get_city_name=@mysql_query("select city_name from capital_city where city_id='".$_SESSION['usercity']."'"); 
						  $city_n=@mysql_fetch_assoc($get_city_name);
						 ?>
                         <?php echo $city_n['city_name']; ?> <a style="color: #FECD07;" href="javascript:void(0);" onclick="javascript:$('#city_panel').toggle();">[Change City] </a>
                         </div>

                         <div>
                       <div id="city_panel" style="display:none;">
                        <label>Country:</label>
                       <select class="option-1" name="country" id="country" onblur="Chk_Regi_Date();" onfocus="Chk_Regi_Date();" >
                        <!--<option value="">- - Select - -</option>-->
                        <?php 
                        while($row = mysql_fetch_array($country_list))
                        {
                        ?>
                        <option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <div>
                                <label>State:</label>
                               
                                <select class="option-1" name="state" id="state" onfocus="return validate_country();" onchange="getcity(this.value);">
                                <option value="">- -Select- -</option>
                                <?php 
                                $countrysql1="select zone_id,name from zone where country_id=223 and status ='1'";
                                $country_list1 = mysql_query($countrysql1);
                                ?>
                                
                                <?php 
                                while($row1 = mysql_fetch_array($country_list1))
                                {
                                ?>
                                
                                <option value="<?php echo $row1["zone_id"]; ?>"  ><?php echo $row1["name"]; ?></option>
                                <?php
                                }
                                
                                ?>
                                </select>
                                
                                </select>
                       </div>
                       
                       <div>
                                <label>City:</label>
                               <select class="option-1"  name="city_name" id="city_name" >
                                <option value="">- -Select- -</option>
                                <?php 
                                if(isset($_SESSION['state']) and $_SESSION['state'] != '')
                                {
                                $allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) where c.state_id ='".$_SESSION['state']."' order by c.city_name"; 
                                }
                                else
                                {
                                $allcity="select c.city_name,c.city_id,z.code from capital_city as c left join zone as z on(c.state_id=z.zone_id) order by c.city_name";}
                                $city_list1 = mysql_query($allcity);
                                ?>
                                
                                <?php 
                                while($row_city = mysql_fetch_array($city_list1))
                                {
                                ?>
                                
                                <option value="<?php echo $row_city["city_id"]; ?>" ><?php echo $row_city["city_name"]; ?></option>
                                <?php
                                }
                                
                                ?>
                                </select>
                                
                                </select> 
                                </div>					   
                        </div>
                        

                                </div>
                                
                        <div> 
                        <label>Contest Image:</label>
                        <input id="contest_img2" name="contest_img2" type="file" style="color: #fff;" onchange="return ValidateFileUpload()"/>
                        </div>
                        
                          <div class="optionbtns">
                               <label>Friends:</label>
                                <div>Public: <input type="radio" name="shout_type" checked="checked" value="public" onclick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();"  style="width: 20px !important;"></div>
                               <div> Private: <input name="shout_type"  value="private" onclick="javascript:$('#groups').show();$('#friends').show();$('#or').show();"   type="radio" style="width: 20px !important;"></div>
                            </div>
         
		  <div id="groups" style="display:none;">
                <label>Send To Groups:</label>
                <textarea cols="50" rows="5" id="search_val"></textarea>
                <input type="hidden" name="group" id="txt2">
                <div>Please type first few letters</div>
         </div>

            <div id="friends" style="display:none;">
            <label>Send To Friends:</label>
            <textarea cols="50" rows="5" id="search_val2"></textarea>
            <input type="hidden" name="friend" id="txt_f">
            <div>Please type first few letters</div>
            </div>
            
            <div id="submit_btn"><input class="button" name="add_HostContest" style="width: 151px;" type="submit" value="Add Challenge" id="submit3" /> &nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Cancel"/></a></div>
                    </form>
			</div>

		</section>
	</div>
 

               
