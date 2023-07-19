<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

require 'mailwizz_setup.php';
$endpoint = new MailWizzApi_Endpoint_ListSubscribers(); 

$titleofpage="Survey Questionnaire"; 

////////////////////////
// API call functions //
////////////////////////


function ticket_master_api_call($city, $eventname)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(

	CURLOPT_URL => "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&city=".$city."&keyword=".$eventname."",

	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"Postman-Token: 14f4c548-bf32-463b-ad2b-5b5a244cd13d",
		"X-API-KEY: 1e3ee15f01afef534836990e31447c4038b6ccfd"
		),
	));

	$result = curl_exec($curl);
	$err = curl_error($curl);

	$data = [];
	curl_close($curl);
	return ($err) ? [] : json_decode($result, true);
}

//////////////////
// Checking URL //
//////////////////

// if (sha1($_GET['email']) == $_GET['mail']) {
// 	$email_url = $_GET['email'];
// 	$user_id = $_GET['trigger'];
// }else{
// 	echo "<script type='text/javascript'>alert('Your link is not valid.'); window.location.href = 'https://mysitti.com/'</script>";
// }
// if (empty($_GET['target'])) {
// 	header('Location:index.php');
// } else{
// 	$random_key = $_GET['target'] ;

// 	$sql = "select * from `user` where `random_key` = '".$random_key."'";
// 	$DataArray = $Obj->select($sql) ;
// 	$lastinsertid = $DataArray[0]['random_key'];
// 	$CountDataArray = count($DataArray) ; 
// 	if($CountDataArray <= 0){
// 		die("Your Key is not matching, Please check and retry");
// 	}
// 	else{
// 		$questionQuery = @mysql_query("SELECT * FROM `survey_question` ORDER BY `id` ASC ");
// 		}

// }

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}
else

{
	include('Header.php');	// not login
}
if (!empty($dropdown_city)) {
	$dropdown_city_get = $dropdown_city;
}

// if ($_GET['answer']=='no') {

// 	header('Location:index.php');
// }

//////////////////////
// Form Submittion  //
//////////////////////

if (isset($_POST['submit_question'])) {

	$parks = $_POST['parks/monuments'];
	$resort = $_POST['beach/resort'];
	$bucketLists = $_POST['bucketLists'];
	$majorCities = $_POST['majorCities'];
	$majorCitiesFilter = array_filter($majorCities);
	$music = $_POST['music'];
	$restaurants = $_POST['restaurants'];
	$question_id = $_POST['question_id'];
	$now = date('Y-m-d h:i:s');
	if (!empty($user_id)) {

	$bucketList = implode(',', $bucketLists);
	$musics = implode(',', $music);
	$restaurant = implode(',', $restaurants);
	$majorCity = implode(',', $majorCitiesFilter);
		if (mysql_num_rows(@mysql_query("SELECT * FROM `survey_result` WHERE userid = '".$user_id."'")) == 0) {
			$sql = @mysql_query("INSERT INTO `survey_result` (`userid`,`email`,`bucketLists`,`parks_monuments`,`majorCities`,`beach_resort`,`restaurants`,`music`,`created_at`) VALUES ('$user_id','$email_url','$bucketList','$parks','$majorCity','$resort','$restaurant','$musics','$now') ");
			if($sql === true){
						
				///////////////////////////////////
				// Get suvery_result table data  //
				///////////////////////////////////

				$user_data = mysql_fetch_assoc(@mysql_query("SELECT * FROM `survey_result` WHERE userid = '".$user_id."'"));
				$cities = explode(',', $user_data['majorCities']);
				$musics  = explode(',', $user_data['music']);

				///////////////////////////////
				//Loops to get data from API //
				///////////////////////////////

				for ($i=0; $i < count($cities) ; $i++) { 
					if(!empty($cities[$i])){
						// echo $cities[$i].', <br>';
						for ($j=0; $j < count($musics); $j++) { 
							if (!empty($musics[$j])) {
								// echo $musics[$j].', <br>';
								$events = ticket_master_api_call(preg_replace('/\s+/', '%20', $cities[$i]), $musics[$j]);
								$events = (count($events) > 0 && isset($events['_embedded']['events']) ) ? $events['_embedded']['events'] : [];

								if (!empty($events['0']['name'])) {
									$music_imageUrl[] = $events['0']['images']['3']['url'];

									$dateTime = $events['0']['dates']['start']['dateTime'];

									$music_date[] = date("j/F/Y g:i a", strtotime($dateTime));

									$music_event[] = $events['0']['name'];

									$music_eventurl[] = $events['0']['url'];
								}
							}
						}
					}
				}

				for ($i=0; $i < count($cities) ; $i++) { 
					if(!empty($cities[$i])){
						// echo $cities[$i].', <br>';
						$events = ticket_master_api_call(preg_replace('/\s+/', '%20', $cities[$i]), 'theater');
						$events = (count($events) > 0 && isset($events['_embedded']['events']) ) ? $events['_embedded']['events'] : [];

						if (!empty($events['0']['name'])) {
							$theater_imageUrl[] = $events['0']['images']['3']['url'];

							$dateTime = $events['0']['dates']['start']['dateTime'];

							$theater_date[] = date("j/F/Y g:i a", strtotime($dateTime));

							$theater_event[] = $events['0']['name'];

							$theater_eventurl[] = $events['0']['url'];
						}
					}
				}

				// echo "<pre>";
				// print_r($imageUrl);
				// print_r($date);
				// print_r($event);
				// print_r($eventurl);
				// echo "</pre>";
				// die;
				
				$music_response = $endpoint->emailSearchAllLists($email_url);
				$music_response = $endpoint->create('ld178qjh82f5f', array(
					'EMAIL'     => $email_url, // the confirmation email will be sent!!! Use valid email address
					'IMGLINK1'  => $music_imageUrl['0'],
					'EVENTNAME1'=> $music_event['0'],
					'EVENTDATE1'=> $music_date['0'],
					'EVENTLINK1'=> $music_eventurl['0'],
					'IMGLINK2'  => $music_imageUrl['1'],
					'EVENTNAME2'=> $music_event['1'],
					'EVENTDATE2'=> $music_date['1'],
					'EVENTLINK2'=> $music_eventurl['1'],
					'IMGLINK3'  => $music_imageUrl['2'],
					'EVENTNAME3'=> $music_event['2'],
					'EVENTDATE3'=> $music_date['2'],
					'EVENTLINK3'=> $music_eventurl['2'],
					'IMGLINK4'  => $music_imageUrl['3'],
					'EVENTNAME4'=> $music_event['3'],
					'EVENTDATE4'=> $music_date['3'],
					'EVENTLINK4'=> $music_eventurl['3']
				));
				$api_message = $music_response->body->toArray();
				if ($api_message['status'] == 'error') {
					echo "<script type='text/javascript'>alert('Thank you for valueable time. Subscriber you are already exists in our music list'); window.location.href = 'https://mysitti.com/'</script>";
				}

				$theater_response = $endpoint->emailSearchAllLists($email_url);
				$theater_response = $endpoint->create('ag80504ymw04f', array(
					'EMAIL'     => $email_url, // the confirmation email will be sent!!! Use valid email address
					'IMGLINK1'  => $theater_imageUrl['0'],
					'EVENTNAME1'=> $theater_event['0'],
					'EVENTDATE1'=> $theater_date['0'],
					'EVENTLINK1'=> $theater_eventurl['0'],
					'IMGLINK2'  => $theater_imageUrl['1'],
					'EVENTNAME2'=> $theater_event['1'],
					'EVENTDATE2'=> $theater_date['1'],
					'EVENTLINK2'=> $theater_eventurl['1'],
					'IMGLINK3'  => $theater_imageUrl['2'],
					'EVENTNAME3'=> $theater_event['2'],
					'EVENTDATE3'=> $theater_date['2'],
					'EVENTLINK3'=> $theater_eventurl['2'],
					'IMGLINK4'  => $theater_imageUrl['3'],
					'EVENTNAME4'=> $theater_event['3'],
					'EVENTDATE4'=> $theater_date['3'],
					'EVENTLINK4'=> $theater_eventurl['3']
				));
				$api_message = $theater_response->body->toArray();
				if ($api_message['status'] == 'error') {
					echo "<script type='text/javascript'>alert('Thank you for valueable time. Subscriber you are already exists in our art and theater list'); window.location.href = 'https://mysitti.com/'</script>";
				}

				echo "<script type='text/javascript'>alert('Thank you for valueable time. We will use this information to provide better experience with us.Do not Forget to check your mail inbox.'); window.location.href = 'https://mysitti.com/'</script>";
			}else{
			    echo "ERROR: Could not able to execute sql. ";
			}
		}else{
			echo "<script type='text/javascript'>alert('User already give this survey.'); window.location.href = 'https://mysitti.com/'</script>";
		}	
	}else{
		echo "<script type='text/javascript'>alert('Please login.'); window.location.href = 'https://mysitti.com/'</script>";
	}
}
?>

<div class="container">
	<div class="row survey_form">
		<form  method="post">
			<?php $i = 1;
				while ( $getQuestions = mysql_fetch_assoc($questionQuery)){ 
					if ($getQuestions['input_type'] == 'checkbox' ) { ?>
		 				<div class="form-group">
							<input type="hidden" name="question_id[]" value="<?php echo $getQuestions['id'] ?>">

							<label class="control-label col-sm-12 "> <?php echo $i++."  ." ; echo $getQuestions['question']; ?>  </label>
							<?php foreach (explode(',', $getQuestions['options']) as $option) { ?>
								<label class="checkbox-inline "><input type="checkbox" class="form-group" name="<?php echo $getQuestions['type'] ?>[]" value="<?php echo $option ?>"><?php echo $option ?></label>
							<?php } ?>
							<?php if ($getQuestions['other_option'] == 1) { ?>
									<br><br><label class="other_city_wish">Other city you would to visit: </label><input class="input_city_wish" type="text" name="<?php echo $getQuestions['type'] ?>[]" placeholder="Enter the name of your wish">
							<?php } ?>
						</div>
						<?php } elseif ($getQuestions['input_type'] == 'radio' ) { ?>
							<div class="form-group">
								<input type="hidden" name="question_id" value="<?php echo $getQuestions['id'] ?>">

								<label class="control-label col-sm-12 "> <?php echo $i++,"  ." ; echo $getQuestions['question'] ; ?>  </label>
								<?php foreach (explode(',', $getQuestions['options']) as $option) { ?>
									<label class="radio-inline "><input type="radio" name="<?php echo $getQuestions['type'] ?>" value="<?php echo $option ?>" checked required ><?php echo $option ?></label>
								<?php } ?>
							</div>
						<?php } ?>

			<?php } ?>
			<button  name="submit_question">Submit Survey</button>
		</form>
		
	</div>
</div>
<?php
	include('LandingPageFooter.php');
?>