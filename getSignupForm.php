<div id="2" class="tab_contents tab_contents_active"  style="display:block">
	<form action="signup_club.php" method="post" class="tab_standerd " id="signupes" name="signupes" novalidate="novalidate" >
		<label class="">
			<!-- <span class="redC">*</span> -->
			<div id="sources" class="styled-select">
			<select name="host_category" required>
				<option value="">--Select Category--</option>
				<?php
				$cat_query = mysql_query("SELECT * FROM club_category WHERE parrent_id = 0 AND id IN ('91', '92', '101', '96', '97', '1', '102','103','104') ORDER BY name ASC");
				while($get_cats = mysql_fetch_assoc($cat_query)){ ?>
					
					<option value = "<?php echo $get_cats['id'] ?>"><?php echo $get_cats['name'] ?></option>
					
				<?php } ?>
			</select>
			</div>
		</label>
		<label class="package_plan">
			<!-- <span class="redC">*</span> -->
			<input type="text" readonly="readonly"  name="host_plan" value="Basic">
		</label>
		<label>
			<!-- <span class="redC">*</span> -->
			<input type="text" required="" placeholder="Name of HOST" id="name_club" name="name_club" onchange="return RestrictSpaceSpecial(this.value);">
				<!--<input type="text" required="" placeholder="Name of HOST" id="name_club" name="name_club" onkeypress="return RestrictSpaceSpecial(event);">-->
		</label>
	
		<label> 
			<!-- <span class="redC">*</span> -->
			<input type="text" required="" placeholder="Email Address" onblur="ChkUserId(this.value,'user');" name="club_email">
		</label>
		<label> 
			<!-- <span class="redC">*</span> -->
			<input type="password" required="" placeholder="Password" id="password2" name="password">
		</label>
		<label>
			<!-- <span class="redC">*</span> -->
			<input type="password" required="" placeholder="Confirm Password" name="cpassword">
		</label>


		<label> 
			<!-- <span class="redC">*</span> -->
			<input type="text" required="" placeholder="Zip Code" id="zipcode" maxlength="8" name="zipcode">
		</label>
		<div class="captcha">
			<div class="QapTcha" id="host">
			</div>
			<input id="check_bot_host" type="hidden" name="check_bot_host" value="0">
			<input type="hidden" value="host" class="check_signup_form">
		</div>
		
	   	<label class="termsn"> 
				<input type="checkbox" style="margin:0 5px 0 0;" value="1" id="acknowledgement" name="acknowledgement">
				I have read and agree to the <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:vois(0)">Privacy Policy</a><span class="error">*</span> 
		</label>
		
		<div class="login_sbmit">
			<input type="hidden" value="<?php echo $code;?>" name="captchcodehost" id="captchacodehost">
			<input type="hidden" value="free" name="plantype">
			<input type="hidden" value="1" name="planid">
			<input type="submit" value="Sign Up" name="submit">
		</div>
	</form>
</div>