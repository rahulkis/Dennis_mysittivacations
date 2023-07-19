 <?php
 include "Query.Inc.php";
$Obj = new Query($DBName);
      $email = 'testing2.kindlebit@gmail.com';
      $facebookId = $_POST['facebook_id'];
//check if exist
		$emailQuery = mysql_query("SELECT * FROM user WHERE email ='".$email."'");
	echo $countRows = mysql_num_rows($emailQuery);
		if($countRows == 1)
		{
		$get_reslt = mysql_fetch_array($emailQuery);
			
			header('location:index.php?login='.$get_reslt['id']);

				$_SESSION['user_id'] = $get_reslt['id'];
				$_SESSION['user'] = 'user';
			
		}else{

			echo "nope";

		}

  