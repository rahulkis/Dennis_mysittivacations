<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

if(!isset($_SESSION['user_id'])){

	$Obj->Redirect("login.php");

}
?>


<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="google-site-verification" content="o-g5OxxDOWX2F__eELEb5UVS1lDerXIIc1hVhtJ4PpE" />
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<!-- ======== Include Main Stylesheet ===============  -->
<link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css">
<link href="css/stylesNew.css" rel="stylesheet"  type="text/css">
<link href="css/v2style.css" rel="stylesheet" type="text/css">
<link href="css/v1style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">

<link href="css/media.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<link href="css/landingPagestyle.css" rel="stylesheet" type="text/css">
<link href="css/landingPageresponsive.css" rel="stylesheet" type="text/css">
<link href="css/landingPagejquery.bxslider.css" rel="stylesheet" type="text/css">

<!-- ======== Include Main Javascript Library ===============  -->

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-migrate-1.0.0.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script>
<script src="js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="js/add.js" type="text/javascript"></script>

<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript" src="QapTcha-master/jquery/jquery-ui.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>

<script src="js/custom.js"></script>
<script src="js/functions.js"></script>
<script type="text/javascript" src="jwplayer-7.2.4/jwplayer.js"></script>

<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script type="text/javascript" src="js/chat.js"></script>
<script src="js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<link rel="stylesheet" href="lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox2-master/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" href="css/jslider.css" type="text/css">
	<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
	<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
	<script type="text/javascript" src="js/tmpl.js"></script>
	<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
	<script type="text/javascript" src="js/draggable-0.1.js"></script>
	<script type="text/javascript" src="js/jquery.slider.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>

<link href="datepick/foundation-datepicker.css" rel="stylesheet" type="text/css">
<script src="../datepick/foundation-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="emoji/emoji.css" type="text/css">
<script src="emoji/config.js"></script>
  <script src="emoji/util.js"></script>
  <script src="emoji/jquery.emojiarea.js"></script>
  <script src="emoji/emoji-picker.js"></script>

<meta name='B-verify' content='fc452fae810405f1fa3a7dba61393529df536296' />



<?php

$del_id = $_GET['id'];

if($del_id !="")

{

	$shoutsql ="DELETE FROM shouts WHERE shout_id = $del_id";

	$shout_list = mysql_query($shoutsql);

	header('Location: shout.php');

}

if(isset($_SESSION['subuser']))

{

	$fetchhostquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$_SESSION['username']."' ");

	$fetres = @mysql_fetch_array($fetchhostquery);

	$user_id = $fetres['host_id'];

}

else

{

	$user_id =  $_SESSION['user_id'];	

}

	

$shout_list123 = @mysql_query("SELECT * FROM `shouts` WHERE `user_id` = '".$user_id."' AND user_type = 'club' ORDER BY `id` DESC ");

$countshouts = @mysql_num_rows( $shout_list123);



$array_1 = array();

$array_2 = array();

$main_arr = array();



while($cs_row = mysql_fetch_assoc($shout_list123))

{

	$array_1[] = $cs_row;

}



$user_host_shout = mysql_query("SELECT * FROM user_to_content INNER JOIN shouts ON user_to_content.cont_id = shouts.id WHERE user_to_content.friend_type = 'club' AND user_to_content.user_id = '".$_SESSION['user_id']."'");

while($uh_row = mysql_fetch_assoc($user_host_shout))

{

	$array_2[] = $uh_row;

}



if(empty($array_1) && !empty($array_2))

{

	$main_arr = $array_2;

}

elseif(empty($array_2) && !empty($array_1))

{

	$main_arr = $array_1;		

}

else

{

	function date_compare($a, $b)

	{

		$t1 = strtotime($a['added_date']);

		$t2 = strtotime($b['added_date']);

		return $t1 - $t2;

	}    





	$main_arr_first = array_merge($array_1,$array_2);

	usort($main_arr_first, 'date_compare');

	$main_arr = array_reverse($main_arr_first);

}



if(count($_POST['shoutschk']) > 0)

{

			

	$ids=implode(",",$_POST['shoutschk']);

	mysql_query("delete from forum where shout_id IN(".$ids.")");

	$sql_del=mysql_query("delete from shouts where id IN(".$ids.")");

	if($sql_del)

	{	

		$_SESSION['success']="Shouts deleted successfully";

		header('location:shout.php?msg=del'); exit;

	}

}



if(isset($_SESSION['success']))

{

	$success=$_SESSION['success'];

	unset($_SESSION['success']);

}



$titleofpage="Shouts";



// if(isset($_GET['host_id']))

// {

// 	include('NewHeadeHost.php');

// }

// else

// {

// 	include('NewHeadeHost.php');	

// }

$userType= $_SESSION['user_type'];



// echo "<pre>"; print_r($main_arr); exit;



?>

<div class="clear"></div>
<div class="v2_container">
  <div class="v2_inner_main"> 
    
    <!-- SIDEBAR CODE  -->
    
    <?php 

		// if(isset($_SESSION['subuser']))

		// { 

		// 	include('sub-right-panel.php'); 

		// }

		// else

		// { 

		// 	include('club-right-panel.php'); 

		// } 

	?>
    
    <!-- END SIDEBAR CODE -->
    
    <article class="forum_content v2_contentbar">
      <div class="v2_rotate_neg">
        <div class="v2_rotate_pos">
          <div class="v2_inner_main_content">
            <div id="wrapper" class="space">
              <h3 id="title">Shouts page </h3>
              <div id="ad_profile_pst">
                <form class="popupform" name="forum" action="add_shout.php" method="post" enctype="multipart/form-data">
                  <div class="ppost_newdesign">
                    <div class="shout_text shout-banner">
                      
                      <img src="images/shout-banner.png">

                      <h3>Shout Out</h3>
                      <p> 
                      We are making it very easy for you to increase the people who attend your shows. Everyone that follows you will be sent a message about your show in the form of a shout out.
                      </p>
                      
                      <div id="u_0_s" class="_6a _m"> <a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb"> <span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf"> <img src="images/upload_camera.png"> </i>Add Photo/Video<i class="_2wr"></i> </span>
                        <div class="_3jk shout_textarea">
                          <input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_n _5f0v" title="Choose a file to upload" name="shout_media" aria-label="Upload Photos/Video">
                          
                          <!-- <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()"> --> 
                          
                          <span style="display: none;" id="file_upload_successs"><img src="images/tick_green_small.png"></span> </div>
                        </a>

  <textarea id="add_post_text"  name="shout" class="txt_box clear_flds" /></textarea>
                          <div class="post_shout_button">
                    		  <div id="" class="pst_buttons">
                       				 <input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />
                      			</div>
                   			 </div>
                    </div>
                         </div>
                    
                
                  </div>
                </form>
              </div>
              <?php 

					if($_GET['msg'] == "del")

					{

						echo 	'<div style="display:block;" id="successmessage" class="message" >Shout deleted successfully</div>';

					}

					if($_GET['msg'] == "update")

					{

						echo 	'<div style="display:block;" id="successmessage" class="message" >Shout updated successfully</div>';

					}

					if($_GET['msg'] == "add")

					{

						echo 	'<div style="display:block;" id="successmessage" class="message" >Shout added successfully</div>';

					}

					?>
              <script type="text/javascript">

								$(function(){

									$('#selectall').click(function() {

										if ($('#selectall').is(':checked')) {

											$('.others').attr('checked', true);

										} else {

											$('.others').attr('checked', false);

										}

									});

								});

							</script> 
              <br>
              <div id="demosss">
                <div class="autoscroll">
                  <form name="shout_frm" id="shout_frm" method="post" onsubmit="return chkvalidationdel()">
                    <table  class="display" id="example" style="margin-top:10px;">
                    <thead>
                      <tr bgcolor="#CCCCCC">
                        <th width="120"> <INPUT TYPE=CHECKBOX NAME="all" id="selectall" width="100">
                          <a class="delete_shout" href="javascript:void(0);" onclick="javascript:$('#shout_frm').submit();"> Delete All</a> </th>
                        <th width="15%">Shout By</th>
                        <th>Shouts</th>
                        <th>Added Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

										$i=0;

										if($main_arr)

										{

											foreach($main_arr as $row1)

											{

												if($row1['user_type']=='user') 

												{

													$sql_club=mysql_query("select * from user where id='".$row1['user_id']."'");

													$club_dtl=@mysql_fetch_assoc($sql_club);

													if($club_dtl['profilename'] == "")

													{

														$displayname = $club_dtl['first_name']." ".$club_dtl['last_name'];

													}

													else

													{

														$displayname = $club_dtl['profilename'];

													}

													$displaypic = $club_dtl['image_nm'];

													$anchor = "profile.php?id=".$club_dtl['id'];												

												}

												else

												{

													$sql_club=mysql_query("select * from clubs where id='".$row1['user_id']."'");

													$club_dtl=@mysql_fetch_assoc($sql_club);

													$displayname = $club_dtl['club_name'];

													$displaypic = $club_dtl['image_nm'];

													$anchor = "host_profile.php?host_id=".$club_dtl['id'];

												}										

									?>
                      <tr <?php if($i%2==0){?> class="odd" <?php } ?>>
                        <?php if($row1['friend_type'] != "club"){ ?>
                        <td><input type="checkbox" name="shoutschk[]" id="shoutschk" value="<?php echo $row1['id']; ?>" class="others"></td>
                        <?php }else{ ?>
                        <td></td>
                        <?php } ?>
                        <td><a href="<?php echo $anchor; ?>">
                          <?php  if($displaypic!="") {?>
                          <img src="<?php echo $displaypic; ?>" width="50" height="50">
                          <?php }else { ?>
                          <img src="images/no_image.jpg" height="50" width="50">
                          <?php } ?>
                          <br>
                          <?php echo $displayname; ?> </a></td>
                        <td><?php  	if($row1['user_id']==$user_id) 

											 		{

														$sql_clubtotal=mysql_query("select count(cont_id) as cnt from user_to_content where cont_id='".$row1['id']."' AND user_type = 'club' AND user_id != '".$_SESSION['user_id']."'");

														$club_dtltotal=@mysql_fetch_assoc($sql_clubtotal);

														$sql_clubread=mysql_query("select count(is_read) as cnt from user_to_content where cont_id='".$row1['id']."' and is_read=1 AND user_type = 'club' AND user_id != '".$_SESSION['user_id']."'");

														$club_dtlread=@mysql_fetch_assoc($sql_clubread);

											?>
                          <span class="shout_notification"> <? echo  $club_dtlread['cnt']."/". $club_dtltotal['cnt'];?> </span>
                          <? 			} 		?>
                          <p> <?php echo substr($row1['shout'],0,200); ?> <br>
                            <?php 
																//if(strlen($row1['shout']) > 200)
																//{
															?>
                            <a href="read_shout.php?id=<?php echo $row1['id']; ?>" style="color:red;" class="shout_read_more"> Read More.. </a>
                            <?php 	//}	?>
                          
                          <p> </td>
                        <td><?php echo  date('F jS  Y',strtotime($row1['added_date'])); ?></td>
                        <?php 		if($row1['friend_type'] != "club")

												{

										?>
                        <td style="width :100px;"><a href="edit_shout.php?id=<?php echo $row1['id']; ?>" > <img src="images/Edit.png" width="25px"; height="25px";></a> &nbsp;<a href="javascript:void(0);" onclick="delrecoreds('<?php echo $row1['id']; ?>');"><img src="images/del.png" width="25px"; height="25px";></a></td>
                        <?php 		}

												else

												{

										?>
                        <td style="width :100px;">&nbsp;<a href="javascript:void(0);" onclick="del_uc_recoreds('<?php echo $row1['id']; ?>');"><img src="images/del.png" width="25px"; height="25px";></a></td>
                        <?php 		} 	?>
                      </tr>
                      <?php

												$i++;

											}

										}

										else

										{

											echo "<tr><td colspan='5'>No Shouts Yet!</td></tr>";

										}

										?>
                    </tbody>
                  </form>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="equalizer"></div>
    </article>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript">

function ValidateFileUpload()

{

	var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();

	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {

		alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');

		$('#js_0').val('');

	}else{

		$('#file_upload_successs').show();

	}

}

	

function validate_forum()

{

	

	var value = $('#add_post_text').val();

	if( $('#add_post_text').val() == "" || $('#add_post_text').val() == " " || value < 1)

	{

		alert( "Please provide post title!" );

		document.forum.forum.focus();

		return false;

	}

}	



function addshout()

{

	if($('#shout').val()=="")

	{

	  	$('#error_shout').html('Please enter your shout');

	   	$('#error_shout').fadeOut(5000);

	  	return false;

	}	

	else

	{

		$('#shout_frm').submit();

	}

}

function Edit_shout()

{

	if($('#shout_edit').val()=="")

	{

		$('#error_shout').html('Please enter your shout');

		$('#error_shout').fadeOut(5000);

		return false;

	}	

	else

	{

		$('#shout_frm_edit').submit();

	}

}

function editshout(id)

{

	$.get("getshotdetails.php?id="+id, function( data ) {

		$('#shout_edit').val(data);

		//	window.location='shout.php';

		$("#shout_ac_edit" ).click();

		$("#edit_id" ).val(id);

	});	

}



function delrecoreds(id)

{

	if(confirm('Are You sure You want to delete this record'))

	{

		$.get( "deleteshout.php?id="+id, function( data ) {

			window.location='shout.php?msg=del';

		});

	}

}



function del_uc_recoreds(id)

{

	if(confirm('Are You sure You want to delete this record'))

	{

		$.get( "deleteshout.php?friend_type=club&id="+id, function( data ) {

			window.location='shout.php?msg=del';

		});

	}

}



function chkvalidationdel()

{

	if($('.others:checked').length>0)

	{

		var r = confirm("Are you sure want to delete!");

		if (r == true) 

		{

			return true;

		} 

		else 

		{

			return false;

		}

	}

	else

	{

		alert("select atleast one shout to delete")

		return false; 

	}

}

</script>
<style type="text/css">

	.shout_notification 

	{

		background: #fecd07 none repeat scroll 0 0;

		border: 1px solid #fecd07;

		border-radius: 100px;

		display: block;

		height: 40px;

		line-height: 40px;

		margin: 5px auto;

		padding: 4px;

		text-align: center;

		width: 40px;

	}
 @media only screen and (max-width: 767px) {
	body { padding-top: 40px !important;}
	}
</style>
<?php //include('Footer.php') ?>
