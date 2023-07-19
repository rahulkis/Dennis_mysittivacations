<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$cont_curr_date = date('Y-m-d H:i');
//$base_url = "https://" . $_SERVER['SERVER_NAME']."/";

$get_contests = mysql_query("SELECT * FROM contest");
while($row = mysql_fetch_assoc($get_contests)){
		
		$contest_end_date = $row['contest_end']." ".$row['end_time'];
$contestStart = $row['contest_start']." ".$row['start_time'];
$contestEnd = $row['contest_end']." ".$row['end_time'];
$contestName = $row['contest_title'];


		$c_end_date = date('Y-m-d H:i', strtotime($contest_end_date));
		
		if($cont_curr_date == $c_end_date){
			
			$contest_id = $row['contest_id'];
			
				$select_hosts = mysql_query("SELECT * FROM contestent WHERE contest_id = '".$contest_id."'");
				
				while($c_row = mysql_fetch_assoc($select_hosts)){
					
						$club_email_query = mysql_query("SELECT club_email FROM clubs WHERE id = '".$c_row['user_id']."'");
						$club_email = mysql_fetch_assoc($club_email_query);
					
						$email = mysql_real_escape_string($club_email['club_email']);
						
			$str = "
				<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
				<div width:100%;'>
					<div class='logo' style='float: left; margin-right:20px;'>
						<img src='".$base_url."images/new_portal/images/logo.png' border='0' />
					</div>
					<div style='float:left; margin-top: 50px;'>
						<p style='color: white;'>
						Welcome to the MYSITTI family and be a part of the next social revolution. <br /> 
						Visit <a srtle='color:#fecd07;' href='".$base_url."'>MYSITTI.com</a> where we are <span style='color:#fecd07'>MAKING EVERY CITY YOUR CITY!</span>
						</p>
					</div>
				</div>
				<hr style='float:left; width:100%;'>
				<p style='color: white; float: left;width:100%;'>
				The '".$contestName."' contest has ENDED.  The votes (Shouts) is now close.
				<br/> <br/> 
				Contest Name: <span style='color:#fecd07;'>".$contestName."</span> <br>
				Contest Start : ".date("M j,Y G:i A T",strtotime($contestStart))."<br>
				Contest End : ".date("M j,Y G:i A T",strtotime($contestEnd))."<br>
			 ";
			$str .= "<br/> Thank you, <br>";
			$str .= " MySitti Team </p>
				</div>";

						$message = $str; 
						$to  = $email;
						//$to  = "sumit.manchanda@kindlebit.com";
						
						$subject = "Mysitti Contest Ended";
						$message = $str;
						//$from = "info@mysitti.com";
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
						//$headers .= "From:" . $from;
						
						mail($to,$subject,$message,$headers,"-finfo@mysitti.com");
						//echo "test Mail Sent.";
				}
		}
}
?>