<?php
header('Content-Type: application/json');

class Auth extends MY_Controller {
	function __construct() {
		parent::__construct();
	}
	
    //User sign up
    public function userSignup(){

       $jsondata = file_get_contents("php://input");
       $data = json_decode($jsondata);
       $email = $data->email;
       $password = $data->password;

       $country = (string) @$data->country;
       $state   = (string) @$data->state;
       $city    = (string) @$data->city;

       $md5_password = md5($password);
       $plantype = $data->plantype;
       $profileType = $data->profileType;
       $parts = explode("@", $email);
       $profilename = $parts[0];
       $checkEamail = $this->auth_model->checkEmailAvailable($email);  
       if($checkEamail > 0){
       	$code = '403';
		$message = EMAIL_ALREADY_EXISTS;
		$this->error($code, $message);
       }else{
       
        $userArraydata = array('email' => $email, 'password' => $password, 'password_md5' => $md5_password, 'plantype'=>$plantype, 'profileType' => $profileType, 'profilename'=>$profilename, 'country' => $country, 'state' => $state, 'city' => $city);
        $insert = $this->auth_model->insertUserData($userArraydata);
        $code = '200';
		$message = SIGNUP_SUCCESS;
		$this->success($code, $message, $insert[0]); 
       } 
    }

	public function facebookLogin()
 	{
     $email = $_POST['email'];
     $facebookId = $_POST['facebook_id'];
     $name = trim($_POST['name']);
     $user_address = $_POST['user_address'];
     $country = $_POST['country'];
     $state = $_POST['state'];
     $city = $_POST['city'];
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
  		if (!empty($email)) {
  			$this->load->model('auth_model');
  			$check_avail = $this->auth_model->checkEmailAvailable($email);
  			//check if exist
  			if ($check_avail == true){
          $get_id = $this->auth_model->getUserId($email);
          $userFbArray = array('first_name' => $first_name, 'last_name' => $last_name, 'facebook_id' => $facebookId);
          $fbUpdate = $this->auth_model->updateFbData($userFbArray, $get_id);
          $message = 'Success fully logged in.';
          $obj = array('SUCCESS'=> '200', 'Message' => $message, 'data' => $this->auth_model->find($get_id));
          echo json_encode($obj);
  			} else {
          $password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
          $md5Password = md5($password);
          $profilename = strtok($email, '@');
          $userFbArray = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => $password, 'password_md5' => $md5Password,'user_address' => $user_address, 'country' => $country, 'state' => $state,  'city' => $city, 'profilename'=>$profilename,'facebook_id' => $facebookId, 'status'=> '1');
          $insert_id = $this->auth_model->insertFbData($userFbArray);
          $message = 'Success fully registered.';
          $obj = array('SUCCESS'=> '200', 'Message' => $message, 'data' => $this->auth_model->find($insert_id));
          echo json_encode($obj);
  			}
  		} else {
  			$message = 'BAD_REQUEST';
  			$this->error('403', $message);
  		}		
  	}


  public function googleLogin()
  {
	
  	$email = $_POST['email'];
     $google_id = $_POST['google_id'];
     $name = trim($_POST['name']);
     $user_address = $_POST['user_address'];
     $country = $_POST['country'];
     $state = $_POST['state'];
     $city = $_POST['city'];
     $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
		if (!empty($email)) {
			$this->load->model('auth_model');
			$check_avail = $this->auth_model->checkEmailAvailable($email);
			//check if exist
			if ($check_avail == true){
			    $get_id = $this->auth_model->getUserId($email);

			    $userFbArray = array('first_name' => $first_name, 'last_name' => $last_name, 'google_id' => $google_id);
			    $fbUpdate = $this->auth_model->updateFbData($userFbArray,$get_id);
			 	$message = 'Success fully logged in.';
          		  $obj = array('SUCCESS'=> '200', 'Message' => $message, 'data' => $this->auth_model->find($get_id));
         		 echo json_encode($obj);
			}   
			else{
				$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
			 	$md5Password = md5($password);
				$profilename = strtok($email, '@');
			    $userFbArray = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => $password, 'password_md5' => $md5Password, 'user_address' => $user_address, 'country' => $country, 'state' => $state,  'city' => $city, 'profilename'=>$profilename,'google_id' => $google_id, 'status'=> '1');
		        $insert_id = $this->auth_model->insertFbData($userFbArray);
			    $message = 'Success fully registered.';
          		  $obj = array('SUCCESS'=> '200', 'Message' => $message, 'data' => $this->auth_model->find($insert_id));
          echo json_encode($obj);
			}
		}
		else{
			$message = 'BAD_REQUEST';
  			$this->error('403', $message);
		}
		
  }

	//User sign in
	public function userLogin() {
       
       $jsondata = file_get_contents("php://input");
       $loginData = json_decode($jsondata);
       $email = $loginData->email;
       $password = $loginData->password;
 
		if (!empty($email) && !empty($password)) {
			$check_email_available = $this->auth_model->checkEmailAbl($email);
			if (count($check_email_available) > 0) {
				$checkPassword = $this->auth_model->checkPassword($email, $password);

				if (count($checkPassword) > 0) {
					$user_id = $this->auth_model->getUserId($email);

					//$this->auth_model->updateToken($device_type, $device_token, $user_id);
					$getData = $this->auth_model->getUserData($user_id);
					//$image_url = $this->auth_model->getImageUrl('users', $user_id);
					$data = $getData[0];
					$code = '200';
					$message = LOGIN_SUCCESS;
					$this->success($code, $message, $data);
				} else {
					$code = '300';
					$message = LOGIN_FAIL;
					$this->error($code, $message);
				}
			} else {
				$code = '203';
				$message = EMAIL_NOT_EXISTS;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

	//Reset User Password
	public function resetUserPassword(){
      
      $jsondata = file_get_contents("php://input");
      $changePassworData = json_decode($jsondata);
      $userId = $changePassworData->user_id;
      $old_password = $changePassworData->old_password;
      $new_password = $changePassworData->new_password;

      $check_password = $this->db->get_where('user', ['id'=>$userId, 'password'=>$old_password])->result();
     
      if (count($check_password) > 0) {
      	  
           $resetPassword = $this->auth_model->resetUSerPass($userId, $new_password);
           if($resetPassword >0){
           	 $code = '200';
			$message = 'Password Reset Successfully';
			$this->success($code, $message);
           }
 
      }else{
      		$code = '400' ;
			$message = BAD_REQUEST;
			$this->error($code, $message);
      }
	}

	//Get Drop down Country.
	public function getCountry(){
      $get_country =$this->auth_model->getCountry();

      $response = [];
      foreach ($get_country as $key => $value) {
      	$response[$key]['country_id'] = $value['country_id'];
      	$response[$key]['name'] = $value['name'];
      }

      if(count($get_country) > 0){
      	$code = '200';
      	$message = 'Get Country';
      	$this->success($code, $message, $response, 'CountryList');
      }else{

      	$code = '400' ;
		$message = BAD_REQUEST;
		$this->error($code, $message);
      } 
    
}

	 //Get Drop down state
	 public function getState(){
	     $jsondata = file_get_contents("php://input");
	     $cid = json_decode($jsondata);
	     $country_id = $cid->country_id;
	     $getstate = $this->auth_model->getState($country_id);
	     if(count($getstate) > 0){
		    $code = '200';
	      	$message = 'Get State';
	      	$this->success($code, $message, $getstate, 'StateList');
	     }else{
     		$code = '400' ;
			$message = BAD_REQUEST;
			$this->error($code, $message);
     }

	}

	//Get drop down City
	public function getCity(){
	     $jsondata = file_get_contents("php://input");
	     $city = json_decode($jsondata);
	     $city_id = $city->zone_id;
	     $getCityList = $this->auth_model->getCityLists($city_id);
	     if(count($getCityList)> 0){
	     	 $code = '200';
	      	$message = 'Get City';
	      	$this->success($code, $message, $getCityList, 'CityList');
	     }else{
	     	$code = '400' ;
			$message = BAD_REQUEST;
			$this->error($code, $message);
	     }

	}

	//Update Profile
	public function updateProfile() {
       
		$user_id = $this->input->post('user_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name'); 
		$phone_number = $this->input->post('phone');
		$address = $this->input->post('user_address');
		$country = $this->input->post('country');
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$zipCode = $this->input->post('zipcode');
		
		if (!empty($user_id)) {
			$update_info = $this->auth_model->editProfile($user_id);
		
			$getData = $this->auth_model->getUserData($user_id);
			$image_url = $this->auth_model->getImageUrl('user', $user_id);
			if ($update_info == "TRUE") {
				$code = '200';
				$message = UPDATE_SUCCESS;
				$getData[0]['image_url'] = $image_url;
				$data = $getData[0];
				$this->success($code, $message, $data);
			} else {
				$code = '201';
				$message = UPDATE_ERROR;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

	//Get user profile
	public function getProfile() {
		$jsondata = file_get_contents("php://input");
        $user_id = json_decode($jsondata);
		$user_id = $user_id->user_id;
		// echo "<pre>";
		// print_r($user_id);
		// echo "</pre>";
		// die;
		if (!empty($user_id)) {
			$getData = $this->auth_model->getUserData($user_id);

			 $image_url = $this->auth_model->getImageUrl('user', $user_id);
			
			if (count($getData) > 0) {
				$code = '200';
				$message = REC_FOUND;
				$getData[0]['image_url'] = $image_url;
				$data = $getData[0];
				$this->success($code, $message, $data);
			} else {
				$code = '300';
				$message = REC_NOT_FOUND;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

	//Get Resturant Category
	public function getRestaurantCategories(){

	  $getResCategory = $this->auth_model->getResCatData();	
	 
		  if(count($getResCategory) > 0){
	      	$code = '200';
	      	$message = REC_FOUND;
	      	$this->success($code, $message, $getResCategory, 'ResturantList');
	      }else{

	      	$code = '400' ;
			$message = BAD_REQUEST;
			$this->error($code, $message);
	      } 
	  	
	}

	//Get Music Category
	public function getMusicCategories(){

	  	$categories = $this->auth_model->getMusCatData();

	 	$response = [];

	 	foreach ($categories as $key => $category) {
	 		$response[$key]['music_type'] =  $category['music_type'];
	 		$response[$key]['music_slug'] =  $category['music_slug'];
	 		$response[$key]['music_image'] =  base_url() . '/images/' . $category['music_image'];
	 		$response[$key]['music_link'] =  base_url() . $category['music_link'];
	 	}

		  if(count($response) > 0){
	      	$code = '200';
	      	$message = REC_FOUND;
	      	$this->success($code, $message, $response, 'MusicList');
	      }else{

	      	$code = '400' ;
			$message = BAD_REQUEST;
			$this->error($code, $message);
	      } 
	  	
	}


	//Forget Password
	public function ForgetPassword()
	{
		$jsondata = file_get_contents("php://input");
        $email = json_decode($jsondata);
		$email = $email->email;
		if (!empty($email)) {
			$check_avail = $this->auth_model->checkEmailAvailable($email);
			if (count($check_avail) > 0) {
				$user_details = $this->auth_model->getUserDetails($email);


				$data = [
						'email' => $user_details[0]->email,
						'password' => $user_details[0]->password
						];
				$user = new stdClass;
				$sent_mail = $this->mailer->send('forget_emails', compact('data')) // emails templates are inside /views/emails/
	                    ->to($email)
	                    ->subject('Forget Password Request')
                    	->deliver();
				
				if ($sent_mail) {
					$code = '200';
					$message = PASS_SUCCESS;
					$this->success($code, $message);
				} else {
					$code = '201';
					$message = EMAIL_NOT_SENT;
					$this->error($code, $message);
				}
			} else {
				$code = '300';
				$message = EMAIL_NOT_EXISTS;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

	public function test(){
		echo "<pre>";
		print_r(FCPATH);
		echo "</pre>";
		die;
	}


    // Old Api
	//Update device type and token
	public function updateToken() {
		$user_id = $this->input->post('user_id');
		$device_type = $this->input->post('device_type');
		$device_token = $this->input->post('device_token');
		if (!empty($user_id) && !empty($device_type) && !empty($device_token)) {
			$afected_row = $this->auth_model->updateToken($device_type, $device_token, $user_id);
			if (count($afected_row) > 0) {
				$code = '200';
				$message = UPDATE_SUCCESS;
				$this->success($code, $message);
			} else {
				$code = '201';
				$message = UPDATE_ERROR;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

	
	//forgot password
	public function forgotPassword() {
		$email = $this->input->post('email');
		if (!empty($email)) {
			$check_avail = $this->auth_model->checkEmailAvailable($email);
			if (count($check_avail) > 0) {
				$user_id = $this->auth_model->getUserId($email);
				$name = $this->auth_model->getUserName($user_id);

				$random = random_string('alnum', 10);
				$token = sha1($random);
				$data = array('remember_token' => $token);

				$rememberToken = $this->auth_model->updateRememberToken($email, $data);

				$subject = "Reset password link from Handbook App";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: admin@gmail.com' . "\r\n";
				base_url() . 'MailConfirm/confirmation_mail/?user_id=' . base64_encode($user_id . '&email=' . $email);
				$mailer_username = config_item('mailer_username');
				$mailer_name = config_item('mailer_name');

				$data = array(
					'name' => $name,
					'email' => $email,
					'remember_token' => $token,
					'url' => base_url() . 'MailConfirm/resetPassword/',
				);

				$this->email->from($mailer_username, $mailer_name);
				$this->email->set_mailtype("html");
				$this->email->to($email); // replace it with receiver mail id
				$this->email->subject($subject); // replace it with relevant subject
				$body = $this->load->view('backend/mail/send_email.php', $data, TRUE);
				$this->email->message($body);
				$sent_mail = $this->email->send();
				if ($sent_mail) {
					$code = '200';
					$message = PASS_SUCCESS;
					$this->success($code, $message);
				} else {
					$code = '201';
					$message = UPDATE_ERROR;
					$this->error($code, $message);
				}
			} else {
				$code = '300';
				$message = EMAIL_NOT_EXISTS;
				$this->error($code, $message);
			}
		} else {
			$code = '400';
			$message = BAD_REQUEST;
			$this->error($code, $message);
		}
	}

}
