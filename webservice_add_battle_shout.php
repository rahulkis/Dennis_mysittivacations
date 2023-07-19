<?php

include("../Query.Inc.php") ;
$Obj = new Query($DBName) ;
header('Content-type: application/json');

// contest_id , from_user , to_user , from_user_type ,to_user_type , live_battle_shout

if(isset($_POST['live_battle_shout'])){

	$current_shout_date = date('Y-m-d');
	$check_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_POST['from_user']."' AND to_user = '".$_POST['to_user']."' AND shouted_date = '".$current_shout_date."'");
	
	$check_shout = mysql_num_rows($check_shout);
	
		if($check_shout < 1){
			
			mysql_query("INSERT INTO live_battle_shouts (`contest_id`, `from_user`, `from_user_type`, `to_user`, `to_user_type`, `shouted_date`) VALUES ('".$_POST['contest_id']."', '".$_POST['from_user']."', '".$_POST['from_user_type']."', '".$_POST['to_user']."', '".$_POST['to_user_type']."', '".$current_shout_date."' )");
			
		}
                
        
						 $result['code'] = 300;
						$result['data'] = 'Shout Added';						
						echo json_encode($result);
	 
          }
else{
						$result['code'] = 301;
						$result['data'] = 'error';						
						echo json_encode($result);	
	
	}	 
	 
?>