<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);

if(isset($_POST['forum_id'])){

$get_post_data = mysql_query("SELECT * FROM forum WHERE forum_id = '".$_POST['forum_id']."'");
$get_data = mysql_fetch_assoc($get_post_data);
?>
<form id="CityTalkForm" class="popupform ajaxForm" name="forum" action="" method="post" onSubmit="return validate_forum();" enctype="multipart/form-data">
	<div class="ppost_newdesign">
		<div class="lbl">  
			<label >What&#39;s happening ?</label>
			
		  	<div id="u_0_s" class="_6a _m">
														
				<a style="color:#FFF;" <?php if(!isset($_SESSION['user_id'])){?>href="<?php echo $SiteURL;?>city_talk.php" onclick="openLoginpop($(this).prop('href')); return false;"<?php }else{ ?> onclick="ShowUploadPop();" <?php } ?> id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb">
				<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
				<img src="<?php echo $CloudURL; ?>images/upload_camera.png">
				</i>Add Photo/Video<i class="_2wr"></i>
				</span>
				
				<div class="_3jk">
				<input type="hidden" name="thumbnailPhoto" value="" id="thumbnailPhoto"  />
				<input type="hidden" name="FullPhoto" value="" id="FullPhoto"  />
				<input type="hidden" name="postVideo" value="" id="postVideo"  />
				<input type="hidden" name="postVideoURL" value="" id="postVideoURL"  />
				<!-- <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()"> -->
					<span style="display: none;" id="file_upload_successs"><img src="<?php echo $CloudURL; ?>images/tick_green_small.png"></span>
				</div>
				</a>
				
			</div>

			<textarea id="add_post_text" name="forum" class="txt_box clear_flds"><?php echo htmlspecialchars($get_data['forum']); ?></textarea>
		</div>
	</div>
	
	<div class="post_media">
		<label>Previous Media :</label>
		<?php
		if(!empty($get_data['forum_img']) && !empty($get_data['image_thumb'])){ ?>
			
			<a rel="lightbox" href="<?php echo $get_data['forum_img']; ?>"><img alt="" src="<?php echo $get_data['image_thumb']; ?>"></a>			
			
		<?php	
		}elseif(!empty($get_data['forum_video'])){ ?>
			
			<a href="#dialogx" name="modal">
			<div id="a<?php echo $get_data["forum_id"];?>"></div>
				<script type="text/javascript">
				 jwplayer("a<?php echo $get_data["forum_id"];?>").setup({
					file: "<?php echo $get_data['forum_video'];?>",
					height : 140 ,
					width: 200
					});
				</script>
			</a>		
			
		<?php	
		}else{
			
			echo "<p>No Media Found</p>";
		}
		?>		
	</div>
	
	<div>
		 <div id="" class="pst_buttons">
			<input type="hidden" name = "common_identifier" value="<?php echo $get_data['common_identifier']; ?>">
			<input type="hidden" name="forum_id" value="<?php echo $_POST['forum_id']; ?>">
			<input type="hidden" name="forum_image_full" value="<?php echo $get_data['forum_img']; ?>">
			<input type="hidden" name="forum_image_thumb" value="<?php echo $get_data['image_thumb']; ?>">
			<input id="submit3" type="submit" name="update" value="Update" class="button add_pub_p_post" style=""  />                    
		 </div>
	</div>
</form>

<?php }

if(isset($_POST['delete_forum_id'])){
	
	echo "hello";
	
}

?>