<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
session_start();
if($_POST["captcha"]==$_SESSION["code"]){
	
					$Status = 1;
					$today = date("Y-m-d h:i:s");
					$password = $_POST['password'];
					$email = $_POST['email'];
					$md5Password = md5($password);
					$profilenameArray = explode('@', $email);
				echo 	$profilename = $profilenameArray[0];
					$random_key= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
		
					$ValueArray = array($md5Password,$profilename,'','',$email,$password,'null','','','null','null','null',$status,$today,'null','null','null','null','null',$random_key);
					$FieldArray = array('password_md5','profilename','first_name','last_name','email','password','hear_about','phone','user_address','country','state','zipcode','status','regi_date','DOB','city','plantype','longitude','latitude','random_key');
					print_r($ValueArray);
					unset($_SESSION['signup_ValueArray']);
					unset($_SESSION['signup_FieldArray']);
					$_SESSION['signup_ValueArray'] = $ValueArray ;
					$_SESSION['signup_FieldArray'] = $FieldArray ;
					$Success = $Obj->Insert_Dynamic_Query('user',$ValueArray,$FieldArray);			
		}else{
			echo "kailash";
		}