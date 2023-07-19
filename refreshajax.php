<?php
header('Access-Control-Allow-Origin: *');
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
function detect_mobile()
{
	return false;
}
function detect_mobile_new()
{

	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
	return true;
	else
	return false;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if ($unit == "K") 
	{
		$d_cal = $miles * 1.609344;
		$val = round($d_cal , 2);
		return $val;
	} 
	elseif ($unit == "N") 
	{
		
		$d_cal = $miles * 0.8684;
		$val = round($d_cal , 2);
	  	return $val;
	} 
	else 
	{
		$val = round($miles , 2);
		return $val;
	}

}

function getDistance($zip1, $zip2, $unit)
{
	
	$first_lat = getLnt($zip1);
	$next_lat = getLnt($zip2);
	$lat1 = $first_lat['lat'];
	$lon1 = $first_lat['lng'];
	$lat2 = $next_lat['lat'];
	$lon2 = $next_lat['lng']; 
	
	$theta=$lon1-$lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
	cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
	cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K")
	{
		return ($miles * 1.609344)." ".$unit;
	}
	else if ($unit =="N")
	{
		return ($miles * 0.8684)." ".$unit;
	}
	else
	{
		return $miles." ".$unit;
	}
}



/* detect_stream added by kbimn on 30-01-2015 */

function detect_stream($hbhost){

// $st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
$st_qry = 'ffmpeg -i rtsp://192.163.248.47:1935/live/'.$hbhost.' 2>&1; echo $?';

	$st_res=(string)trim(shell_exec($st_qry));

	//echo $st_res;

	//die;

	if (strpos($st_res,'404 Not Found') === false) {

		return true;

	}

	

	return false;



}





function clean($string) {

	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.



	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

}


if($_POST['action'] == 'logout')
{
	mysql_query("update user set is_online='0', keepmelogin = '0' where id='".$_SESSION['user_id'] ."'");

	if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'club')
	{
		//commented by kbihm on 10-02-2015
		//mysql_query("update clubs set is_launch='0',is_online='0', keepmelogin = '0' where id='".$_SESSION['user_id'] ."'");
		mysql_query("update clubs set is_online='0', keepmelogin = '0' where id='".$_SESSION['user_id'] ."'");
	}else{
		mysql_query("update user set is_online='0',keepmelogin = '0' where id='".$_SESSION['user_id'] ."'");

	}
	setcookie(session_name(), '', 100);






	// empty value and expiration one hour before
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}
	session_unset();
	session_destroy();
	$_SESSION = array();
	$_SESSION['registertype'] = '';
	//echo "<pre>"; print_r($_SESSION); die;

	if(isset($_SESSION['device']))
	{
		echo "mysitti://";
		
		//$Obj->Redirect("mysitti://");
	}
	else
	{
		echo "../index.php";
	}





}

if($_POST['action'] == "deleteContestant")
{
	$contestID = $_POST['contestID'];
	$cid = $_POST['id'];
	$GetContest = mysql_query("SELECT * FROM `contestent` WHERE `c_video_id` = '$cid' ");
	$fetchContest = mysql_fetch_assoc($GetContest);
	//$contestID = $fetchContest['contest_id'];
	$contestentType = $fetchContest['user_type'];

	if($contestentType == "user")
	{
		$getUserInfo = mysql_query("SELECT `email` FROM `user` WHERE `id` = '$fetchContest[user_id]'  ");
		$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
		$EMAIL = $fetchUserInfo['email'];
	}
	else
	{
		$getUserInfo = mysql_query("SELECT `club_email` FROM `clubs` WHERE `id` = '$fetchContest[user_id]'  ");
		$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
		$EMAIL = $fetchUserInfo['club_email'];
	}

	$GetContestinfo = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$contestID' ");
	$fetchContestinfo = mysql_fetch_assoc($GetContestinfo);

	$contestName = $fetchContestinfo['contest_title'];
	$contestPrize = $fetchContestinfo['contest_prize'];
	$contestStart = $fetchContestinfo['contest_start']." ".$fetchContestinfo['start_time'];
	$contestEnd = $fetchContestinfo['contest_end']." ".$fetchContestinfo['end_time'];

	mysql_query("DELETE FROM `battle_settings` WHERE `user_id` = '$cid' AND `contest_id` = '$contestID'");
	mysql_query("DELETE FROM `winners_list` WHERE `contestant_id` = '$cid' AND `contest_id` = '$contestID'");
	mysql_query("DELETE FROM `contestent` WHERE `c_video_id` = '$cid' AND `contest_id` = '$contestID'");
	mysql_query("DELETE FROM contest_video_like WHERE c_video_id = '$cid'");
	$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
				<div style='width:100%;'>
					<div class='logo' style='float: left; margin-right:20px;'>
						<img src='".$base_url."images/new_portal/images/logo.png' border='0' />
					</div>
					<div style='float:left; margin-top: 50px;'>
						<p style='color: white;'>
						Welcome to the MYSITTI family and be a part of the next social revolution. <br /> 
						Visit <a srtle='color:#fecd07;' href='".$base_url."'>mysittidev.com</a> where we are <span style='color:#fecd07'>MAKING EVERY CITY YOUR CITY!</span>
						</p>
					</div>
				</div>
				<hr style='float:left; width:100%;'>
				<div style='color: white; float: left;width:100%;'>
				You have DELETED your entry from the following contest. 
				<br/> <br/> 
				Contest Name: <span style='color:#fecd07;'>".$contestName."</span> <br>
				Contest Start : ".date("M j,Y G:i A T",strtotime($contestStart))."<br>
				Contest End : ".date("M j,Y G:i A T",strtotime($contestEnd))."<br>
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </div>
				</div>";
		$message = $str; 
		$to  = $EMAIL;
		//$to  = "sumit.manchanda@kindlebit.com";
		
		$subject = "Live Contest Entry Delete Notification";
		$message = $str;
		//$from = "info@mysittidev.com";
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
		//$headers .= "From:" . $from;
		
		if(mail($to,$subject,$message,$headers,"-finfo@mysittidev.com"))
		{
			echo "test Mail Sent.";
		}



}


if($_POST['action'] == "getContestants")
{
	$contestID = $_POST['contestID'];
	$string = $_POST['search'];
	$getleadersql = mysql_query("SELECT A.user_type,A.user_id,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contestID." AND A.user_id = '$string' AND A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC");	
				 	$contestantsArray = array();
				 	$kk = 0;
					while($fetchleadersql = mysql_fetch_array($getleadersql))
						{
							$c_video_id=$fetchleadersql['c_video_id'];
							$i_count++;
							$get_video =mysql_query("Select * from `contestent` where c_video_id = '$c_video_id'");
							$fetchuservideo = mysql_fetch_array($get_video);
							$uid = $fetchleadersql['user_id'];
							$getusersql = mysql_query("SELECT * FROM user WHERE id = '$uid' ")	;
							$fetchusersql = mysql_fetch_array($getusersql);
												
							$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['city'])	;
							$fetchcitysql = mysql_fetch_array($getcitysql);
							
							$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchcitysql['state_id'])	;
							$fetchstatesql = mysql_fetch_array($getstatesql);
												
							//echo "<pre>";
					//		print_r($fetchusersql);
							//echo "</pre>";
							if($fetchleadersql['user_type'] == "user")
							{
							
								if($fetchusersql['profilename'] =='')
								{
									$uname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
								}
								else
								{
									$uname = $fetchusersql['profilename'];
								}
							
							}
							else
							{
								
								$select_club_dt = mysql_query("SELECT * FROM clubs WHERE id = '".$fetchleadersql['user_id']."'");
								$get_club_arr = mysql_fetch_assoc($select_club_dt);
								
								if($get_club_arr['club_name'] =='')
								{
									$uname = $get_club_arr['first_name']." ".$get_club_arr['last_name'];
								}
								else
								{
									$uname = $get_club_arr['club_name'];
								}								
								
							}

					?>
					 	
					 		 <li>
								<div class="contestent">
								  <div class="usname"> <?php echo $uname; ?></div>
								  <div class="s_close fourth">
									<?php if($fetchusersql['id'] == $_SESSION['user_id']){ ?>
									<a onclick="delete_contest('<?php echo $fetchuservideo['c_video_id']; ?>');" href="javascript:void(0);"><img src="images/s_close.png" alt="" /></a>
									<?php }else {echo "";} ?>
								  </div>
								  <?php
										if ($fetchcitysql['city_name'] == '' && $fetchstatesql['code'] == '')
										{ echo "";}
										else {
										
										 echo "<div class='s_city'>".$fetchcitysql['city_name']." , ". $fetchstatesql['code']."</div>"; 
									}
										?>
								  <?php /*if ($i_count == 1) 
									{
								   echo "<div class='trophy'><img src='images/rank1.png' alt='' /></div>";}
									 else if ($i_count == 2)
								   { echo "<div class='trophy'><img src='images/rank2.png' alt='' /></div>";}
									else if ($i_count == 3)
									{echo "<div class='trophy'><img src='images/rank3.png' alt='' /></div>";
									}
									else {echo"";} */?>
									<!-- <div class='trophy'><img src='images/rank<?php echo $i_count; ?>.png' alt='' /></div> -->
								  <div class="simg_wrp"><a href="<?php echo $fetchuservideo['video_name'];?>" rel="lightbox"><img src="<?php echo $fetchuservideo['video_thumb'];?>" /></a></div>
								  <div class="s_hover_des">
									<h4>
									  <?php 
										if ($fetchusersql['first_name'] == '' && $fetchusersql['last_name']== '')
										{
											echo $fetchusersql['profilename'];
										}
										else
										{
											echo $fetchusersql['first_name']." ".$fetchusersql['last_name'];
														
										}
										?>
									</h4>
									<div class="s_likecity">
										<?php 
											if( ($fetchleadersql['user_id'] == $_SESSION['user_id']) && ($currentDate >= $LiveRegDateStart && $currentDate <= $LiveRegDateEnd)  )
											{
										?>
						                    					<a href="javascript:void(0);" onclick="deleteContestant(<?php echo $fetchuservideo['c_video_id']; ?>);" title="Delete" class="del_contst">
										                    		<img src="images/del_contst.png" alt="Delete" />
										                    	</a>
									  <?php
									  		}

											$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$fetchuservideo["c_video_id"]."' ";
								$sql_like= mysql_query($sql_like1) or die(mysql_error());
								$is_like= mysql_fetch_assoc($sql_like);
											
											?>
									  <div class="sh_new_overlay">
									  <div class="s_shout_<?php echo $fetchuservideo['c_video_id']; ?>">
										<?php 		if($is_like['vote_type']!='yes') 
										{ 
											if($_SESSION['user_id'] != "")
											{
							?>
										<a  href="javascript:void(0);" style="text-decoration:none; color: #000;" onclick="count_vote('<?php echo $c_video_id; ?>','yes','<? echo $contest_id; ?>');">Shouts <?php echo $fetchleadersql['total']; ?></a><span><img src="/images/s_like.png" alt="" /></span></div>
									  <?php 		}
											else
											{
												echo "Shouts <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 
											}

										}
										else
										{ 
											echo "Shouts  <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 
										}
							?>
                            </div>
									</div>
									<div class="dateTime">
									  <div id="c_slot_time">
										<?php
										//echo $fetchleadersql['c_video_id'];//echo "SELECT * FROM contestent INNER JOIN contestent_time_slots ON contestent.c_video_id = contestent_time_slots.contestent_id WHERE contestent.contest_id = '".$_GET['contid']."'"; exit;
										$time_slot_query = mysql_query("SELECT * FROM contestent_time_slots INNER JOIN contestent ON contestent.c_video_id = contestent_time_slots.contestent_id WHERE contestent.c_video_id = '".$fetchleadersql['c_video_id']."'");
										$count_tslot = mysql_num_rows($time_slot_query);

										if($count_tslot > 0)
										{
											$row_tslot = mysql_fetch_assoc($time_slot_query);	

											$cluB_ID = $row_tslot['user_id'];
											$user_Type = $row_tslot['user_type'];
											if($user_Type == "club")
											{
												$getClubInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$cluB_ID' ");
												$fetchClubInfo = mysql_fetch_array($getClubInfo);
												//echo "<pre>"; print_r($fetchClubInfo); exit;
												$clubNAme= explode(" ", $fetchClubInfo['club_name']);
												$username_dash_separated = implode("-", $clubNAme);
												$username_dash_separated = clean($username_dash_separated);
											}
											//echo "<pre>"; print_r($row_tslot);

											$start_slot = $row_tslot['slot_start_date']." ".$row_tslot['slot_start_time'];
											$s_slot = date('jS F, Y h:i:s A' , strtotime($start_slot));
											$end_slot = $row_tslot['slot_end_date']." ".$row_tslot['slot_end_time'];
											$e_slot = date('jS F, Y h:i:s A' , strtotime($end_slot));
											?>
										
										<!--   <div class="start_date_time">
																			<?php //echo "<b>Start Time <br /> </b>".$s_slot."<br />"; ?>
																		</div>	
																		
																	  <div class="end_date_time">
																										  
																			 <?php
																			// echo "<b>End Time <br /> </b>".$e_slot."<br />";
																			 ?>                             
																			   
																		  </div>  -->
										
										<?php
										
										}
										?>
									  </div>
									  <div class="clear"></div>
									  <?php 

				if($count_tslot > 0)
				{
				echo '<div class="live_strem_new">';
				$mobile = detect_mobile();
				if($mobile === true) { 
				?>
									  <a class="button_live" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
									  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
									  <?php if(detect_stream($username_dash_separated)===true){ ?>
									  <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
									  <?php } else{ ?>
									  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
									  <?php } ?>
									  </a>
									  <? } else { ?>
									  <a class="button_live" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>')">Live Streaming
									  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
									  <?php if(detect_stream($username_dash_separated)===true){ ?>
									  <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
									  <?php } else{ ?>
									  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
									  <?php } ?>
									  </a>
									  <?php } ?>
									  <div class="clear"></div>
									</div>
									<?php } 	?>
								  </div>
								</div>
							  </li>
					  	<?php }

}

if($_POST['action'] == "getallContestants")
{
	$contestID = $_POST['contestID'];

	$sql = "SELECT A.user_type,A.user_id,A.contest_type,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contestID." AND";

	$string = $_POST['search'];
	$get_c_id = mysql_query("SELECT id FROM clubs WHERE club_name = '".mysql_real_escape_string($string)."'");
	if(mysql_num_rows($get_c_id) < 1 )
	{
		$get_c_id = mysql_query("SELECT id FROM user WHERE profilename = '".mysql_real_escape_string($string)."'");
	}


	$club_id = mysql_fetch_assoc($get_c_id);

	$string = $club_id['id'];
	
	if(empty($_POST['search']))
	{

	}
	else
	{
		$sql .= " A.user_id = '$string' AND ";	
	}
	
	$LIMIT = $_POST['condition'];

	$sql .= " A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC ".$LIMIT." ";

	$getleadersql = mysql_query($sql);	
	$contestantsArray = array();
	$kk = 0;
	while($fetchleadersql = mysql_fetch_array($getleadersql))
	{
		$c_video_id=$fetchleadersql['c_video_id'];
		$i_count++;
		$get_video =mysql_query("Select * from `contestent` where c_video_id = '$c_video_id'");
		$fetchuservideo = mysql_fetch_array($get_video);
		$uid = $fetchleadersql['user_id'];
		$getusersql = mysql_query("SELECT * FROM clubs WHERE id = '$uid' ");
		$fetchusersql = mysql_fetch_array($getusersql);
							
		$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['club_city']);
		$fetchcitysql = mysql_fetch_array($getcitysql);
		
		$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchusersql['club_state']);
		$fetchstatesql = mysql_fetch_array($getstatesql);
							

		if($fetchleadersql['user_type'] == "user")
		{
			$streamingLaunch = $fetchusersql['streamingLaunch'];
			if($fetchusersql['profilename'] =='')
			{
				$uname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
			}
			else
			{
				$uname = $fetchusersql['profilename'];
			}
		
		}
		else
		{
			
			$select_club_dt = mysql_query("SELECT * FROM clubs WHERE id = '".$fetchleadersql['user_id']."'");
			$get_club_arr = mysql_fetch_assoc($select_club_dt);
			
/* 										if($get_club_arr['club_name'] =='')
			{
				$uname = $get_club_arr['first_name']." ".$get_club_arr['last_name'];
			}
			else
			{ */
				$uname = $get_club_arr['club_name'];
				$streamingLaunch = $get_club_arr['streamingLaunch'];
			//}								
			
		}
		// $val2[$kk]['label']=$uname;
		// $val2[$kk]['id'] = $uid;	
		$val2[] = $uname;

		//$kk++;
?>
				<li style="list-style:none !important;">

					<div class="contestent">

						<div class="city_contst">

							<?php 
								if(!empty($fetchcitysql['city_name']))
								{
									echo $fetchcitysql['city_name']." , ". $fetchstatesql['code'];
								}
								else
								{
									echo '&nbsp;';
								}
							?>

						</div>

	  					<div class="usname">
				  			<?php 
				  						if($fetchleadersql['user_type'] == 'club')
			  							{ 
			  								if(isset($_SESSION['user_id']))
			  								{
			  				?>					<a href="host_profile.php?host_id=<?php echo $fetchleadersql['user_id']; ?>" target="_blank"><?php echo $uname; ?></a>
							<?php 				}
											else
											{
							?>
												<a href="<?php echo $uname; ?>" target="_blank"><?php echo $uname; ?></a>
							<?php
											}			
										}
										else
										{ 
							?>				
											<a href="profile.php?id=<?php echo $fetchleadersql['user_id']; ?>" target="_blank"><?php echo $uname; ?></a>
							<?php 			} 		?>

	  					</div>

	  					<div class="s_close">

							<div class='trophy'>

								<img src='images/rank<?php echo $i_count; ?>.png' alt='' />

							</div>

	  						<div class="simg_wrp">

	  						<?php 

	  							$SRCthumb = $fetchusersql['image_nm'];

  								$SRCimage = $fetchusersql['image_nm'];

  								if($fetchuservideo['contest_type'] == 'image')

  								{

  							?>		

  									<!-- <img src="<?php if($SRCthumb != "") { echo $SRCthumb; }else{ echo 'images/man4.jpg';} ?>" /> -->

  									<a href="<?php echo $fetchuservideo['video_name'];?>" class="fancybox" rel="group">

								  		<img src="<?php if($fetchuservideo['video_thumb'] != "") { echo $fetchuservideo['video_thumb']; }else{ echo 'images/man4.jpg';} ?>" />

								  	</a>

							<?php 	}

  								else

  								{

  							?>		<img src="<?php if($SRCimage != "") { echo $SRCimage; }else{ echo 'images/man4.jpg';} ?>" />

  									<div class="video_overlay">

										<img src="images/playthisvid.png" alt="Play" onclick="javascript:void window.open('<?php echo $SiteURL; ?>play_advertise_video.php?action=contestent&amp;id=<?php echo $fetchuservideo['c_video_id']; ?>','','width=650,height=550,resizable=true,left=0,top=0');return false;"/>

									</div>

  							<?php 	}	?>

						  	</div>

	  						<div class="s_hover_des">

								<div class="s_likecity">

								<?php 

									if( ($fetchleadersql['user_id'] == $_SESSION['user_id']) && ($_SESSION['user_type'] == $fetchleadersql['user_type'])/*($currentDate >= $LiveRegDateStart && $currentDate <= $LiveRegDateEnd) */ )

									{

								?>

				                    					<a href="javascript:void(0);" onclick="deleteContestant(<?php echo $fetchuservideo['c_video_id']; ?>);" title="Delete" class="del_contst">

								                    		<img src="images/del_contst.png" alt="Delete" />

								                    	</a>

		  		<?php 					}

									$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$fetchuservideo["c_video_id"]."' ";

									$sql_like= mysql_query($sql_like1) or die(mysql_error());

									$is_like= mysql_fetch_assoc($sql_like);

				?>

                         										<div class="sh_new_overlay">

	  									<div class="s_shout_<?php echo $fetchuservideo['c_video_id']; ?>">

		<?php 									if($is_like['vote_type']!='yes') 

											{ 

												if($_SESSION['user_id'] != "")

												{

													if( ($currentDate >= $contestStartDate) && ( $currentDate <=  $contestEndDate ) )

													{

						?>

														<a  href="javascript:void(0);" style="text-decoration:none; color: #000;" onclick="count_vote('<?php echo $c_video_id; ?>','yes','<? echo $contest_id; ?>');">

															Shouts <?php echo $fetchleadersql['total']; ?>

															<span><img src="/images/s_like.png" alt="" /></span>

														</a>

					  	<?php 							}

										  			else

										  			{

	  					?>

	  													Shouts <?php echo $fetchleadersql['total']; ?><span><img src="/images/s_like.png" alt="" /></span>

	 <?php 												}

										  		}

												else

												{

													echo "Shouts <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

												}

											}

											else

											{ 

												echo "Shouts  <span id='yesnolikes_".$fetchuservideo['c_video_id']."'>".$fetchleadersql['total']."</span><span><img src='images/s_like.png' alt='' /></span>"; 

											}

?>											</div>

									</div>

									<div class="dateTime">

									  	<div id="c_slot_time">

		<?php 									

											$time_slot_query = mysql_query("SELECT * FROM contestent_time_slots INNER JOIN contestent ON contestent.c_video_id = contestent_time_slots.contestent_id WHERE contestent.c_video_id = '".$fetchleadersql['c_video_id']."'");

											$count_tslot = mysql_num_rows($time_slot_query);

											$row_tslot = mysql_fetch_assoc($time_slot_query);	

											$cluB_ID = $row_tslot['user_id'];

											$user_Type = $row_tslot['user_type'];

											if($user_Type == "club")

											{

												$getClubInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$cluB_ID' ");

												$fetchClubInfo = mysql_fetch_array($getClubInfo);

												

												

											}

											$start_slot = $row_tslot['slot_start_date']." ".$row_tslot['slot_start_time'];

											$s_slot = date('jS F, Y h:i:s A' , strtotime($start_slot));

											$end_slot = $row_tslot['slot_end_date']." ".$row_tslot['slot_end_time'];

											$e_slot = date('jS F, Y h:i:s A' , strtotime($end_slot));

			?>

	 									 </div>

	  									<div class="clear"></div>

	   								<?php 

	   									if(isset($_SESSION['user_id']))

	   									{

	   								?>

										<div class="live_strem_new">


												<a class="button_live" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&contestantid=<?php echo $c_video_id;?>&contestID=<?php echo $_GET['contid'];?>')">Live Streaming

								<?php 

												if($streamingLaunch == '1')

												{ 

									?>

													<span class="stats_icon" >

														<img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" />

													</span>

								<?php 				} 

												else

												{ 

									?>

													<span class="stats_icon" >

														<img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" />

													</span>

								<?php 				} 		?>

												</a>


	  										<div class="clear"></div>

										</div>

									<?php 	}	?>

									</div>

								</div>

							</div>

						</div>

	  				</div>	

  				</li>
		<?php 	} // ENDWHILE 	


}







if($_GET['action'] == 'advanced_clubs_search'){
	
	$club_name = mysql_real_escape_string($_GET['q']);
	$club_category = $_GET['category'];

	$get_groups = mysql_query("SELECT * FROM clubs WHERE club_name LIKE '%".$club_name."%'");
	$count_rows = mysql_num_rows($get_groups);
	
	if($count_rows < 1){
		
			echo "No Results Found";
		
		}else{
		
		while($row = mysql_fetch_assoc($get_groups)){

				echo strip_tags($row['club_name'])."\n";
		}		
		
		
	}
		return false;
	
}

if($_GET['action'] == 'clubs_search'){
	
	$club = $_GET['q'];
	
	if (strpos($club,',') !== false) {
		$explode_club = explode(',', $club);
		$club_name = $explode_club[0];
	}else{
		
		$club_name = $_GET['q'];
	}
$club_name = mysql_real_escape_string($club_name);
	$get_groups = mysql_query("SELECT * FROM clubs INNER JOIN capital_city ON clubs.club_city = capital_city.city_id WHERE clubs.club_name LIKE '%".$club_name."%'");
	$count_rows = mysql_num_rows($get_groups);
	
	if($count_rows < 1){
		
			echo "No Results Found";
		
		}else{
		
		while($row = mysql_fetch_assoc($get_groups)){

				echo strip_tags($row['club_name']).",".strip_tags($row['city_name'])."\n";
		}		
		
		
	}
		return false;
	
}


if($_GET['action'] == 'clubs_search_events'){
	
	$club = $_GET['q'];
	
	if (strpos($club,',') !== false) {
		$explode_club = explode(',', $club);
		$club_name = $explode_club[0];
	}else{
		
		$club_name = $_GET['q'];
	}
$club_name = mysql_real_escape_string($club_name);
	$get_groups = mysql_query("SELECT * FROM clubs WHERE `club_name` LIKE '%".$club_name."%' AND `non_member` = '0'  AND `deactivate_account` = '0' ");
	$count_rows = mysql_num_rows($get_groups);
	
	if($count_rows < 1){
		
			echo "No Results Found";
		
		}else{
		
		while($row = mysql_fetch_assoc($get_groups)){

				echo strip_tags($row['club_name'])."\n";
		}		
		
		
	}
		return false;
	
}


if($_GET['action'] == 'clubs_search_fighters'){
	
	$club = $_GET['q'];
	
	if (strpos($club,',') !== false) {
		$explode_club = explode(',', $club);
		$club_name = $explode_club[0];
	}else{
		
		$club_name = $_GET['q'];
	}
$club_name = mysql_real_escape_string($club_name);
	$get_groups = mysql_query("SELECT * FROM clubs WHERE `club_name` LIKE '%$club_name%' AND `type_of_club` = '106' AND `non_member` = '0'  AND `deactivate_account` = '0' ");
	$count_rows = mysql_num_rows($get_groups);
	
	if($count_rows < 1){
		
			echo "No Results Found";
		
		}else{
		
		while($row = mysql_fetch_assoc($get_groups)){

				echo strip_tags($row['club_name'])."\n";
		}		
		
		
	}
		return false;
	
}

if($_GET['action'] == 'clubs_search_Artists'){
	
	$club = $_GET['q'];
	
	if (strpos($club,',') !== false) {
		$explode_club = explode(',', $club);
		$club_name = $explode_club[0];
	}else{
		
		$club_name = $_GET['q'];
	}
	$club_name = mysql_real_escape_string($club_name);
	$get_groups = mysql_query("SELECT `club_name`,`club_email` FROM clubs WHERE `club_name` LIKE '%$club_name%' AND `non_member` = '0'  AND `deactivate_account` = '0' AND `id` != '$_SESSION[user_id]' ");
	$count_rows = mysql_num_rows($get_groups);
	
	if($count_rows < 1){
		
			echo "No Results Found";
		
		}else{
		
		while($row = mysql_fetch_assoc($get_groups))
		{
			$clubMail = strip_tags($row['club_email']);
			$getSubuser = mysql_query("SELECT `id` FROM `hostsubusers` WHERE `useremail` LIKE '%$clubMail%'  ");
			if(mysql_num_rows($getSubuser) == '0')
			{
				echo strip_tags($row['club_name'])."\n";	
			}
			
		}		
		
		
	}
		return false;
	
}

if(isset($_POST['setSession']))
{
	session_start();
	$_SESSION['publicViewReport1'] = 1;
	session_write_close();
}

if(isset($_POST['fetchresult'])){
	
 	$club_data = $_POST['clubname'];
	$explode = explode(',', $club_data);
	
 	$club_name =  str_replace('&amp;', '&', strip_tags($explode[0]));
	$city_name = $explode[1];

	$get_clubs = mysql_query("SELECT * FROM clubs WHERE club_name = '".mysql_real_escape_string($club_name)."' ");
	$get_clubs_count = mysql_num_rows($get_clubs);
	if($get_clubs_count > 0)
	{
		$club_row_data = mysql_fetch_assoc($get_clubs);
		if(!isset($_SESSION['user_id']))
		{
			echo "https://".$_SERVER['HTTP_HOST']."/".$club_row_data['club_name'];
		}
		else
		{
			echo "https://".$_SERVER['HTTP_HOST']."/host_profile.php?host_id=".$club_row_data['id'];
		}
	}
	else
	{
		$get_clubs = mysql_query("SELECT * FROM user WHERE profilename = '".mysql_real_escape_string($club_name)."' ");
		$club_row_data = mysql_fetch_assoc($get_clubs);
		echo "https://".$_SERVER['HTTP_HOST']."/profile.php?id=".$club_row_data['id'];
	}








}

if(isset($_POST['arrange_images']))
{
  	$cityid = $_SESSION['id'];
  	// echo "SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ";
  	$getcityname = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$cityid."' ");
  	$fetchcity = mysql_fetch_array($getcityname);
 	$city = trim($fetchcity['city_name']);
 	//echo $fetchcity['refresh'];
	if(!empty($city))
	{
		$images_array = array();
		$images = array();
		$get_images = mysql_query("SELECT * FROM `refresh_background` as `rb`,`capital_city_images` as `cci`
						WHERE `rb`.`city_image_id` = `cci`.`city_image_id`
						AND `cci`.`city_id` = '$cityid'
						AND  `rb`.`refresh_status` = '1'");
		if(mysql_num_rows($get_images) > 0)
		{
			while($row = mysql_fetch_assoc($get_images))
			{

				$images_array[] = $row['city_image_id'];

			}
		}
		else
		{
			$cclong = $fetchcity['lng'];
			$cclat = $fetchcity['lat'];
			$stateId = $_SESSION['state'];
			$distancesArray = array();
			$rescities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityid' ");
			while($fetchrescities = mysql_fetch_array($rescities))
			{
				if(strlen($fetchrescities['city_name']) > 2 )
				{
					if($fetchrescities['lng'] != 0.000000 && !empty($fetchrescities['lng']))
					{
						$restlong = $fetchrescities['lng'];
						$restlat = $fetchrescities['lat'];
						$distancemiles = distance($cclat, $cclong, $restlat, $restlong, "M");
						$distancesArray[$fetchrescities['city_id']] = $distancemiles;
					}

				}

			}

			$citys = "";
			asort($distancesArray);
			//echo "<pre>"; print_r($distancesArray); die;
			$aa = 0;
			foreach($distancesArray as $key=>$dis)
			{
				if($aa == '0')
				{
					$newCityID = $key;
					$get_images1 = mysql_query("SELECT * FROM `refresh_background` as `rb`,`capital_city_images` as `cci`
						WHERE `rb`.`city_image_id` = `cci`.`city_image_id`
						AND `cci`.`city_id` = '$newCityID'
						AND  `rb`.`refresh_status` = '1'");
					if(mysql_num_rows($get_images1) > 0)
					{
						while($row1 = mysql_fetch_assoc($get_images1))
						{
							$images_array[] = $row1['city_image_id'];
						}
						$aa++;
					}
				}

			}
		}
		// echo "<pre>"; print_r($images_array); die;

		if(!empty($images_array))
		{

			$random_key = array_rand($images_array, 1);

			$img_id = $images_array[$random_key];
			//echo "SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'";
			$get_single_image = mysql_query("SELECT city_image_url FROM capital_city_images WHERE city_image_id = '".$img_id."'");

			$row = mysql_fetch_assoc($get_single_image);
			if(mysql_num_rows($get_single_image) > 0)
			{
				$imagesrcback =  "/admin/cities/".$row['city_image_url'];
				$intervalq = mysql_query("SELECT * FROM `refresh_background_time`");
				$intervalf = mysql_fetch_array($intervalq);

				ob_start();
				setcookie("backgroundcookie", $imagesrcback,time() + (60 * $intervalf['time_interval'] ) );
				ob_end_clean();
				echo $imagesrcback;
			}
		}
	}
}

if($_POST['action'] == 'fetchdatacluball')
{
	$club = $_POST['clubname'];
	$get_groups = mysql_query("SELECT * FROM `clubs` WHERE `club_name` = '".$club."' ORDER BY `club_name` ");
	$fetchdata = mysql_fetch_array($get_groups);
	if(!isset($_SESSION['user_id']))
	{
		echo $linkurl = $SiteURL.$fetchdata['club_name'];
	}
	else
	{
		echo $linkurl = "https://".$_SERVER['HTTP_HOST']."/host_profile.php?host_id=".$fetchdata['id'];	
	}
	
	return false;
}

if($_POST['action'] == 'calendarevents')
{
	if($_POST['type'] == "event")
	{
		$success = mysql_query("DELETE FROM `events` WHERE `id` = '".$_POST['id']."' ");
	}
	if($_POST['type'] == "booking")
	{
		$success = mysql_query("DELETE FROM `bookings` WHERE `id` = '".$_POST['id']."' ");		
	}
	if($success)
	{
		echo "Success";
	}
	else
	{
		echo "Failed";
	}
}

if($_GET['action'] == 'fetchusernames')
{
	$newArray = array();
	$string = $_GET['q'];
	$getclubs = mysql_query("SELECT `club_name`,`id` FROM `clubs` WHERE  `club_name` LIKE '%$string%' AND `non_member` = '0' ");
	$getUsers = mysql_query("SELECT `profilename` FROM `user` WHERE `profilename` LIKE '%$string%'  ");

	while($row2 = mysql_fetch_array($getclubs))
	{
		$cjeckSubhost = mysql_query("SELECT `id` FROM `hostsubusers` WHERE  `username` = '$row2[club_name]' ");
		if(mysql_num_rows($cjeckSubhost) == '0')
		{	
			$newArray[] = $row2['club_name'];
		}
	}
	while($row1 = mysql_fetch_array($getUsers))
	{
		$newArray[] = $row1['profilename'];
	}

	if(!empty($newArray))
	{
		foreach($newArray as $name)
		{
			echo $name."\n";
		}
		return false;
	}
	else
	{
		echo "No Results Found.";
		return false;	
	}

}

if($_GET['getaction'] == 'fetchdestinations')
{
	$newArray = array();
	$string = $_GET['q'];

	$getUsers = mysql_query("SELECT `country_name` FROM `trip_city_list` WHERE `country_name` LIKE '%$string%'  ");

	while($row1 = mysql_fetch_array($getUsers))
	{
		$newArray[] = $row1['country_name'];
	}

	if(!empty($newArray))
	{
		foreach($newArray as $name)
		{
			echo $name."\n";
		}
		return false;
	}
	else
	{
		echo "No Results Found.";
		return false;	
	}

}

if($_GET['action'] == 'eventlist')
{
	$string = $_GET['q'];
	$catid  = $_GET['catid'];
	if(!empty($_GET['date']))
	{
		$d =strtotime($_GET['date']);
		$date  = date('Y-m-d H:i:s',$d);
	}
	else
	{
		$date = date('Y-m-d H:i:s');
	}

	if(empty($catid))
	{
		$newArray = array();
		// $getclubs = mysql_query("SELECT `club_name` FROM `clubs` WHERE  `club_name` LIKE '%$string%'");
		// $getUsers = mysql_query("SELECT `profilename` FROM `user` WHERE `profilename` LIKE '%$string%'  ");
		//echo "SELECT * FROM `forum` WHERE `city_id` = '".$_SESSION['id']."' AND `event_date` >= '$date'  AND `forum` LIKE '%$string%' GROUP BY forum.forum ";
		$getevents = mysql_query("SELECT * FROM `forum` WHERE `city_id` = '".$_SESSION['id']."' AND `event_date` >= '$date'  AND `forum` LIKE '%$string%' GROUP BY forum.forum ");
	
		while($row = mysql_fetch_array($getevents))
		{
			$newArray[] = $row['forum'];
		}
		
		
		if(!empty($newArray))
		{
			foreach($newArray as $name)
			{
				echo $name."\n";
			}
			return false;
		}
		else
		{
			echo "No Results Found.";
			return false;	
		}
		
	}
	else
	{
		$getevents = mysql_query("SELECT * FROM `forum` WHERE `city_id` = '".$_SESSION['id']."' AND `event_category` = '$catid' AND `event_date` >= '$date'  AND `forum` LIKE '%".$string."%' GROUP BY forum.forum ");
	
		while($row = mysql_fetch_array($getevents))
		{
			echo $row['forum']."\n";
		}	
		return false;
	}
	



	
}

if($_POST['action'] == 'citylist')
{
	$string = $_POST['q'];
	$catid  = $_POST['stateid'];


// echo "SELECT * FROM `forum` WHERE `event_category` = '$catid' AND `city_id` = '$_SESSION[id]'  AND `forum` LIKE '%$string%'  AND `event_date` > '$date' "; die;
	if(!empty($string))
	{
		//echo "SELECT * FROM `capital_city` WHERE `state_id` = '$catid' AND `city_name` LIKE  '%$string%' ORDER BY `city_name` ASC   "; die;
		$getcities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$catid' AND `city_name` LIKE  '%$string%' ORDER BY `city_name` ASC   ");
		while($row = mysql_fetch_array($getcities))
		{
			echo $row['city_name']."\n";
		}
		return false;
	}
	else
	{
		$getcities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$catid' ORDER BY `city_name` ASC ");
		while($row = mysql_fetch_array($getcities))
		{
			echo $row['city_name']."\n";
		}
		return false;
	}
}


if($_GET['action'] == 'citylist')
{
	$string = $_GET['q'];
	$catid  = $_GET['stateid'];


// echo "SELECT * FROM `forum` WHERE `event_category` = '$catid' AND `city_id` = '$_SESSION[id]'  AND `forum` LIKE '%$string%'  AND `event_date` > '$date' "; die;
	if(!empty($string))
	{
		//echo "SELECT * FROM `capital_city` WHERE `state_id` = '$catid' AND `city_name` LIKE  '%$string%' ORDER BY `city_name` ASC   "; die;
		$getcities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$catid' AND `city_name` LIKE  '%$string%' ORDER BY `city_name` ASC   ");
		while($row = mysql_fetch_array($getcities))
		{
			echo $row['city_name']."\n";
		}
		return false;
	}
	else
	{
		$getcities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$catid' ORDER BY `city_name` ASC ");
		while($row = mysql_fetch_array($getcities))
		{
			echo $row['city_name']."\n";
		}
		return false;
	}
}

if($_POST['action'] == 'checkzipcode')
{
	$zipcode = $_POST['zip'];
	//$zipcode = $_POST['zipcode'];
	$address = str_replace(" ", "", $zipcode);
	$poststate = $_POST['state'];
	$postcountry = $_POST['country'];
	$check = $_POST['checkbox'];
	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	$response_a = json_decode($response);
	//echo "<pre>"; print_r($response_a); die('dddd');
	$lat = $response_a->results[0]->geometry->location->lat;
	$long = $response_a->results[0]->geometry->location->lng;	

	$i = 0;

	foreach($response_a->results[0]->address_components as $abc)
	{
		if($abc->types[0] == "country")
		{
			$country = $response_a->results[0]->address_components[$i]->long_name;
		}
		
		if($abc->types[0] == "administrative_area_level_1")
		{
			$state = $response_a->results[0]->address_components[$i]->long_name;
		}

		if($abc->types[0] == "locality")
		{
			$city = $response_a->results[0]->address_components[$i]->long_name;
		}


		$i++;


	}

	$getquery = mysql_query("SELECT * FROM `capital_city` WHERE `city_name` = '$city'  ");
	$countres = mysql_num_rows($getquery);
	$fetchres = mysql_fetch_array($getquery);
	$getStateinfo = mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$fetchres[state_id]' ");
	$fetchsateInfo = mysql_fetch_assoc($getStateinfo);
	$country = $fetchsateInfo['country_id'];
	if($countres > 0 && ($country == '223' || $country == '38') )
	{


		session_start();
		
		$_SESSION['id'] = $fetchres['city_id'];
		$_SESSION['state'] = $fetchres['state_id'];
		
		$_SESSION['country'] = $fetchsateInfo['country_id'];

		if($check == "on")
		{
			$user_id = $_SESSION['user_id'];
			$user_type = $_SESSION['user_type'];
			$state = $fetchres['state_id'];
			
			$check_d_city_status = mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."'");
			$check_d_city_rows = mysql_num_rows($check_d_city_status);
		
			if($check_d_city_rows < 1){
				
				$insert_d_city = mysql_query("INSERT INTO default_city_selected (`user_id`, `user_type`, `country`, `state`, `city`, `d_city_status`) VALUES ('".$user_id."', '".$user_type."', '".$country."', '".$state."', '".$fetchres['city_id']."', '".$check."')");
				
			}else{
				
				$update_d_city = mysql_query("UPDATE default_city_selected SET `country` = '".$country."', `state` = '".$state."', `city` = '".$fetchres['city_id']."', `d_city_status` = '".$check."' WHERE user_id = '".$user_id."' AND user_type = '".$user_type."' ");
				
			}
		}


		session_write_close();
		echo $success = "1";

	}
	else
	{
		echo $success = "0";
	}


}


if($_POST['action'] == 'postsubcat')
{
	$club_category = $_POST['club_category'];
	$search = $_POST['advanced_clubs_autocomplete'];
	$subcategory_name  = $_POST['name'];

	$query = "SELECT * FROM clubs";

	$conditions = array();

	// if(!empty($search)){

	// $conditions[] = "club_name = '".$search."' AND club_city = '".$_SESSION['id']."'";
	// }

	if(!empty($club_category)){

		$conditions[] = "type_of_club = '".$club_category."' ";
	}



	$sql = $query;
	if (count($conditions) > 0) {
		$sql .= " WHERE " . implode(' AND ', $conditions) ."AND club_city = '".$_SESSION['id']."'";
	}
//echo $sql; exit;
	if(!empty($subcategory_name))
	{
		$checkSubcat = mysql_query("SELECT * FROM `club_category` WHERE `name` = '$subcategory_name' ");
		$fetchSubCat = mysql_fetch_assoc($checkSubcat);
		$checkMoreSubCats = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchSubCat[id]' ");
		if(mysql_num_rows($checkMoreSubCats) > 0)
		{
			while($res = mysql_fetch_assoc($checkMoreSubCats))
			{
				$conditions1[] = "type_details_of_club REGEXP '".$res['name']."' ";
			}
		}
		else
		{
			$conditions2 = "type_details_of_club REGEXP '".$subcategory_name."' ";
		}

		
	}
if(!empty($conditions1))
{
	$newCondition = implode(' || ', $conditions1);
	$sql = $sql." AND  (".$newCondition.")"; 
}
else
{
	$sql = $sql." AND ".$conditions2; 
}
//echo "<pre>"; print_r($newCondition);exit;


//echo $sql; exit;


	$get_search_results = mysql_query($sql);

	$count_clubs_res = mysql_num_rows($get_search_results);

	$C = mysql_num_rows($get_search_results);

	if($C < 1)
	{
		$get_search_results = mysql_query("SELECT * FROM `clubs` WHERE `type_of_club` = '$_POST[id]' AND `club_city` = '$_SESSION[id]' ");
		$count_clubs_res = mysql_num_rows($get_search_results);
		$S = mysql_num_rows($get_search_results);
		if($S < 1)
		{
			$getSubcatsresults = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$_POST[id]'   ");
			$myVariable = "";
			if(mysql_num_rows($getSubcatsresults) > 0)
			{
				while($subresults = mysql_fetch_assoc($getSubcatsresults))
				{
					$myVariable .= $subresults['id'].",";
				}
			}
			$Condition = rtrim($myVariable,",");
			//echo "SELECT * FROM `clubs` WHERE `type_of_club` IN ($myVariable) AND `club_city` = '$_SESSION[id]' "; die;
			$get_search_results = mysql_query("SELECT * FROM `clubs` WHERE `type_of_club` IN ($Condition) AND `club_city` = '$_SESSION[id]' ");
			$count_clubs_res = mysql_num_rows($get_search_results);

		}
	}






?>
<ul class="v2_listing_container v2_postsubcat">
	<?php
	if($count_clubs_res < 1){ ?>
									
		  <li id="noresults">No Results Found</li>
	
	<?php }else{
		  
		  while($s_row = mysql_fetch_assoc($get_search_results)){
				
	?>
	
				<li>
				<div class="results_listing">
					<div class="post_container home_club_posts">
					<div class="v2_left_cpost">
					<div class="content width_100" id="forumcontent">
					
					<?php if(!empty($s_row['image_nm'])){ ?>
					
					  <a href="<?php echo $s_row['image_nm']; ?>" rel="lightbox">
							<img src="<?php echo $s_row['image_nm']; ?>" alt=""> 
					  </a>													  
					
					<?php }else{

						$nm = rand(91,100);

					 ?>
						<img src="/hot_spots/<?php echo $nm.".jpg"; ?>">
					
					<?php } ?>
								
					</div>
					</div>
					<div class="v2_right_cpost">
					<h1>
						<?php 
							$checkClaimHost = mysql_query("SELECT * FROM `claimhosts` WHERE `claim_host_id` = '$s_row[id]' ");
							if(mysql_num_rows($checkClaimHost) > 0 || $s_row['non_member'] == '0')
							{
						?>
								<a href="<?php echo $SiteURL; ?><?php if(isset($_SESSION['user_id'])){ ?>host_profile.php?host_id=<?php echo $s_row['id'];  }else{ echo $s_row['club_name']; }?>">
						<?php 	}
							else
							{
						?>		<a style="cursor:pointer;" target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">
						<?php 	}
							echo $s_row['club_name']; ?>
						</a>
					</h1>
					<!--<div class="event-date">January 28, 2015 Wednesday 5:07 PM</div>-->
					<div class="location"><p><span><?php echo $s_row['club_address']; ?></span><br><?php echo $s_row['type_details_of_club']; ?></p>
					<p><a target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">Map</a></p>
					<div style="clear:both"></div>
					</div>
					
					<!--<p class="discription"> SATURDAY JANUARY 3 2015FUTURE-EVERYTHING PRESENTS:DIM THE LIGHTSÂ FEATURING=======================			   -->
					<!--<a onclick="javascript:void window.open('read_more_cityevent.php?id=16&amp;action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">Read More...</a>-->
					<!--</p>                    -->
					</div>
					</div>
				</div>
												
				</li>									
	
	<?php }} ?>
</ul>
<?php
}




/* USER ADD TO CALENDAR */

if($_POST['action'] == 'addtocalendar')
{
	
$get_friends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.status IN ('active','block') GROUP BY friend_id ORDER BY id ASC");
$count_friends = mysql_num_rows($get_friends);
	
	if($count_friends > 0){
		
		while($f_row = mysql_fetch_assoc($get_friends)){

			$get_event_date = mysql_query("SELECT `event_date` FROM forum WHERE forum_id = '".$_POST['forumID']."'");
			$event_date = mysql_fetch_assoc($get_event_date);
			$cur_date = date('Y-m-d H:i:s');
			
			$c_identifier = "event_calendar_share_".$_POST['forumID'];
			
			mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$f_row['friend_id']."', 'event_calendar_share', '".$cur_date."', '1', '".$c_identifier."', 'user', '".$f_row['friend_type']."')");
			
		}
	}
	
	$forumid = $_POST['forumID'];

	$mysql = mysql_query("INSERT INTO `user_events` (`uid`,`forum_id`) VALUES ('$_SESSION[user_id]','$forumid') ");

	if($mysql)
	{
		echo "<span style='color:rgb(254, 205, 7);'>Event Added to your Calendar!</span>";
	}
	else
	{
		echo "<span style='color:rgb(254, 205, 7);'>Event Couldn't be Added to your Calendar !</span>";
	}
	// return false;

}

if($_POST['action'] == 'removeEvent')
{
	$forumid = $_POST['forumID'];

	$mysql = mysql_query("DELETE FROM `user_events` WHERE `uid` = '$_SESSION[user_id]' AND `forum_id` = '$forumid' ");

	if($mysql)
	{
		echo "Event is Deleted!";
	}
	else
	{
		echo "Some Error Occurred!";
	}
	// return false;

}

if($_POST['action'] == 'destroySession')
{
	if($_POST['usertype'] == "user")
	{
		mysql_query("UPDATE `user` SET `deactivate_account` = '1' WHERE `id` = '$_POST[userid]'  ");
		unset($_SESSION);
		session_destroy();

	}
	else
	{
		mysql_query("UPDATE `clubs` SET `deactivate_account` = '1' WHERE `id` = '$_POST[userid]'  ");
		unset($_SESSION);
		session_destroy();
	}

	// return false;

}

if($_POST['action'] == 'confirmInvite')
{
	$eventId = $_POST['event_id'];
	$djID = $_POST['dj_id'];
	$notification_id = $_POST['notification_id'];	
	$getHostinfo = mysql_query("SELECT * FROM `user_notification` WHERE `id` = '$notification_id' ");
	$fetchHostinfo = mysql_fetch_array($getHostinfo);
	$hostID = $fetchHostinfo['from_user'];
	$event_added_on = $fetchHostinfo['added_on'];
	$c_identifier = "dj_invitation_confirm_".$eventId;
	mysql_query("UPDATE `dj_confirmation` SET `status` = 'Confirm' WHERE `event_id` = '$eventId' AND `dj_id` = '$djID' ");
	mysql_query("DELETE FROM `user_notification` WHERE `id` = '$notification_id' ");

	mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)
							VALUES('".$_SESSION['user_id']."', '".$hostID."', 'invite_confirm', '".$event_added_on."', '1', '".$c_identifier."', 'club', 'club')");

	echo "update";

}

if($_POST['action'] == 'rejectInvite')
{
	$eventId = $_POST['event_id'];
	$djID = $_POST['dj_id'];
	$notification_id = $_POST['notification_id'];	
	$getHostinfo = mysql_query("SELECT * FROM `user_notification` WHERE `id` = '$notification_id' ");
	$fetchHostinfo = mysql_fetch_array($getHostinfo);
	$hostID = $fetchHostinfo['from_user'];
	$event_added_on = $fetchHostinfo['added_on'];
	$c_identifier = "dj_invitation_reject_".$eventId;
	mysql_query("DELETE FROM `dj_confirmation` WHERE `event_id` = '$eventId' AND `dj_id` = '$djID' ");
	mysql_query("DELETE FROM `user_notification` WHERE `id` = '$notification_id' ");

	mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)
							VALUES('".$_SESSION['user_id']."', '".$hostID."', 'invite_reject', '".$event_added_on."', '1', '".$c_identifier."', 'club', 'club')");

	echo "update";

}


if($_POST['action'] == 'changeTitle')
{
	$img_id = $_POST['imgId'];
	$title = mysql_real_escape_string($_POST['title']);
	if($_POST['type'] == "photo")
	{
		$updateQuery = mysql_query("UPDATE `uploaded` SET `image_title` = '$title' WHERE `img_id` = '$img_id'  ");
	}
	else
	{
		$updateQuery = mysql_query("UPDATE `uploaed_video` SET `video_title` = '$title' WHERE `video_id` = '$img_id'  ");	
	}
	if($updateQuery)
	{
		echo $_POST['title'];
	}
}

if($_POST['action'] == 'bookMe')
{
	$type = $_POST['booktypeName'];

	$updateQuery = mysql_query("SELECT * FROM `bookingstype` WHERE `name` = '$type' ");
	$FetchRes = mysql_fetch_array($updateQuery);

	echo $FetchRes['description'];
}


if($_POST['action'] == 'checkDate')
{
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

	if(strtotime($endDate)  <  strtotime($startDate)  )
	{
		echo "error";
	}
	else
	{
		echo "ok";
	}

}

if($_POST['action'] == "addStreamVideo")
{
	$path = mysql_real_escape_string($_POST['path']);
	$hostID = $_POST['host_id'];
	mysql_query("INSERT INTO `saved_streaming` (`host_id`,`video_path`,`active`,`user_type`) VALUES ('$hostID','$path','1','$_SESSION[user_type]') ");
}

if($_POST['action'] == "deleteStreamVideo")
{
	$path = mysql_real_escape_string($_POST['path']);
	$hostID = $_POST['host_id'];
	mysql_query("DELETE FROM `saved_streaming` WHERE `host_id` = '$hostID' AND `video_path` = '$path' ");
}

if($_GET['action'] == "subadmin")
{
	$str = $_GET['q'];
	$sql4="select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs
		where fs.user_id='".$_SESSION['user_id']."' AND fs.user_type = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
		GROUP BY friend_id ORDER BY id ASC";
	$sql6 = mysql_query($sql4);
	while($sql5=mysql_fetch_array($sql6))
	{                 
		if($i%2 == '0')
		{
			$class = " class='even' ";
		}
		else
		{
			$class = " class='odd' ";
		}

		if($sql5['friend_type'] == "user")
		{
			$friendQuery  = mysql_query("SELECT * FROM `user` 
								WHERE `id` = '$sql5[friend_id]'
								AND `profilename` LIKE '%$str%'
							");
			$friendResult = mysql_fetch_assoc($friendQuery);
			if($friendResult['profilename'] != "")
			{
				$friendName = $friendResult['profilename'];
			}
			else
			{
				$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
			}

			$friendCityid = $friendResult['city'];
			$friendStateid = $friendResult['state'];
			$friendCountryid = $friendResult['country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zipcode'];
			$friendSattus = $friendResult['status'];

		}
		else
		{
			$friendQuery  = mysql_query("SELECT `id`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
								FROM `clubs` 
								WHERE `id` = '$sql5[friend_id]'
								AND `club_name` LIKE '%$str%'
							");
			$friendResult = mysql_fetch_assoc($friendQuery);

			$friendName = $friendResult['club_name'];

			$friendCityid = $friendResult['club_city'];
			$friendStateid = $friendResult['club_state'];
			$friendCountryid = $friendResult['club_country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zip_code'];
			$friendSattus = $friendResult['status'];
		}
		echo $friendName."\n";
	}
}


if($_POST['action'] == 'getNewRow')
{
	$countRows = $_POST['rowscount'] + 1;
	?>
		<div class="row NewRow_<?php echo $countRows; ?>"> 
			<span class="formw">
				<input  type="text" placeholder="Episode <?php echo $countRows; ?>" name="event_date[]" class="multipleEventAdd" id="NewRow_<?php echo $countRows; ?>" >
				<i style="cursor:pointer;" class="addRow" onclick="deleteEventRow('<?php echo $countRows; ?>');"><img src="<?php echo $SiteURL;?>/images/DeleteRow.png" /></i>
			</span>
		</div>
		<script type="text/javascript">
			var myarray = [];

			var i = "";
			var j = "";
			for(i=0;i<=24;i++)
			{
				if(i<10)
				{
					i = "0"+i;
				}
				for(j=0;j<60;j++)
				{
					if(j<10)
					{
						j = "0"+j;
					}
					var total = i+":"+j
				   myarray.push(total);
				}
			}

			$('#NewRow_<?php echo $countRows; ?>').datetimepicker({
				format: 'Y-m-d H:i:00',
				timepicker: true,
				minDate: 0,
				allowTimes: myarray,
			});
		</script>
	<?php 
}

if($_POST['action'] == 'updatestreamingcounter')
{
	$hostID = $_POST['host_id'];
	if($hostID == $_SESSION['user_id'] && $_SESSION['user_type'] == $_POST['usertype'])
	{

	}
	else
	{
		if($_POST['usertype'] == 'user')
		{
			$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `user` WHERE `id` = '$hostID' ");
			$fetchCounter = mysql_fetch_assoc($getPreviousCounter);
			$NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] + 1;
			mysql_query("UPDATE `user` SET `streamingCounter` = '$NewstreamingCOUNTER' WHERE `id` = '$hostID' ");
		}
		elseif($_POST['usertype'] == 'club')
		{
			$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `clubs` WHERE `id` = '$hostID' ");
			$fetchCounter = mysql_fetch_assoc($getPreviousCounter);
			$NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] + 1;
			mysql_query("UPDATE `clubs` SET `streamingCounter` = '$NewstreamingCOUNTER' WHERE `id` = '$hostID' ");
		}
	}
}

if($_POST['action'] == 'updateStreamingCountervalue')
{
	$hostID = $_POST['host_id'];

	if($_POST['usertype'] == 'user')
	{
		$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `user` WHERE `id` = '$hostID' ");
		$fetchCounter = mysql_fetch_assoc($getPreviousCounter);
		echo $NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] ;
	}
	elseif($_POST['usertype'] == 'club')
	{
		$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `clubs` WHERE `id` = '$hostID' ");
		$fetchCounter = mysql_fetch_assoc($getPreviousCounter);
		echo $NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] ;
	}
	return false;
}


if($_POST['action'] == 'SetDefaultEpk' )
{
	$epkID = $_POST['epkID'];

mysql_query("UPDATE `epk_host_info` SET `status` = '0' WHERE `host_id` = '$_SESSION[user_id]' ");

	$Success = mysql_query("UPDATE `epk_host_info` SET `status` = '1' WHERE `epkId` = '$epkID'  ");
	if($Success)
	{
		echo 'ok';
	}
}

if($_POST['action'] == 'changeVideoInfo' )
{
	$videoID = str_replace('video_','', $_POST['videoid']);

	$getVideos1 = mysql_query("SELECT * FROM uploaed_video WHERE `video_id` = '$videoID'  ");
	$getDefault = mysql_fetch_assoc($getVideos1);

	if($getDefault['user_type'] == 'club')
	{
		$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$getDefault[host_id]'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
		if(!isset($_SESSION['user_id']))
		{
			$URL = $SiteURL.$fetchClubInfo['club_name'];
		}
		else
		{
			$URL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];
		}
		if( !empty($fetchClubInfo['club_name']) )
		{
			echo $fetchClubInfo['club_name'].'++++'.$SiteURL.$fetchClubInfo['image_nm'].'++++'.$URL;
		}
		else
		{
			echo 'MySitti++++'.$SiteURL.'images/man4.jpg'.$URL;
		}
	}
	else
	{
		$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$getDefault[host_id]'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);

		$URL = $SiteURL.'profile.php?id='.$fetchClubInfo['id'];
		if( !empty($fetchClubInfo['profilename']) )
		{
			echo $fetchClubInfo['profilename'].'++++'.$SiteURL.$fetchClubInfo['image_nm'].'++++'.$URL;
		}
		else
		{
			echo 'MySitti++++'.$SiteURL.'images/man4.jpg'.'++++'.$URL;
		}
	}

	
}

if($_POST['action'] == 'changeVideoInfoFeatured' )
{
	$Userid = $_POST['userID'];
	if($_POST['userType'] == 'club')
	{
		$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$Userid'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
		if(!empty($fetchClubInfo['image_nm']))
		{
			$image = $fetchClubInfo['image_nm'];
		}
		else
		{
			$image = 'images/man4.jpg';
		}
		if(!isset($_SESSION['user_id']))
		{
			$URL = $SiteURL.$fetchClubInfo['club_name'];
		}
		else
		{
			$URL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];
		}
		if( !empty($fetchClubInfo['club_name']) )
		{
			echo $fetchClubInfo['club_name'].'++++'.$SiteURL.$image.'++++'.$URL;
		}
		else
		{
			echo 'MySitti++++'.$image.'++++'.$URL;
		}
	}
	else
	{
		$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$Userid'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);

		$URL = $SiteURL.'profile.php?id='.$fetchClubInfo['id'];
		$PROFILENAME = trim($fetchClubInfo['profilename']);
		if(!empty($fetchClubInfo['image_nm']))
		{
			$image = $fetchClubInfo['image_nm'];
		}
		else
		{
			$image = 'images/man4.jpg';
		}
		if( !empty($PROFILENAME) )
		{
			echo $fetchClubInfo['profilename'].'++++'.$SiteURL.$image.'++++'.$URL;
		}
		if( !empty($fetchClubInfo['first_name']) )
		{
			echo $fetchClubInfo['first_name']." ".$fetchClubInfo['last_name'].'++++'.$SiteURL.$image.'++++'.$URL;
		}
		else
		{
			echo 'MySitti++++'.$image.'++++'.$URL;
		}
	}

	
}

if($_POST['action'] == 'addToPlaylist' )
{
	$bpid = $_POST['bpid'];
	$day = $_POST['day'];

	$countCheck = mysql_query("SELECT * FROM `mysittiTV` WHERE `weekDay` = '$day' ");
	$MyCount = mysql_num_rows($countCheck);

	if($_POST['checkbox'] == 'yes')
	{
		$MyCount = $MyCount+1;
		$getVideo = mysql_query("SELECT * FROM `battle_playlist` WHERE `id` = '$bpid' ");
		$fetchresult = mysql_fetch_assoc($getVideo);
		mysql_query("INSERT INTO `mysittiTV`(`video_path`,`host_id`,`weekDay`,`user_type`,`video_title`,`bpid`,`trackno`) VALUES ('$fetchresult[video_path]','$fetchresult[user_id]','$day','$fetchresult[user_type]','$fetchresult[video_title]','$bpid','$MyCount')  ");
		echo $lastId = mysql_insert_id();
	}
	else
	{
		$getVideo = mysql_query("DELETE FROM `mysittiTV` WHERE `bpid` = '$bpid' AND `weekDay` = '$day' ");
		echo "removed";
	}

}

if($_POST['action'] == 'sharePostPublic' )
{
	$forumid = $_POST['forumid'];
	$common_identifier = strtotime(date()).'_'.$forumid;
	$getForumPost = mysql_query("SELECT * FROM `forum` WHERE `forum_id` = '$forumid' ");
	$fetchforumPost = mysql_fetch_assoc($getForumPost);

	$getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
		GROUP BY friend_id ORDER BY id ASC");
	while($fetchFriends=mysql_fetch_assoc($getFriends))
	{
		//echo "<pre>"; print_r($fetchFriends); echo "</pre>";
		if($fetchFriends['friend_type'] == "user")
		{
			$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
								FROM `user` 
								WHERE `id` = '$fetchFriends[friend_id]'
							");
			$friendResult = mysql_fetch_assoc($friendQuery);
			if($friendResult['profilename'] != "")
			{
				$friendName = $friendResult['profilename'];
			}
			else
			{
				$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
			}

			$friendCityid = $friendResult['city'];
			$friendStateid = $friendResult['state'];
			$friendCountryid = $friendResult['country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zipcode'];
			$friendSattus = $friendResult['status'];
			$imageSrc = $friendResult['image_nm'];
			$anchorPath =	"profile.php?id=".$friendID;
			$onlineStatus = $friendResult['is_online']; 
			$postFrom = 'profile';

		}
		else
		{
			$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
								FROM `clubs` 
								WHERE `id` = '$fetchFriends[friend_id]'
								AND `non_member` = 0
							");
			$friendResult = mysql_fetch_assoc($friendQuery);
			$friendName = $friendResult['club_name'];
			$friendCityid = $friendResult['club_city'];
			$friendStateid = $friendResult['club_state'];
			$friendCountryid = $friendResult['club_country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zip_code'];
			$friendSattus = $friendResult['status'];
			$imageSrc = $friendResult['image_nm'];
			$anchorPath =	"host_profile.php?host_id=".$friendID;
			$onlineStatus = $friendResult['is_online'];
			$postFrom = 'blog';
		}

		mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`city_id`,`forum_type`,`status`,`contest_id`,`friends_id`,`group_id`,`user_type`,`from_user`,`post_from`,`postfrom_usertype`,`event_date`,`event_end_date`,`event_address`,`longitude`,`latitude`,`description`,`venue_name`,`event_category`,`state_id`,`country_id`,`event_id`,`shout_id`,`common_identifier`,`dj_id`,`post_count`) VALUES ('$fetchforumPost[forum]','$fetchforumPost[forum_img]','$fetchforumPost[image_thumb]','$fetchforumPost[forum_video]','$friendID','$fetchforumPost[city_id]','$fetchforumPost[forum_type]','$fetchforumPost[status]','$fetchforumPost[contest_id]','$fetchforumPost[friends_id]','$fetchforumPost[group_id]','$fetchFriends[friend_type]','$_SESSION[user_id]','$postFrom','$_SESSION[user_type]','$fetchforumPost[event_date]','$fetchforumPost[event_end_date]','$fetchforumPost[event_address]','$fetchforumPost[longitude]','$fetchforumPost[latitude]','$fetchforumPost[description]','$fetchforumPost[venue_name]','$fetchforumPost[event_category]','$fetchforumPost[state_id]','$fetchforumPost[country_id]','$fetchforumPost[event_id]','$fetchforumPost[shout_id]','$common_identifier','$fetchforumPost[dj_id]','$fetchforumPost[post_count]') ");


	}

}

if($_POST['action'] == 'sharePostFriends' )
{
	$forumid = $_POST['forumid'];
	$common_identifier = strtotime(date()).'_'.$forumid;

	$getForumPost = mysql_query("SELECT * FROM `forum` WHERE `forum_id` = '$forumid' ");
	$fetchforumPost = mysql_fetch_assoc($getForumPost);

	$string = explode(',', $_POST['string']);
	foreach ($string as $row)
	{
		$data = explode('-----', $row);
		$userID = $data[0];
		$userType = $data[1];
		if($userType == "user")
		{
			$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
								FROM `user` 
								WHERE `id` = '$userID'
							");
			$friendResult = mysql_fetch_assoc($friendQuery);
			if($friendResult['profilename'] != "")
			{
				$friendName = $friendResult['profilename'];
			}
			else
			{
				$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
			}

			$friendCityid = $friendResult['city'];
			$friendStateid = $friendResult['state'];
			$friendCountryid = $friendResult['country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zipcode'];
			$friendSattus = $friendResult['status'];
			$imageSrc = $friendResult['image_nm'];
			$anchorPath =	"profile.php?id=".$friendID;
			$onlineStatus = $friendResult['is_online']; 
			$postFrom = 'profile';

		}
		else
		{
			$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
								FROM `clubs` 
								WHERE `id` = '$userID'
								AND `non_member` = 0
							");
			$friendResult = mysql_fetch_assoc($friendQuery);
			$friendName = $friendResult['club_name'];
			$friendCityid = $friendResult['club_city'];
			$friendStateid = $friendResult['club_state'];
			$friendCountryid = $friendResult['club_country'];
			$friendID = $friendResult['id'];
			$friendZip = $friendResult['zip_code'];
			$friendSattus = $friendResult['status'];
			$imageSrc = $friendResult['image_nm'];
			$anchorPath =	"host_profile.php?host_id=".$friendID;
			$onlineStatus = $friendResult['is_online'];
			$postFrom = 'blog';
		}

		$Sucsess = mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`city_id`,`forum_type`,`status`,`contest_id`,`friends_id`,`group_id`,`user_type`,`from_user`,`post_from`,`postfrom_usertype`,`event_date`,`event_end_date`,`event_address`,`longitude`,`latitude`,`description`,`venue_name`,`event_category`,`state_id`,`country_id`,`event_id`,`shout_id`,`common_identifier`,`dj_id`,`post_count`) VALUES ('$fetchforumPost[forum]','$fetchforumPost[forum_img]','$fetchforumPost[image_thumb]','$fetchforumPost[forum_video]','$friendID','$fetchforumPost[city_id]','$fetchforumPost[forum_type]','$fetchforumPost[status]','$fetchforumPost[contest_id]','$fetchforumPost[friends_id]','$fetchforumPost[group_id]','$userType[friend_type]','$_SESSION[user_id]','$postFrom','$_SESSION[user_type]','$fetchforumPost[event_date]','$fetchforumPost[event_end_date]','$fetchforumPost[event_address]','$fetchforumPost[longitude]','$fetchforumPost[latitude]','$fetchforumPost[description]','$fetchforumPost[venue_name]','$fetchforumPost[event_category]','$fetchforumPost[state_id]','$fetchforumPost[country_id]','$fetchforumPost[event_id]','$fetchforumPost[shout_id]','$common_identifier','$fetchforumPost[dj_id]','$fetchforumPost[post_count]') ");

	}
	echo 'ok';
}


if($_POST['action'] == 'changeTrack' )
{
	$trackId = $_POST['trackId'];
	$trackOrder = $_POST['orderno'];
	$getTrackInfo = mysql_query("SELECT * FROM `mysittiTV` WHERE `id` = '$trackId' ");
	$fetchResult = mysql_fetch_assoc($getTrackInfo);
	$UpdateTrack = $fetchResult['trackno'];

	$day = $fetchResult['weekDay'];

	$getOtherTrack = mysql_query("SELECT * FROM `mysittiTV` WHERE `weekDay` = '$day' AND `trackno` = '$trackOrder' ");
	$fetchOther = mysql_fetch_assoc($getOtherTrack);
	$Updated = $fetchOther['id'];

//echo "UPDATE `mysittiTV` SET `trackno` = '$trackOrder' WHERE `id` = '$trackId' "; echo "<br>"; echo "UPDATE `mysittiTV` SET `trackno` = '$UpdateTrack' WHERE `id` = '$Updated' ";

	mysql_query("UPDATE `mysittiTV` SET `trackno` = '$trackOrder' WHERE `id` = '$trackId' ");
	mysql_query("UPDATE `mysittiTV` SET `trackno` = '$UpdateTrack' WHERE `id` = '$Updated' ");
}

if($_POST['action'] == 'changeTrack2' )
{
	echo $trackId = $_POST['trackId'];
	echo $trackOrder = $_POST['orderno'];

	$getTrackInfo = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$trackId' ");
	$fetchResult = mysql_fetch_assoc($getTrackInfo);
	$UpdateTrack = $fetchResult['track_no'];

	$getOtherTrack = mysql_query("SELECT * FROM `uploaed_video` WHERE `track_no` = '$trackOrder' ");
	$fetchOther = mysql_fetch_assoc($getOtherTrack);
	$Updated = $fetchOther['video_id'];

	mysql_query("UPDATE `uploaed_video` SET `track_no` = '$trackOrder' WHERE `video_id` = '$trackId' ");
	mysql_query("UPDATE `uploaed_video` SET `track_no` = '$UpdateTrack' WHERE `video_id` = '$Updated' ");
}

if($_GET['action'] == 'fetchcontestleaders')
{
	$total_contests = array();

	$total_contestents = array();
	$contest_id = $_GET['contid'];
	$condition = " LIMIT 0,10 ";
 	$contest_query = "SELECT * FROM contestent WHERE contestent.contest_id = '$contest_id'  ";

	$contest_list = mysql_query($contest_query);

	$i_count = 0;

	$getleadersql = mysql_query("SELECT A.user_type,A.user_id,A.contest_type,A.c_video_id,COUNT(B.c_video_id) as total FROM contestent as A,contest_video_like as B WHERE A.contest_id = ".$contest_id." AND A.c_video_id = B.c_video_id GROUP BY B.c_video_id ORDER BY total DESC,c_video_id ASC  ".$condition."   ");

	if(mysql_num_rows($getleadersql) > 0)
	{
		while($fetchleadersql = mysql_fetch_array($getleadersql))

		{

			$c_video_id=$fetchleadersql['c_video_id'];

			$i_count++;

			$get_video =mysql_query("Select * from `contestent` where c_video_id = '$c_video_id'");

			$fetchuservideo = mysql_fetch_array($get_video);

			$uid = $fetchleadersql['user_id'];

			$getusersql = mysql_query("SELECT * FROM clubs WHERE id = '$uid' ");

			$fetchusersql = mysql_fetch_array($getusersql);

								

			$getcitysql = mysql_query("SELECT * FROM capital_city WHERE city_id = ". $fetchusersql['club_city'])	;

			$fetchcitysql = mysql_fetch_array($getcitysql);

			

			$getstatesql = mysql_query("SELECT * FROM zone WHERE zone_id = ". $fetchusersql['club_state']);

			$fetchstatesql = mysql_fetch_array($getstatesql);



			if($fetchleadersql['user_type'] == "user")

			{
				$select_club_dt = mysql_query("SELECT * FROM user WHERE id = '".$fetchleadersql['user_id']."' AND `profilename` LIKE '%$_GET[q]%' ");

				$get_club_arr = mysql_fetch_assoc($select_club_dt);
				if($get_club_arr['profilename'] =='')
				{

					$uname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];

				}

				else

				{

					$uname = $get_club_arr['profilename'];

				}

		

			}

			else

			{

				$select_club_dt = mysql_query("SELECT * FROM clubs WHERE id = '".$fetchleadersql['user_id']."' AND `club_name` LIKE '%$_GET[q]%' ");

				$get_club_arr = mysql_fetch_assoc($select_club_dt);

				

				if($get_club_arr['club_name'] =='')

				{

					$uname = $get_club_arr['first_name']." ".$get_club_arr['last_name'];

				}

				else

				{

					$uname = $get_club_arr['club_name'];

				}



				$clubNAme= explode(" ", $uname);

				$username_dash_separated = implode("-", $clubNAme);

				$username_dash_separated = clean($username_dash_separated);								

			}

			

			$check_usr_exists = trim($uname);
			if(!empty($check_usr_exists))
			{
				echo $check_usr_exists."\n";
			}
			
			//echo "<pre>"; print_r($fetchleadersql); 

		}
	}
	else
	{
		echo "No Records Found";
	}
}


if($_POST['action'] == 'deleteBookinggallery' )
{
	$imgID = $_POST['imageid'];
	$getImageInfo = mysql_query("SELECT * FROM `bookingtype_gallery` WHERE `bid` = '$imgID' ");
	$res = mysql_fetch_assoc($getImageInfo);

	unlink($res['image_path']);
	unlink($res['thumb_path']);

	$success = mysql_query("DELETE FROM `bookingtype_gallery` WHERE `bid` = '$imgID'  ");
	if($success)
	{
		echo "OK";
	}
}

if($_POST['action'] == 'changeCatresults' )
{
	$catname = $_POST['catname'];
	$currdate = date('Y-m-d');
	$maincat = $_POST['maincat'];
	if($catname == '0')
	{
		$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$maincat' ORDER BY `name` ASC ");
		if(mysql_num_rows($getSubcats2) == 0)
		{
			$getSub = mysql_query("SELECT * FROM `club_category` WHERE `id` = '$maincat' ORDER BY `name` ASC ");
			$fetchR = mysql_fetch_assoc($getSub);
			$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchR[parrent_id]' ORDER BY `name` ASC ");
		}
		
		if(mysql_num_rows($getSubcats2) > 0)
		{
			while($rest2 = mysql_fetch_assoc($getSubcats2))
			{

				$getAllclubs = mysql_query("SELECT `clubc`.`name`,`ev`.`id` as `eventid`,`ev`.`event_image_thumb`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z`, `events` as `ev`,`club_category` as `clubc`
				WHERE `c`.`club_city` = `cc`.`city_id`
				AND `c`.`club_state` = `z`.`zone_id`
				AND `cc`.`state_id` = `z`.`zone_id`
				AND `c`.`id` = 	`ev`.`host_id`
				AND `clubc`.`id` = `c`.`type_of_club` 
				AND `c`.`club_city` = '$_SESSION[id]'
				AND `c`.`non_member` = '0'
				AND `c`.`type_details_of_club` LIKE '%$rest2[name]%'
				AND date(`ev`.`date`) = '$currdate'
				ORDER BY rand() ");
				if(mysql_num_rows($getAllclubs) > 0)
  				{
			?>
					<div class="ArtistBox">
						<a class="fullListView line-height" href="<?php echo $SiteURL;?>fullViewPage.php?fullPage=Artist">View All <img src="images/arrow_yellow.png" alt=""></a>
						<div class="clear"></div>
						<div class="listingTitle">
			   				<span><?php echo $rest2['name'];?></span>
						</div>
						<div class="MainListingArtst">
							<div class="img_slider_btm catsliderarea">
								<div>
									<ul class="hostSlider" <?php if(mysql_num_rows($getAllclubs) > 6){ echo ' id="catsHosts" '; } ?>>
									<?php 						
						  				while($rest3 = mysql_fetch_assoc($getAllclubs))
										{
							  				$profilename = trim($rest3['profilename']);
							  				if(empty($profilename))
							  				{
							  					$firstname = trim($rest3['first_name']);
							  					if(empty($firstname))
							  					{
							  						$noname = 'true';
							  					}
							  					else
							  					{
							  						$noname = 'false';
							  						$profilename = $rest3['first_name']." ".$rest3['last_name'];
							  					}
							  				}

							  				if(empty($rest3['image_nm']))
							  				{
							  					$rest3['image_nm'] = "images/man4.jpg";
							  				}

										?>

											<li>
												<span class="city_users"><?php echo $rest3['city_name'];?></span> 
												<span class="state_users"><?php echo $rest3['zonename'];?></span> 
												<a href="javascript:void(0);" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $rest3['eventid'];?>&amp;action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
													<img  alt="" src="<?php echo $SiteURL.str_replace("../", "", $rest3['event_image_thumb']);?>"> 
												</a>
												<div class="live_stream_new">
												</div>
												<span class="name_users" style="cursor:pointer;" onclick="window.location.href='<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $rest3['id'];?>' "><?php echo $rest3['profilename'];?></span>
											</li>
								<?php 		}	?>
									</ul>
								</div>
							</div>
						</div>
					</div>
	<?php 			}
			}
		}
	}
	else
	{
		$getAllclubs = mysql_query("SELECT `ev`.`id` as `eventid`,`ev`.`event_image_thumb`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z`, `events` as `ev`
		WHERE `c`.`club_city` = `cc`.`city_id`
		AND `c`.`club_state` = `z`.`zone_id`
		AND `cc`.`state_id` = `z`.`zone_id`
		AND `c`.`id` = 	`ev`.`host_id`
		AND `c`.`club_city` = '$_SESSION[id]'
		AND `c`.`non_member` = '0'
		AND `c`.`type_details_of_club` LIKE '%$catname%'
		AND date(`ev`.`date`) = '$currdate'
		ORDER BY rand() ");
		

		if(mysql_num_rows($getAllclubs) > 0)
		{
	?>
			<div class="ArtistBox">
				<a class="fullListView line-height" href="<?php echo $SiteURL;?>fullViewPage.php?fullPage=Artist">View All <img src="images/arrow_yellow.png" alt=""></a>
				<div class="clear"></div>
				<div class="listingTitle">
						<span><?php echo $catname;?></span>
				</div>
				<div class="MainListingArtst">
					<div class="img_slider_btm catsliderarea">
						<div>
							<ul class="hostSlider" <?php if(mysql_num_rows($getAllclubs) > 6){ echo ' id="catsHosts" '; } ?>>
							<?php 						
				  				while($rest3 = mysql_fetch_assoc($getAllclubs))
								{
					  				$profilename = trim($rest3['profilename']);
					  				if(empty($profilename))
					  				{
					  					$firstname = trim($rest3['first_name']);
					  					if(empty($firstname))
					  					{
					  						$noname = 'true';
					  					}
					  					else
					  					{
					  						$noname = 'false';
					  						$profilename = $rest3['first_name']." ".$rest3['last_name'];
					  					}
					  				}

					  				if(empty($rest3['event_image_thumb']))
					  				{
					  					$rest3['event_image_thumb'] = "images/man4.jpg";
					  				}

								?>

									<li>
										<span class="city_users"><?php echo $rest3['city_name'];?></span> 
										<span class="state_users"><?php echo $rest3['zonename'];?></span> 
										<a href="javascript:void(0);" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $rest3['eventid'];?>&amp;action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
											<img  alt="" src="<?php echo $SiteURL.str_replace("../", "", $rest3['event_image_thumb']);?>"> 
										</a>
										<div class="live_stream_new">
										</div>
										<span class="name_users"><?php echo $rest3['profilename'];?></span> 
									</li>
						<?php 		}	?>
							</ul>
						</div>
					</div>
				</div>
			</div>
	<?php 	}
		else
		{
	?>
			<div class="ArtistBox">
				<!-- <a class="fullListView line-height" href="#">Full List <img src="images/arrow_yellow.png" alt=""></a> -->
				<div class="clear"></div>
				<div class="listingTitle">
						<span><?php echo $catname;?></span>
				</div>
				<div class="MainListingArtst">
					<h4 class="noCtasFound">No Hosts Found</h4>
				</div>
			</div>
	<?php
		}
	}

	
}

if($_POST['action'] == 'tonightArtist')
{
	$tDate = $_POST['date'];
	$getEvent = mysql_query("SELECT * FROM forum WHERE event_date = '$tDate' LIMIT 5");
	if(mysql_num_rows($getEvent) > 0)
	{
		while($event = mysql_fetch_assoc($getEvent))
		{ ?>
			<li class="custom_slide"> 
				<span class="city_users"><?php echo $event['forum'];?></span> 
				<span class="state_users"><?php echo $event['event_date'];?></span>
				<!-- <a href="<?php echo $SiteURL.$urlConcatenate.$newres['id'];?>"> --> 
					<img src="<?php 
					if(empty($event['image_thumb']))
	  				{
	  					$event['image_thumb'] = "images/man4.jpg";
	  				}
					echo $SiteURL.$event['image_thumb'];?>" alt=""> 
				<!-- </a> -->
				<div class="live_stream_new"> </div>
				<span class="name_users">
					<?php echo $event['event_address'];?>
				</span> 
			</li>
		<?php }
	}
}

if($_POST['action'] == 'changeCatresultsusingName' )
{
	$uname = $_POST['uname'];
	$catid = $_POST['catid'];
	$currdate = date('Y-m-d');
	$getClubINfo = mysql_query("SELECT * FROM `clubs` WHERE `club_name` = '$uname' ");
	$fetchClubInfo = mysql_fetch_assoc($getClubINfo);
	$type_details_of_club = $fetchClubInfo['type_details_of_club'];
	$type_details_of_club_array = explode(',', $type_details_of_club);


	$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$catid' ORDER BY `name` ASC ");
	if(mysql_num_rows($getSubcats2) > 0)
	{
		while($rest2 = mysql_fetch_assoc($getSubcats2))
		{
			if(in_array($rest2['name'], $type_details_of_club_array))
			{
				$getAllclubs = mysql_query("SELECT `ev`.`id` as `eventid`,`ev`.`event_image_thumb`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z`, `events` as `ev`
				WHERE `c`.`club_city` = `cc`.`city_id`
				AND `c`.`club_state` = `z`.`zone_id`
				AND `cc`.`state_id` = `z`.`zone_id`
				AND `c`.`id` = 	`ev`.`host_id`
				AND `c`.`club_city` = '$_SESSION[id]'
				AND `c`.`non_member` = '0'
				AND `c`.`club_name` = '$uname'
				AND date(`ev`.`date`) = '$currdate'
				ORDER BY rand() ");
				if(mysql_num_rows($getAllclubs) > 0)
				{
	?>
					<div class="ArtistBox">
						<a class="fullListView line-height" href="<?php echo $SiteURL;?>fullViewPage.php?fullPage=Artist">View All <img src="images/arrow_yellow.png" alt=""></a>
						<div class="clear"></div>
						<div class="listingTitle">
								<span><?php echo $rest2['name'];?></span>
						</div>
						<div class="MainListingArtst">
							<div class="img_slider_btm catsliderarea">
								<div>
									<ul class="hostSlider" <?php if(mysql_num_rows($getAllclubs) > 6){ echo ' id="catsHosts" '; } ?>>
									<?php 						
						  				while($rest3 = mysql_fetch_assoc($getAllclubs))
										{
							  				$profilename = trim($rest3['profilename']);
							  				if(empty($profilename))
							  				{
							  					$firstname = trim($rest3['first_name']);
							  					if(empty($firstname))
							  					{
							  						$noname = 'true';
							  					}
							  					else
							  					{
							  						$noname = 'false';
							  						$profilename = $rest3['first_name']." ".$rest3['last_name'];
							  					}
							  				}

							  				if(empty($rest3['event_image_thumb']))
							  				{
							  					$rest3['event_image_thumb'] = "images/man4.jpg";
							  				}

										?>

											<li>
												<span class="city_users"><?php echo $rest3['city_name'];?></span> 
												<span class="state_users"><?php echo $rest3['zonename'];?></span> 
												<a href="javascript:void(0);" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $rest3['eventid'];?>&amp;action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
													<img  alt="" src="<?php echo $SiteURL.str_replace("../", "", $rest3['event_image_thumb']);?>"> 
												</a>
												<div class="live_stream_new">
												</div>
												<span class="name_users" style="cursor:pointer;" onclick="window.location.href='<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $rest3['id'];?>' "><?php echo $rest3['profilename'];?></span>
											</li>
								<?php 		}	?>
									</ul>
								</div>
							</div>
						</div>
					</div>
			<?php 	}
				else
				{
			?>
					<div class="ArtistBox">
						<!-- <a class="fullListView line-height" href="#">Full List <img src="images/arrow_yellow.png" alt=""></a> -->
						<div class="clear"></div>
						<div class="listingTitle">
								<span><?php echo $catname;?></span>
						</div>
						<div class="MainListingArtst">
							<h4 class="noCtasFound">No Hosts Found</h4>
						</div>
					</div>
			<?php
				}
			}
		}
	}
}



if($_GET['action'] == 'fliersnames' )
{
	$currdate = date('Y-m-d');
	$catname = $_POST['catname'];
	$getAllclubs = mysql_query("SELECT `ev`.`id` as `eventid`,`ev`.`event_image_thumb`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z`, `events` as `ev`
	WHERE `c`.`club_city` = `cc`.`city_id`
	AND `c`.`club_state` = `z`.`zone_id`
	AND `cc`.`state_id` = `z`.`zone_id`
	AND `c`.`id` = 	`ev`.`host_id`
	AND `c`.`club_city` = '$_SESSION[id]'
	AND `c`.`non_member` = '0'
	AND `c`.`type_details_of_club` LIKE '%$catname%'
	AND date(`ev`.`date`) = '$currdate'
	ORDER BY rand() ");
	if(mysql_num_rows($getAllclubs) > 0)
	{
		while ($row = mysql_fetch_assoc($getAllclubs))
		{
			echo $row['profilename']."\n";
		}
		
	}
	else
	{
		echo "No Results Found";
	}

	
}

if($_POST['action'] == 'fetchartistCats' )
{
	$catname = $_POST['catname'];
	$getCatdetails = mysql_query("SELECT * FROM `club_category` WHERE `name` = '$catname' ");
	$fetchdetails = mysql_fetch_assoc($getCatdetails);
	$getSubcats = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchdetails[id]' ORDER BY name");
	if(mysql_num_rows($getSubcats) > 0)
	{
		while($result = mysql_fetch_assoc($getSubcats))
		{
	?>
			<li>
				<input type="checkbox" name="type_of_artist[]" value="<?php echo $result['name'];?>" style="margin-right: 6px;" /><?php echo $result['name'];?>
			</li>
	<?php
		}
	}
}

if($_POST['action'] == 'browseArtists' )
{ //echo "<pre>"; print_r($_POST); die;
	if(isset($_POST['data']) && !empty($_POST['data']))
	{
		$getAllArtists = mysql_query("SELECT `c`.`id`,`c`.`type_details_of_club` FROM `clubs` as `c`
						WHERE  `c`.`club_city` = '$_SESSION[id]'
						AND `c`.`non_member` = '0'
						AND `c`.`type_of_club` IN ('108','97','101','96')
						ORDER BY rand() ");
		while($result = mysql_fetch_assoc($getAllArtists))
		{
			$type_details_of_club = $result['type_details_of_club'];
			
			foreach($_POST['data'] as $category)
			{
				$category = trim($category);
				if (preg_match("/\b$category\b/i", $type_details_of_club)) 
				{
					$HostIdArray[] = $result['id'];
				} 
			}
		}
		// echo "<pre>"; print_r(array_unique($HostIdArray));
		$newArray = array_unique($HostIdArray);
		if(!empty($newArray)) {
		foreach($newArray as $getresult)
		{
			$getAllArtists2 = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`club_city` = `cc`.`city_id`
			  				AND `c`.`club_state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`club_city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`id` =  '$getresult'
			  				 ");
			$clubs = mysql_fetch_assoc($getAllArtists2);
			if(empty($clubs['image_nm']))
			{
				$clubs['image_nm'] = "images/man4.jpg";
			}
?>
			<li> 
				<span class="city_users"><?php echo $clubs['city_name'];?></span> 
				<span class="state_users"><?php echo $clubs['zonename'];?></span>
				<a href="<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $clubs['id'];?>"> 
					<img alt="" src="<?php echo $SiteURL.str_replace("../", "", $clubs['image_nm']);?>"> 
				</a>
				<div class="live_stream_new"> </div>
				<span class="name_users">
					<?php echo $clubs['profilename'];?>
				</span> 
			</li>
<?php
		}
		} else {

			echo "<h1 class='record_not_found'>No result found.</h1>";
		}
	}
	else
	{
		$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
		  				WHERE `c`.`club_city` = `cc`.`city_id`
		  				AND `c`.`club_state` = `z`.`zone_id`
		  				AND `cc`.`state_id` = `z`.`zone_id`
		  				AND `c`.`club_city` = '$_SESSION[id]'
		  				AND `c`.`non_member` = '0'
		  				AND `c`.`type_of_club` IN ('108','97','101','96')
		  				ORDER BY rand() ");
		while($clubs = mysql_fetch_assoc($getAllArtists))
		{
			if(empty($clubs['image_nm']))
			{
				$clubs['image_nm'] = "images/man4.jpg";
			}
			?>
			<li> 
				<span class="city_users"><?php echo $clubs['city_name'];?></span> 
				<span class="state_users"><?php echo $clubs['zonename'];?></span>
				<a href="<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $clubs['id'];?>"> 
					<img alt="" src="<?php echo $SiteURL.str_replace("../", "", $clubs['image_nm']);?>"> 
				</a>
				<div class="live_stream_new"> </div>
				<span class="name_users">
					<?php echo $clubs['profilename'];?>
				</span> 
			</li>
<?php 		}	
	} 
}




if($_GET['action'] == 'filternames' )
{
	//echo "<pre>"; print_r($_SESSION['MAINCAT'][0]); exit;
	$namesArray = array_unique($_SESSION['MAINCAT']);
	$implodedMainCat = implode(",", $namesArray);
	$string = trim($_GET['q']);
	$getAllArtists = mysql_query('SELECT * FROM `clubs` as `c`
							WHERE `c`.`type_of_club` IN ('.$implodedMainCat.')
							AND `c`.`club_name` LIKE "%'.$string.'%"
							AND `c`.`club_city` = "'.$_SESSION['id'].'"
							ORDER BY `id` ASC ');
	while($search = mysql_fetch_assoc($getAllArtists))
	{
		$HostIdArray[] = trim($search['club_name']);
	}

	$NewArray = array_unique($HostIdArray);
	if(!empty($NewArray))
	{
		foreach($NewArray as $name)
		{
			echo $name."\n";
		}
		die;
	}
	else
	{
		echo "No Results Found.";
	}
	
}

if($_POST['action'] == 'unsetsession' )
{
	unset($_SESSION['MAINCAT']);
}

if($_GET['action'] == 'FullViewArtistsNames' )
{
	$type = $_GET['fullviewtype'];
	$fullView = $_GET['fullview'];

	if($fullView == 'Streaming')
	{
		if($type == 'hosts')
		{
			$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`club_city` = `cc`.`city_id`
			  				AND `c`.`club_state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`club_city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`club_name` LIKE '%".$_GET['q']."%'
			  				ORDER BY rand() ");
		}
		else
		{
			$getAllArtists = mysql_query("SELECT `c`.`first_name`,`c`.`last_name`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`profilename` as `profilename` FROM `user` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`city` = `cc`.`city_id`
			  				AND `c`.`state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`club_name` LIKE '%".$_GET['q']."%'
			  				ORDER BY rand() ");
		}
	}
	else
	{
		$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`club_city` = `cc`.`city_id`
			  				AND `c`.`club_state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`club_city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`club_name` LIKE '%".$_GET['q']."%'
			  				ORDER BY rand() ");
	}

	while($clubs = mysql_fetch_assoc($getAllArtists))
	{
		if(empty($clubs['image_nm']))
		{
			$clubs['image_nm'] = "images/man4.jpg";
		}
		if(empty($clubs['profilename']))
		{
			$clubs['profilename'] = $clubs['first_name']." ".$clubs['last_name'];
		}
		$pname = trim($clubs['profilename']);

		if(!empty($pname))
		{
			echo $pname."\n";
		}
	}
	die;
}

if($_POST['action'] == 'getResultFromField' )
{
	$type = $_POST['fullviewtype'];
	$fullView = $_POST['fullview'];

	if($fullView == 'Streaming')
	{
		if($type == 'hosts')
		{
			$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`club_city` = `cc`.`city_id`
			  				AND `c`.`club_state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`club_city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`club_name` = '$_POST[uname]'
			  				ORDER BY rand() ");
		}
		else
		{
			$getAllArtists = mysql_query("SELECT `c`.`first_name`,`c`.`last_name`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`profilename` as `profilename` FROM `user` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`city` = `cc`.`city_id`
			  				AND `c`.`state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`profilename` = '$_POST[uname]'
			  				ORDER BY rand() ");
		}
	}
	else
	{
		$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			  				WHERE `c`.`club_city` = `cc`.`city_id`
			  				AND `c`.`club_state` = `z`.`zone_id`
			  				AND `cc`.`state_id` = `z`.`zone_id`
			  				AND `c`.`club_city` = '$_SESSION[id]'
			  				AND `c`.`non_member` = '0'
			  				AND `c`.`club_name` = '$_POST[uname]'
			  				ORDER BY rand() ");
	}

	while($clubs = mysql_fetch_assoc($getAllArtists))
	{
		if(empty($clubs['image_nm']))
		{
			$clubs['image_nm'] = "images/man4.jpg";
		}
		if(empty($clubs['profilename']))
		{
			$clubs['profilename'] = $clubs['first_name']." ".$clubs['last_name'];
		}
		$pname = trim($clubs['profilename']);

		if(!empty($pname))
		{
			?>
			<li> 
				<span class="city_users"><?php echo $clubs['city_name'];?></span> 
				<span class="state_users"><?php echo $clubs['zonename'];?></span>
				<a href="<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $clubs['id'];?>"> 
					<img alt="" src="<?php echo $SiteURL.str_replace("../", "", $clubs['image_nm']);?>"> 
				</a>
				<div class="live_stream_new"> </div>
				<span class="name_users">
					<?php echo $clubs['profilename'];?>
				</span> 
			</li>
			<?php
		}
	}
	die;
}

if($_POST['action'] == 'addToPlayer' )
{
	$videoId = $_POST['videoId'];
	$postAction = $_POST['postAction'];
	if($postAction == 'Add')
	{
		mysql_query("UPDATE `uploaed_video` SET `featured` = '1' WHERE `video_id` = '$videoId' ");
	}
	else
	{
		mysql_query("UPDATE `uploaed_video` SET `featured` = '0' WHERE `video_id` = '$videoId' ");
	}
	
}

if($_POST['action'] == 'profileSecurity' )
{
	$value = $_POST['value'];
	if($_SESSION['user_type'] == 'club')
	{
		if($value == 'public')
		{
			mysql_query("UPDATE `clubs` SET `profileType` = 'Public' WHERE `id` = '$_SESSION[user_id]' ");
		}
		else
		{
			mysql_query("UPDATE `clubs` SET `profileType` = 'Private' WHERE `id` = '$_SESSION[user_id]' ");
		}
	}
	else
	{
		if($value == 'public')
		{
			mysql_query("UPDATE `user` SET `profileType` = 'Public' WHERE `id` = '$_SESSION[user_id]' ");
		}
		else
		{
			mysql_query("UPDATE `user` SET `profileType` = 'Private' WHERE `id` = '$_SESSION[user_id]' ");
		}
	}
	
}

if($_POST['action'] == 'ContactSubmit' )
{
	// echo "<pre>"; print_r($_SESSION);
	$today = date("Y-m-d h:i:s");
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	// $fname=$_POST['fname'];
	$enquiry=$_POST['enquiry'];
	$CODE = $_POST['captchaCode'];
	if($CODE == $_SESSION['letters_code'])
	{
		$ValueArray = array($fname,$lname,$email,$enquiry,$today);
		$FieldArray = array('fname','lname','email','enquiry','adde_on');
		$ThisPageTable='contact_us';		
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		if($Success > 0)
		{
					
			$fetch_c_email = mysql_query("SELECT * FROM admin_contact_emails WHERE type = 'contact_email'");
			$f_count_e = mysql_num_rows($fetch_c_email);
			
			if($f_count_e > 0){
				
				$get_e_value = mysql_fetch_assoc($fetch_c_email);
				
				$e_value = $get_e_value['email'];
				
				}else{
					
				$e_value = "mysitti@mysittidev.com";
					
				}
					
		                    $to = $e_value;
		                    $subject = "New Enquiry";

		                    $message = "
		                    <html>
		                    <head>
		                    <title>Enquiry</title>
		                    </head>
		                    <body>
		                    <h1>Enquiry Details</h1>
		                    <table>
		                    <tr>
		                    <th>Firstname</th>
		                    <th>Lastname</th>
		                    <th>Email</th>
		                    <th>Enquiry</th>
		                    </tr>
		                    <tr>
		                    <td>".$fname."</td>
		                    <td>".$lname."</td>
		                    <td>".$email."</td>
		                    <td>".$enquiry."</td>
		                    </tr>
		                    </table>
		                    </body>
		                    </html>
		                    ";

		                    // Always set content-type when sending HTML email
		                    $headers = "MIME-Version: 1.0" . "\r\n";
		                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		                    // More headers
		                    $headers .= 'From: <'.$email.'>' . "\r\n";
		                    //$headers .= 'Cc: myboss@example.com' . "\r\n";

		                    mail($to,$subject,$message,$headers);
							//$Obj->Redirect("contact_us.php?msg=success");
							//die;
				echo  "Thanks for contacting us. We will Contact you as soon as Possible.";
		}
	}
	else
	{
		echo "NO";
	}
}

if($_POST['action'] == 'checkMerchant' )
{
	$checkMerchant = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
	$fetchresult = mysql_fetch_assoc($checkMerchant);
	$merchantID = trim($fetchresult['merchant_id']);
	if(empty($merchantID))
	{
		echo 'No';
	}
	else
	{
		echo 'Yes';
	}
}

if($_POST['action'] == 'setDefaultVideo' )
{
	$vid = $_POST['videoid'];
	$getData = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$vid' ");
	$fetchdata = mysql_fetch_assoc($getData);

	$userId = $fetchdata['user_id'];
	$userType = $fetchdata['user_type'];
	

	$setDefaultVideo = mysql_query("UPDATE `uploaed_video` SET `default_video` = '0' WHERE `user_id` = '$userId' AND `user_type` = '$userType' AND `video_id` NOT IN ($vid) ");
	$setDefaultVideo = mysql_query("UPDATE `uploaed_video` SET `default_video` = '1', `featured` = '1' WHERE `video_id` = '$vid' ");
	die;
}


?>
