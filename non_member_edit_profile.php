<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
  $Obj->Redirect("login.php");
}
$titleofpage = " All Connections";
?>
<script type="text/javascript">
function isLogin() {
  if (confirm("To view profile Please login. ")) {
   document.location = "login.php";
  }
}
 function requestBlock(id)
 {
   $.get('request-block.php?f_id='+id, function(data) {
$('#request_'+id).html(data);
});
 }

function chatsetting(action,id,f_id)
{
    
    //Use jQuery's ajax function to send it
    $.ajax({
        type: "POST",
        url: "chatsetting.php",
        data: {
            'action' : action,
            'id' : id,
            'f_id' : f_id
        },
        success: function(data){
          if((action == 'disableall') || (action == 'enableall') )
          {
              //('span.disableall').html(data);
              location.reload(true);
          }
          else
          {
              $('#enablechat_'+f_id).html(data);    
          }
        

        }
    });
    
    //We return false so when the button is clicked, it doesn't follow the action
    return false;
}


</script>

<style>
.login table{
border-collapse:collapse;
text-align:left;
border:1px solid blue;
}
.login table tr td{
border:1px solid blue;
}

#title > span.disableall {
    float: right;
    font-size: 13px;
    width: auto;
}

.error{ color: red; }
</style>
<?php 

if($_SESSION['user_id']!="" )
{

 //  $sql4="select distinct(f.friend_id),u.first_name,u.last_name,cc.city_name,z.name as state ,z.code,c.name as country,f.id as f_id,f.chat  from  friends as f 
 //  left join user as u on(f.friend_id=u.id)
 // left join capital_city as cc on(cc.city_id=u.city)
 // left join  zone as z on(cc.state_id=z.zone_id)
 // left join country as c on(c.country_id=z.country_id)
 // where f.status='active' AND  f.friend_type='user'  AND f.user_id='".$_SESSION['user_id']."'";
//$sql4="select distinct(fs.friend_id),u.first_name,u.image_nm,u.last_name,u.country,u.state,u.city,fs.friend_id,fs.chat,fs.id as f_id from friends as fs,
//        user as u
//        where u.id=fs.friend_id AND fs.user_id='".$_SESSION['user_id']."' AND fs.friend_type='user' AND fs.status='active'";
$id = $_GET['non_member'];

$sql4 =  "select * from user where id = $id";

}
 $sql6=@mysql_query($sql4);
 // $sql111 = mysql_fetch_array($sql6);
 // echo "<pre>"; print_r($sql111); exit;
 $num=@mysql_num_rows($sql6);


$chatcheckquery = @mysql_query("SELECT * FROM `friends` WHERE chat= '0' AND `user_id` = '".$_SESSION['user_id']."'  ");
$countdisable = @mysql_num_rows($chatcheckquery);


?>
  <?php include('headhost.php'); ?>

     <?php include('header.php');?>
     <script src='js/jquery.validate.js'></script>
     <script src="js/register.js" type="text/javascript"></script>

    <div class="home_wrapper">
      <div class="main_home">
        <div class="home_content">
          <div class="home_content_top">
            <div class="title  botmbordr" id="title"> Edit Non Member Profile 
                
              
            
            </div>
	     <?php
		  $i=1;
                 while($sql5=@mysql_fetch_array($sql6))
                    {
                      
                     
                      
                      //echo "<pre>"; print_r($sql5); exit;
                      $countrysql = @mysql_query("SELECT * FROM `country` WHERE country_id = '".$sql5['country']."' ");
                      $countryfetch = @mysql_fetch_array($countrysql);
                      $statesql = @mysql_query("SELECT * FROM `zone` WHERE zone_id = '".$sql5['state']."' ");
                      $statefetch = @mysql_fetch_array($statesql);
                      $citysql = @mysql_query("SELECT * FROM `capital_city` WHERE city_id = '".$sql5['city']."' ");
                      $cityfetch = @mysql_fetch_array($citysql);


		?>

                     <div class="">
<?php $q = "?non_member=".$_GET['non_member'] ; ?>
		     <form id="update_user_validate_club" enctype="multipart/form-data" method="post" name="" action="<?php echo $_SERVER['PHP_SELF'].$q; ?>">
      
        	 
           <div class="profileright">
       <div id="profile_box">
       
         <ul>
           <li>Friend First Name:</li>
           <li><input type="text" value="<?php echo $sql5['first_name']; ?>" name="f_fname"></li>
         </ul>
	 
	 <ul>
           <li>Friend Last Name:</li>
           <li><input type="text" value="<?php echo $sql5['last_name'] ;?>" name="f_lname"></li>
         </ul>
	 
          <ul>  
           <li>Email:</li>
           <li><input id="friend_email" type="text" value="<?php echo $sql5['email']?>" name="f_email"></li>
         </ul>
          <ul>  
           <li>Friend Contact No:</li>
           <li><input type="text" value="<?php echo $sql5['phone'];?>" name="f_phone"></li>
         </ul>
          <ul>
           <li>Friend Address:</li>
           <li><input type="text" value="<?php echo $sql5['user_address'];?>" name="f_address"></li>
         </ul>

         
         <ul>
        
                         <li>Country:</li>
			<li><input type="text" value="<?php echo $countryfetch['name']; ?>" name="f_country"></li></li>
         </ul>
	 
	  <ul>
           <li>city:</li>
           <li><input type="text" value="<?php echo $cityfetch['city_name'];?>" name="f_city"></li>
         </ul>
	  
	   <ul>
           <li>state:</li>
           <li><input type="text" value="<?php echo $statefetch['name'];?>" name="f_state"></li>
         </ul>
	 
         <ul>
           <li>Street:</li>
           <li><input type="text" value="<?php echo $sql5['street'] ?>" name="f_s_address"></li>
         </ul>
         <ul>
           <li>Zipcode:</li>
           <li><input id="friend_zipcode" type="text" value="<?php echo $sql5['zipcode'];?>" name="f_zipcode"></li>
         </ul>



       <br>		  
        <div style="width: 100%;" id="submit_btn">
          <input type="submit" value="Update" class="button" name="update_freend_profile">
          <a style="; width: 100px;" class="button" href="all_connections.php">Back</a>  
        </div>
        </div></div>
    </form>
	<?php }
	if(isset($_POST['update_freend_profile']))
		{

			$fname     = $_POST['f_fname'];
			$flname    = $_POST['f_lname'];
			$femail    = $_POST['f_email'];
			$fphone    = $_POST['f_phone'];
			$faddres   = $_POST['f_address'];
			$fcountry  = $_POST['f_country'];
			$fcitys    = $_POST['f_city'];
			$fstates   = $_POST['f_state'];
			$fsaddress  = $_POST['f_s_address'];
			$fzip      = $_POST['f_zipcode'];
						
			
			$get_states = mysql_query("Select zone_id , country_id from zone where name = '$fstates'");
			while($get_states_res = mysql_fetch_assoc($get_states))
				{
				      $state = $get_states_res['zone_id'];
				      $country = $get_states_res['country_id'];
				}
			
			
			$get_city = mysql_query("Select city_id from capital_city WHERE city_name = '$fcitys'");
		       
			
			while($get_city_res = mysql_fetch_assoc($get_city))
			      {
				     $city = $get_city_res['city_id'] ;
			      }
			      
		
		mysql_query("UPDATE `user` SET `first_name` = '$fname', `last_name` = '$flname', `email` = '$femail', `user_address` = '$faddres', `country` = '$country', `street` = '$fsaddress', `state` = '$state', `city` = '$city', `zipcode` = '$fzip', `phone` = '$fphone' WHERE `user`.`id` = $id");
		header('Location: all_connections.php?msg=updated');
			      
		}
	
	
	
	
	?>	     
   
                                    
                 </div>
                 <div style="float: left; width: 100%;border-bottom:1px solid #ffffff; padding:5px;"></div>
       </div>
    
       
      </div>
      <?php include('club-right-panel.php') ?>

    </div>
  </div>    
    <?php include('footer.php') ?>