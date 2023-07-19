<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Enquiry Sent.";
	}
}

$titleofpage="Contact Us";
 include('headhost.php');
include('header.php'); 

 $sql = "select * from `pages` where page_name like '%contact us%'";
 $policyArray = $Obj->select($sql) ; 
 $contact_us=$policyArray[0]['page_data'];


if($_POST['submit'])
{ 
  $today = date("Y-m-d h:i:s");
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email=$_POST['email'];
  $fname=$_POST['fname'];
  $enquiry=$_POST['enquiry'];
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
					$Obj->Redirect("contact_us.php?msg=success");
					die;
				}
										
  }
 
 ?>
  <style>
 .comman_main {
  margin-top:70px;
}
 </style>
<script src='js/jquery.validate.js'></script>
<script src="js/register.js" type="text/javascript"></script>

   <div id="wrapper" class="home_wrapper">
             
             <div class="comman_main">
		
               
                     
                   <div class="content1">
                   <div id="title" class="botmbordr">Contact Us</div>
                     <?php
			if($message!="")
			{
			?>
		       <div style="display: block;" id="successmessage" class="message" >
			   <?php echo $message; ?> 
               </div> 
			<?php
		      }
			?>
                   		<div class="box7">
                          <form name="contact_us" id="contact_usFrom"  method="post" onsubmit="return validatecontact_us();">
                           <ul>
                            
                             <li><input required name="fname" id="fname" type="text" class="txt_box" placeholder="First Name"  /></li>
                           </ul>
                           <ul>
                            
                             <li><input required type="text" name="lname" class="txt_box" placeholder="Last Name" /></li>
                           </ul>
                           <ul>
                             
                             <li><input required type="email" name="email" class="txt_box" onblur="ChkUserId(this.value);" placeholder="Email" /></li>
                           </ul>
                            <ul>
                            
                             <li><textarea required name="enquiry" class="txt_box" style="height:100px;" placeholder="Enquiry"></textarea></li>
                           </ul>
                           <ul>
                             <li><input type="submit" name="submit" value="Submit" class="button"/></li>
                           </ul>
                          </form>
                       	</div>
                       	<div class="content_cotact_txt" style="color: #fff;">
                         <address>
                            <table>
                              <tr>
                                <td><img src="images/new_portal/images/home.png" alt=""></td>
                                <td>Memphis, TN 38111-9997<br />
                                  P.O.Box 11224<br />
                                  Phone: (866) 494-2026</td>
                              </tr>
                              
                                <td><img src="images/new_portal/images/mail.png" alt=""></td>
								<?php
								 $fetch_c_email = mysql_query("SELECT * FROM admin_contact_emails WHERE type = 'contact_email'");
									 $f_count_e = mysql_num_rows($fetch_c_email);
									 
									 if($f_count_e > 0){
										 
										 $get_e_value = mysql_fetch_assoc($fetch_c_email);
										 
										 $e_value = $get_e_value['email'];
										 
										 }else{
										  
										  $e_value = "mysitti@mysittidev.com";
										  
										 }								
								?>
								
                                <td><a style="color: rgb(254, 205, 7);" href="mailto:<?php echo $e_value; ?>"><?php echo $e_value; ?></a></td>
                              </tr>
                              
                                <td><img src="images/new_portal/images/web.png" alt=""></td>
                                <td>mysittidev.com</td>
                              </tr>
                            </table>
                          </address>
                       </div>
                   </div>
               </div>
           </div>
       
    <?php include('footer.php') ?>


