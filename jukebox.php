<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
  $Obj->Redirect("login.php");
}
$titleofpage = "All Connections";
?>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
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

function jukebox()
{
var m_title  = $('#m_title').val();
var m_artist = $('#m_artist').val();
var s_note = $('#s_note').val();

$.ajax({
        type: "POST",
        url: "jukeboxquery.php",
        data: {
            'm_title' : m_title,
            'm_artist' : m_artist,
            's_note' : s_note
            
        },
        success: function(data){
          $('.select_music_res').html(data);
           $('#m_title').val('');
           $('#m_artist').val('');
           $('#s_note').val('');
          }
       });
}
$(document).ready(function()
                  {
window.onload = jukebox();

                    });

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
</style>
<link rel="stylesheet" href="css/jukebox.css" />
<?php 

if($_SESSION['user_id']!="" )
{

 //  $sql4="select distinct(f.friend_id),u.first_name,u.last_name,cc.city_name,z.name as state ,z.code,c.name as country,f.id as f_id,f.chat  from  friends as f 
 //  left join user as u on(f.friend_id=u.id)
 // left join capital_city as cc on(cc.city_id=u.city)
 // left join  zone as z on(cc.state_id=z.zone_id)
 // left join country as c on(c.country_id=z.country_id)
 // where f.status='active' AND  f.friend_type='user'  AND f.user_id='".$_SESSION['user_id']."'";
$sql4="select distinct(fs.friend_id),u.first_name,u.image_nm,u.last_name,u.country,u.state,u.city,u.status,u.zipcode,fs.friend_id,fs.chat,fs.id as f_id from friends as fs,
        user as u
        where u.id=fs.friend_id AND fs.user_id='".$_SESSION['user_id']."' AND fs.friend_type='user' AND fs.status='active'
        ORDER BY u.zipcode ASC";


}
 $sql6=@mysql_query($sql4);
 // $sql111 = mysql_fetch_array($sql6);
 // echo "<pre>"; print_r($sql111); exit;
 $num=@mysql_num_rows($sql6);


$chatcheckquery = @mysql_query("SELECT * FROM `friends` WHERE chat= '0' AND `user_id` = '".$_SESSION['user_id']."'  ");
$countdisable = @mysql_num_rows($chatcheckquery);

/******* Delete Friends *******/
if($_GET['page'] == 'del')
{
  $delid  = $_GET['id'];
  $delfriend = mysql_query("DELETE FROM `friends` WHERE `friends`.`friend_id` = $delid");
  $del_message = " Friend Deleted Sucessfully..... ";
  
}
/******* Delete Friends *******/
?>



  <?php include('headhost.php'); ?>

     <?php include('header.php');?>

    <div class="home_wrapper">
      <div class="main_home">
        <div class="home_content">
          <div class="home_content_top">
            <div class="title  botmbordr" id="title"> Jukebox 
                
                                  
              
            
            </div>

                   
                     
                                    
                                     <article class="forum_content jukbox">
		
      <form class="jukebox_form">
	<div style="" class="greyc">
        <div>        
            <h3  id="title">$1.25 per music</h3>
            <div class="form_div_container">
              <div>
                <label>Music Title</label>
              </div>
              <div>
                <input type="text" name="" value="" id="m_title" />
              </div>
            </div>
            <div class="form_div_container">
              <div>
                <label>Artist</label>
              </div>
              <div>
                <input type="text" name="" value="" id="m_artist"  />
              </div>
            </div>
            <div class="form_div_container">
              <div>
                <label>Special Note</label>
              </div>
              <div>
                <input type="text" name="" value="" id="s_note"  />
              </div>
            </div>
            <div class="send_list">
         	<input type="button" value="Add" name="" onclick="jukebox();" />
         </div>
        </div>  
        <div class="slctd_music">
         <h3  id="title">selected Music</h3>
        <div class="slctd_m_cotainer">

         <div class="selctd_music_head">
         	<div>Music Title</div>
            <div>Artist</div>
            <div>Action</div>         	
         </div>
         
         <div class="selctd_music_list">
          
         </div>
			<!--<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><a href="#">Remove</a></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><a href="#">Remove</a></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><a href="#">Remove</a></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><a href="#">Remove</a></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><a href="#">Remove</a></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><a href="#">Remove</a></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><a href="#">Remove</a></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><a href="#">Remove</a></div>         	
         </div>-->
		</div>
        
         <div class="send_list">
         	<input type="submit" value="Send" name="" />
         </div>
        	
        </div>
    </div>    
        
        <div class="slctd_m_cotainer2">

         <div class="selctd_music_head">
         	<div>Music Title</div>
            <div>Artist</div>
            <div>Select</div>         	
         </div>
         <div class="select_music_res">
			<!--<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
			<div class="selctd_music">
         	<div>Heartache Tonight</div>
            <div>Eagles</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>
        	<div class="selctd_music">
         	<div>Play Hard (R3hab Remix)</div>
            <div>David Guetta</div>
            <div><input type="checkbox" name=""/></div>         	
         </div>-->
		</div></div>
        
    </form>
    </article>
                                    
                                    
                                    
                 
                 <div style="float: left; width: 100%;border-bottom:1px solid #ffffff; padding:5px;"></div>
       </div>
    
       
      </div>
      <?php include('club-right-panel.php') ?>

    </div>
  </div>    
    <?php include('footer.php') ?>