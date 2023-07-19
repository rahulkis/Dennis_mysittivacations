<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
	//echo "select trackname,artist from music where trackname ='$_REQUEST[m_title]'";
session_start();        

if ($_GET['title'] == 'allclubs')
{
		
	$string = $_GET['q'];  
	$get_groups = @mysql_query("SELECT `club_name`,`id` FROM `clubs` WHERE `club_name` LIKE '%$string%' ORDER BY `club_name` ASC ");
	while($traks_res = @mysql_fetch_assoc($get_groups))
	{
		echo $traks_res['club_name']."\n";
									 
	}
	return false;
}


if ($_GET['title'] == 'title')
 {
		
		
$traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where music_title LIKE '%$_REQUEST[q]%' AND host_id = $_GET[host_id] ORDER BY music_title LIMIT 10");
				
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									
										echo $traks_res['music_title']."\n";
									 
								} return false;
}
if ($_GET['artist'] == 'artist')
{
		$traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where artist_name LIKE '%$_REQUEST[q]%' AND host_id = $_GET[host_id] ORDER BY artist_name LIMIT 10");
				
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									
										echo $traks_res['artist_name']."\n";
									 
								} 
						return false;
}
								
if($_REQUEST['remove'] == 'remove')
{
								 
	if($_REQUEST['remove2'] == 'remove2' )
	{
									 @mysql_query("DELETE FROM `jukebox` WHERE `jukebox`.`id` = $_REQUEST[remove_id]");
											
									$traks = @mysql_query("select music_title,artist,id from jukebox where user_id =$_SESSION[user_id] AND host_id = $_REQUEST[host_id]");       
									while($traks_res = @mysql_fetch_assoc($traks))
															{
																
																	echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
																	echo '<div>'.$traks_res['artist'].'</div>';
																	echo '<div><a class="remove" id="'.$traks_res[id].'">Remove</a></div></div>';
															}
													 $check_selected = @mysql_query("SELECT `music_id` FROM `jukebox` where user_id =$_SESSION[user_id] AND host_id =$_REQUEST[host_id]");
						$check_array = array();
						 while($check_selected_res =@mysql_fetch_assoc($check_selected))
							{
									$check_array[] = $check_selected_res['music_id'];
							}
	}

if($_REQUEST['refresh_bottum'] == 'refresh_bottum')
		{
				$check_selected = @mysql_query("SELECT `music_id` FROM `jukebox` where user_id =$_SESSION[user_id] AND host_id =$_REQUEST[host_id]");
					$check_array = array();
					 while($check_selected_res =@mysql_fetch_assoc($check_selected))
						{
								$check_array[] = $check_selected_res['music_id'];
						}
					
				 
				$traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where host_id =$_REQUEST[host_id]");
				$check = 0;
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									if(in_array($traks_res[id] , $check_array)){$c = "checked "; $d = 'disabled = "disabled" ';} else {$c = " "; $d= " "; }
										
										echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
										echo '<div>'.$traks_res['artist_name'].'</div>';
										echo '<div><input '.$d.' type="checkbox" name="" id="'.$traks_res[id].'" class="selectedmusic" '.$c.'></div></div>';
							 $check++; }   
								 
		}            
	 return false;
}
								
if($_REQUEST['newsearch'] == 'newsearch')
                {

                        $traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where music_title ='$_REQUEST[mu_title]' AND host_id =$_REQUEST[host_id]");       
                        while($traks_res = @mysql_fetch_assoc($traks))
                    {
                      
                        echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
                        echo '<div>'.$traks_res['artist_name'].'</div>';
                        echo '<div><input type="checkbox" name="" id="'.$traks_res[id].'" class="selectedmusic"></div></div>';
                    }
                    
                    $traks1 = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where artist_name ='$_REQUEST[mu_artist]' AND host_id =$_REQUEST[host_id]");       
                        while($traks_res1 = @mysql_fetch_assoc($traks1))
                    {
                      
                        echo '<div class="selctd_music"><div>'.$traks_res1['music_title'].'</div>';
                        echo '<div>'.$traks_res1['artist_name'].'</div>';
                        echo '<div><input type="checkbox" name="" id="'.$traks_res1[id].'" class="selectedmusic"></div></div>';
                    }
        
                    
                    return false;
                    
                }

if($_REQUEST['pay'] == 'pay' )
{
	$a = 0;
	$trakspay = @mysql_query("select music_title,artist,id from jukebox where user_id =$_REQUEST[user_id] AND host_id =$_REQUEST[host_id]");       
	while($traks_respay = @mysql_fetch_assoc($trakspay)){
		echo '<form action="ChainPay_selectedlist.php" mothod="post">';
		echo '<div class="selctd_music"><div>'.$traks_respay['music_title'].'</div>';
		echo '<div>'.$traks_respay['artist'].'</div>';
		//echo '<div><a class="remove" id="'.$traks_respay[id].'">Remove</a></div></div>';
		echo '</div>';
		$selected_track_id[$a] = $traks_respay[id];
		$a++;
	}
	echo '<div class="selctd_music"><div>TOTAL</div>';
	//echo '<div>&nbsp;</div>';
	echo '<div><a class="remove">$'.$a*$_REQUEST[price].'</a></div></div>';
	echo "<input type='hidden' name='Amount' value='".$a*$_REQUEST[price]."' /> ";
	echo '<div class="send_list"><input type="submit" name="" value="Confirm" id="confirm">';
	echo '<input type="button" name="" value="Cancel" id="disagree" onclick="disagree();"></div></form>';

	$selectedlist = array();
	$_SESSION['selectedlist']['host_id'] = $_REQUEST['host_id'];
	$_SESSION['selectedlist']['track_count'] = $a;
	$_SESSION['selectedlist']['special_note'] = $_REQUEST['special_note'];
	$_SESSION['selectedlist']['amount'] = $a*$_REQUEST[price];
	$_SESSION['selectedlist']['selectedlist_track_id'] = $selected_track_id;
	return false;
}

if($_REQUEST['action'] == 'free' ){
	$a = 0;
	$trakspay = @mysql_query("select music_title,artist,id from jukebox where user_id =$_REQUEST[user_id] AND host_id =$_REQUEST[host_id]");       
	while($traks_respay = @mysql_fetch_assoc($trakspay)){
		$selected_track_id[$a] = $traks_respay[id];
		$a++;
	}
				
	$selectedlist = array();
	$_SESSION['selectedlist']['host_id'] = $_REQUEST['host_id'];
	$_SESSION['selectedlist']['track_count'] = $a;
	$_SESSION['selectedlist']['special_note'] = $_REQUEST['special_note'];
	$_SESSION['selectedlist']['amount'] = $a*$_REQUEST[price];
	$_SESSION['selectedlist']['selectedlist_track_id'] = $selected_track_id;

	
	return false;
}



/*** checkbox ajax ***/                
if($_REQUEST['id'])
{
				
				$music_id = $_REQUEST['id'];
				$user_id = $_REQUEST['user_id'];
				$host_id = $_REQUEST['host_id'];
			 
				$sel = @mysql_query("select music_title,artist_name from hostplaylist where id =$_REQUEST[id]");
				$selres = @mysql_fetch_assoc($sel);
				
					 $m_title = $selres['music_title'];
					 $m_artist = $selres['artist_name'];
					
				$checkif = @mysql_query("SELECT `music_id` FROM `jukebox` where user_id =$user_id AND host_id = $_REQUEST[host_id] AND music_id =$music_id");
				
				$countrow = mysql_numrows($checkif);
				
				if($countrow == '0')
						{
				@mysql_query("INSERT INTO `jukebox`(`id`, `music_id`, `host_id`, `user_id`, `music_title`, `artist`) VALUES ('','$music_id','$host_id','$user_id','$m_title','$m_artist')");
				$traks = @mysql_query("select music_title,artist,id from jukebox where music_id =$music_id");       
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									
										echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
										echo '<div>'.$traks_res['artist'].'</div>';
										echo '<div><a class="remove" id="'.$traks_res[id].'">Remove</a></div></div>';
										return false;
								}
								
						}               
									
if($_REQUEST['refresh_bottum'] == 'refresh_bottum')
		{
				
				$check_selected = @mysql_query("SELECT `music_id` FROM `jukebox` where user_id =$_SESSION[user_id] AND host_id =$_REQUEST[host_id]");
					$check_array = array();
					 while($check_selected_res =@mysql_fetch_assoc($check_selected))
						{
								$check_array[] = $check_selected_res['music_id'];
						}
					
				 
				$traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where host_id =$_REQUEST[host_id]");
				$check = 0;
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									if(in_array($traks_res[id] , $check_array)){$c = "checked"; $d = 'disabled = "disabled" ';} else {$c = " "; $d= " "; }
										
										echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
										echo '<div>'.$traks_res['artist_name'].'</div>';
										echo '<div><input '.$d.' type="checkbox" name="" id="'.$traks_res[id].'" class="selectedmusic" '.$c.'></div></div>';
										$check++; 
								}   
								return false; 
		}   
		return false;
				
				
		}  
		

								
/**** onload ***/  
if($_REQUEST['selected'] != "selected")
{
					 
					$check_selected = @mysql_query("SELECT `music_id` FROM `jukebox` where user_id =$_SESSION[user_id] AND host_id =$_REQUEST[host_id]");
					$check_array = array();
					 while($check_selected_res =@mysql_fetch_assoc($check_selected))
						{
								$check_array[] = $check_selected_res['music_id'];
						}
					
				 
				$traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where host_id =$_REQUEST[host_id]");
				$check = 0;
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									if(in_array($traks_res[id] , $check_array)){$c = "checked"; $d = 'disabled = "disabled" ';} else {$c = " "; $d= " "; }
										
										echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
										echo '<div>'.$traks_res['artist_name'].'</div>';
										echo '<div><input '.$d.' type="checkbox" name="" id="'.$traks_res[id].'" class="selectedmusic" '.$c.'></div></div>';
							 $check++; }
							 
							 
							 ?>
	<script>
$(document).ready(function()
		{

		$('.selectedmusic').live('click',function()
													{
														
		var isChecked = $(this).is(':checked');                        
								if(isChecked == true)
								 {
														var selected = "selected";            
														var id = $(this).attr('id');
														var user_id = $('#uid').val();
														var host_id = $('#hid').val();
						
														
														$.ajax({
																		type: "POST",
																		url: "jukeboxquery.php",
																		data: {
																		'id' : id,
																		'user_id' : user_id,
																		'host_id' : host_id,
																		'selected' : selected           
																		
																},
																success: function(data)
																	{
																		
																		 $('.selctd_music_list').append(data);
																		 
																										$.ajax
																								({
																									 type: "POST",
																									 url: "jukeboxquery.php",
																									 data: {
																									 
																									 'user_id' : user_id,
																									 'host_id' : host_id,
																									 'refresh_bottum' : 'refresh_bottum'           
																									 
																							 },
																							 success: function(data)
																								 {                                  
																										$('.select_music_res').html(data);
																								 }
																						});
																		 
																	}
														 });
								
										}

								
												 });
		
$("#searchlist").live('click',function() {
	
	var mu_title  = $('#m_title').val();
	var mu_artist = $('#m_artist').val();
	var host_id = $('#hid').val();
	var newsearchlist  = 'newsearch'; 
	
	$.ajax({
				type: "POST",
				url: "jukeboxquery.php",
				data: {
						'mu_title' : mu_title,
						'mu_artist' : mu_artist,
			'host_id' : host_id,
			'newsearch' : newsearchlist
						
						
				},
				success: function(data){
					$('.select_music_res').html(data);
					 $('#m_title').val('');
					 $('#m_artist').val('');
					
					}
			 });
	
	
	});    
		
		
$('.remove').live('click',function(){
		
		var id = $(this).attr('id');
		var remove = 'remove';
		var host_id = $('#hid').val();
		 $.ajax({
				type: "POST",
				url: "jukeboxquery.php",
				data: {
						'remove_id' : id,
						'host_id' : host_id,
						'remove2' : 'remove2',
						'remove' : remove          
						
				},
				success: function(data){            
					$('.selctd_music_list').html(data);
					
												$.ajax({
										 type: "POST",
										 url: "jukeboxquery.php",
										 data: {
												 'remove_id' : id,
												 'host_id' : host_id,
												 'refresh_bottum' : 'refresh_bottum',
												 'remove' : remove          
												 
										 },
										 success: function(data){            
											 $('.select_music_res').html(data);
											 
											 }
										});
					
					}
			 });
		
		
		});

$('#disagree').live('click',function(){
		window.location = document.URL;
		});    
 
						 });
				
	 
</script>
				
<?php }
/**** onload ***/  
else    {
				
				
				if($_REQUEST[host_id]){ $traks = @mysql_query("select music_title,artist_name,id,host_id from hostplaylist where host_id =$_REQUEST[host_id]");}
				
				//if($_REQUEST['q']){$traks = mysql_query("select trackname,artist,id,host_id from music where trackname LIKE '%$_REQUEST[q]%' ORDER BY trackname LIMIT 10");}
				
				while($traks_res = @mysql_fetch_assoc($traks))
								{
									
										echo '<div class="selctd_music"><div>'.$traks_res['music_title'].'</div>';
										echo '<div>'.$traks_res['artist_name'].'</div>';
										echo '<div><a href="#">Remove</a></div></div>';
								}  }
?>