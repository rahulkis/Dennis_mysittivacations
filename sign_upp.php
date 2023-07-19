<?

include("Query.Inc.php");
$Obj = new Query($DBName) ;
if(isset($_SESSION['user_id']))
{
$Obj->Redirect("index.php");
}
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="duplicate")
	{
	$message="The email address is already taken. Please choose another one.";
	}
	if($para=="Captchaerror")
	{
	$message=" Please Enter Valid Captcha Code";
	}
	if($para=="failed")
	{
	$message=" Please Fill Proper Information";
	}
}
include('header_start.php');
?>
<?php
	$adv_sql = mysql_query("select * from `advertise` where `status` = '1'");
	$advArray =mysql_fetch_array($adv_sql) ; 
	$adv_img= substr($advArray['adv_img'],6);
?>
<?php include('header.php') ?>
  <!--<script type="text/javascript" src="js/jquery-1.11.0-beta2.js" language="javascript"></script>
<script src="js/jquery.hashchange.min.js" type="text/javascript"></script>-->
  <script src="js/jquery.easytabs.min.js" type="text/javascript"></script>

  <script type="text/javascript">
   $(document).ready( function() {
     $('#tab-container').easytabs();
    });
   
  </script>
  
 
  <!-- end for toggle menu -->

<?PHP 
/***************************************************************************/
    FUNCTION DateSelector($useDate=0) 
    { 
			$months = array ('January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 
			'December');
			$days = range (1, 31);
			$years = range (1951, DATE("Y"));
			
					echo ' <span name="month" class="month"><div class="styled-select"><select>';
				echo '<option value="Select"> Month</option>\n';
	            for ($month = 0; $month <= 12; $month++) 
				{
					echo '<option value="'.$month.'">'.$months[$month].'</option>\n';
				}
			echo ' </select></div></span> ';
			
			echo '  <span name="date" class="date"><div class="styled-select"><select>';
			echo '<option value="Select"> Date</option>\n';
			foreach ($days as $value) {
					echo '<option value="'.$value.'">'.$value.'</option>\n';
			}
			echo ' </select></div></span> ';
			
			echo ' <span name="year" class="year"><div class="styled-select"><select>';
			echo '<option value="Select"> Year</option>\n';
			foreach ($years as $value) {
					echo '<option value="'.$value.'">'.$value.'</option>\n';
			}  
			echo ' </select></div></span> ';
			
			
			
    
    } 
?> 
<!-- slider start -->
<section id="signup">
    <div class="logo"><a href="#"> <img src="images/logo.png" alt="logo"></a> </div>
    <h1 class="welcome">Registration  user</h1>
    <div class="clear"></div>
    <div class="content logincontainer">
    <div class="loginbox">
        <div class="loginheader"> <img src="images/user1.png" alt="">
        <h1>Register Account</h1>
      </div>
        <div class="logininner">
        <div id="tab-container" class='tab-container'>
            <ul class='etabs'>
            <li class='tab'><a href="#tabs1-html">Standard User</a></li>
            <li class='tab'><a href="#tabs1-js">Host</a></li>
          </ul>
            <div class='panel-container'>
			<?php
			if($message!="")
			{
			?>
			<div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
			<?php
			}
			?>
            <div id="tabs1-html">
				 
               <form name="signupd" id="signupd" class="tab_standerd" method="post"   action="main/signup.php" >
                <div class="form_left">
                    <label>
                    <input type="text" name="fname" id="fname"  placeholder="Name of User" required >
                  </label>
                    <label>
                    <input type="text" name="email" onblur="ChkUserId(this.value,'user');" placeholder="Email Address" required >
                  </label>
                    <label>
                    <input type="password" name="password" id="password" placeholder="Password" required >
                  </label>
                    <label>
                    <input type="password" name="cpassword" placeholder="Confirm Password" required >
                  </label>
                    <label>Date of Birth:</label>
                  <div class="time">
					  <?PHP DateSelector(); ?>                   
                  </div>
                    <label>
                    <input type="text" placeholder="Phone"  name="phone" maxlength="15" required >
                  </label>
                       <label>
                    <div class="styled-select">
							<?php 
							$countrysql="select country_id,name from country where country_id IN(223,38)";
							$country_list = mysql_query($countrysql);

							?>
							<select name="country" id="country" onChange="showState(this.value,'state_id');">
							<option value="">Country</option>
							<?php 
							while($row = mysql_fetch_array($country_list))
							{
							if($row["country_id"] == 223)
							{
							?>
							<option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
							<?php
							}
							else
							{
							?>

							<option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
							<?php
							}
							}
							?>
							</select>
                  </div>
                    </label>
                  </div>
                <div class="form_right">
                    <label>
                    <div class="styled-select">
						<? $state_sql="select zone_id,name from zone where country_id IN(223)";
						$state_list = mysql_query($state_sql); ?>
						<select name="state" id="state_id"  onchange="getcity(this.value);">

						<option value="">State</option>
						<?php 
						while($row_s = mysql_fetch_array($state_list))
						{ ?>
						<option  value="<?php echo $row_s["zone_id"]; ?>" ><?php echo $row_s["name"]; ?></option>
						<? }
						?>
						</select>
                  </div>
                    </label>
               <div class="city_code">
                 <span class="city">
                       <div class="styled-select">
						   <div id="cities">
						    <?php 
							$citylist="SELECT city_name, city_id FROM `capital_city` 
							LEFT JOIN zone on(zone.zone_id=capital_city.state_id)
							WHERE country_id='223' ORDER BY `city_name` ASC";
							$citylist_all = @mysql_query($citylist);

							?>
							<select name="city_name" id="city_name" onchange="other_city_show(this.value);" >
							<option value="">City</option>
							<option value="other">Enter Other City</option>
							<?php 
							while($row1 = mysql_fetch_array($citylist_all))
							{
							?>
							<option value="<?php echo $row1["city_id"]; ?>" ><?php echo $row1["city_name"]; ?></option>
							<?php
							}
							?>
							</select></div>
                      </div>
                    </span> <span class="code">
                       <input type="text" name="zipcode" id="zipcode"   placeholder="Zip Code" required >
                     </span>
                </div> 
                 
               
                  <div id="other_c" style="display:none;">
                 <input type="text" name="other_city" id="other_city" placeholder="Enter Your City"    />
                  </div>
                  
                   <label>Enter the code:</label>
                  <div class="captcha">
                  <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' >&nbsp;&nbsp;&nbsp;&nbsp;
                 <a href='javascript: refreshCaptcha();'>  <img src="images/refersh.png"></a>
                  </div>
                  
                  <label>
                    <input id="letters_code" name="letters_code" type="text"><br>
                 </label>
                  <p> 
						<span>
                   <input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" style="margin:0 10px 0 0;" />I have read and agree to the
              <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a><span class="error">*</span>
                      
                      </span> </p>
                    <input type="submit" name="submit" value="Continue">
                  </div>
              </form>
              </div>
            <div id="tabs1-js"> <code>
				
               <form name="signupes" id="signupes" class="tab_standerd"  method="post"  action="main/signup_club.php">
                <div class="form_left">
                    <label>
                    <input type="text" name="name_club" id="name_club" placeholder="Name of HOST" required >
                  </label>
                    <label>
                    <input type="text" name="club_email" id="club_email" onblur="ChkUserId(this.value,'host');" placeholder="Email Address" required >
                  </label>
                    <label>
                    <input type="password" name="password" id="password" placeholder="Password" required >
                  </label>
                    <label>
                    <input type="password" name="cpassword" id="cpassword"  placeholder="Confirm Password" required >
                  </label>
                    <label>Date of Birth:</label>
                  <div class="time">
					  <?PHP DateSelector(); ?>                   
                  </div>
                    <label>
                    <input type="text" name="phone" id="phone"  maxlength="15" placeholder="Phone" name="phone" maxlength="15" required >
                  </label>
                    <label>
                    <div class="styled-select">
						 <?php 
							 $countrysql="select country_id,name from country where country_id IN(223,38)";
							 $country_list = mysql_query($countrysql);
							 
							 ?>
								<select name="country" id="country" onChange="showState(this.value,'state_id_host');">
								<option value="">Country</option>
								<?php 
								while($row = mysql_fetch_array($country_list))
								{
								if($row["country_id"] == 223)
								{
								?>
								<option selected="selected" value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
								<?php
								}
								else
								{
								?>

								<option value="<?php echo $row["country_id"]; ?>" ><?php echo $row["name"]; ?></option>
								<?php
								}
								}
								?>
								</select>                 
								 </div>
                    </label>
                </div>
                <div class="form_right">
                    <label>
                    <div class="styled-select">
						 
                   <? $state_sql="select zone_id,name from zone where country_id IN(223)";
							$state_list = mysql_query($state_sql); ?>
							<select name="state" id="state_id_host"  onchange="getcity_host(this.value);">

							<option value="">State</option>
							<?php 
							while($row_s = mysql_fetch_array($state_list))
							{ ?>
							<option  value="<?php echo $row_s["zone_id"]; ?>" ><?php echo $row_s["name"]; ?></option>
							<? }
							?>
							</select>
                  </div>   
                    </label>
               <div class="city_code">
                 <span class="city">
                       <div class="styled-select">
						   <div id="cities_host">
							<?php 
							$citylist="SELECT city_name, city_id FROM `capital_city` 
							LEFT JOIN zone on(zone.zone_id=capital_city.state_id)
							WHERE country_id='223' ORDER BY `city_name` ASC";
							$citylist_all = @mysql_query($citylist);

							?>
							<select name="city_name" id="city_name_host" onchange="other_city_show_host(this.value);" >
							<option value="" >City</option>
							<option value="other">Enter Other City</option>
							<?php 
							while($row1 = mysql_fetch_array($citylist_all))
							{
							?>
							<option value="<?php echo $row1["city_id"]; ?>" ><?php echo $row1["city_name"]; ?></option>
							<?php
							}
							?>
							</select>
                      </div> </div>
                    </span> <span class="code">
                       <input type="text" placeholder="Zip Code" name="zipcode" required >
                     </span>
                </div> 
                 <div id="other_c_host" style="display:none;">
                 <input type="text" name="other_city" id="other_city" placeholder="Enter Your City"    />
                  </div>
                  <label>
                  <label>Enter the code:</label>
                  <div class="captcha">
                  <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' >&nbsp;&nbsp;&nbsp;&nbsp;
                   <a href='javascript: refreshCaptcha();'>  <img src="images/refersh.png"></a>
                  </div>
                  
                  <label>
                    <input id="letters_code" name="letters_code" type="text"><br>
                 </label>
                  <p> <span>

                      <input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" style="margin:0 10px 0 0;" />I have read and agree to the
              <a href="javascript:vois(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a><span class="error">*</span></li>
                      </span> </p>
                    <input type="submit" name="submit" value="Continue">
                </div>
              </form>
              </code>
                
              </div>
          </div>
          </div>
      </div>
      </div>
  </div>
  </section>


<?php include('footer.php') ?>
