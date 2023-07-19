<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
$titleofpage="Upcoming Venues";
include('headhost.php');
include('header.php');
if($userType=="club"){
include('headerhost.php');
}
if(isset($_SESSION['venueadded'])){
	$message['success'] = "Venue added successfully.";
	unset($_SESSION['venueadded']);
	
}
if(isset($_SESSION['venueedited'])){
	$message['success'] = "Venue updated successfully. ";
	unset($_SESSION['venueedited']);
	
}
if(isset($_SESSION['venuedeleted'])){
	echo $_SESSION['venuedeleted'];
	$message['success'] = "Venue deleted successfully.";
	unset($_SESSION['venuedeleted']);
	
}

if($userType=='club'){
	$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userType=="club" && $userArray[0][type_of_club]!=10){
$Obj->Redirect("home_club.php");
}
$type_of_user="club";
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
$Obj->Redirect("index.php");
}

$type_of_user="user";
$hostID=$_GET['host_id'];
$userOrhost=" AND host_id ='$hostID'";
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=10){
$Obj->Redirect("host_profile.php?host_id=".$hostID);
}
}
if(isset($_SESSION['venueadded'])){
	$message['success'] = "Venue added successfully.";
	unset($_SESSION['venueadded']);
	
}
if(isset($_SESSION['venueedited'])){
	$message['success'] = "Venue updated successfully. ";
	unset($_SESSION['venueedited']);
	
}
if(isset($_SESSION['venuedeleted'])){
	echo $_SESSION['venuedeleted'];
	$message['success'] = "Venue deleted successfully.";
	unset($_SESSION['venuedeleted']);
	
}
?> 

<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Upcoming Venues</h2>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
					 <div id="demosss">
    <div class="upcomin_venue_div">
    <script>
  function getMonthName(v) {
    var n = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return n[v]
}
    function get_venue_by_month(){    
		jQuery("#loader").show();		
		jQuery('#get_revrs_venue_by_month').show();
		
		$curnt = (new Date).getMonth() + 1;
		$curnt_year=(new Date).getFullYear() ;
		
		$type_of_user=jQuery('#hostOruser').val();
		
		$current_month=     jQuery('#current_month_for_venue').val();
		$current_month=parseInt($current_month);
		$current_month=$current_month+1;
   
        $current_year=     jQuery('#current_year_for_venue').val();
        $type_of_user=jQuery('#hostOruser').val();
		$hostid=jQuery('#hostid').val();  
        jQuery('#current_month_for_venue').val($current_month);
        
         if($current_month==13){
		$current_month=1;   
		$curnt_year=jQuery('#current_year_for_venue').val();		
		$curnt_year=parseInt($curnt_year);
		$curnt_year=$curnt_year+1;
		
		jQuery('#current_month_for_venue').val($current_month);
		jQuery('#current_year_for_venue').val( $curnt_year);
		}
  
   $val= jQuery('#current_month_for_venue').val();
    $current_year=     jQuery('#current_year_for_venue').val(); 
   $.ajax({
    type: "POST",
    url: "get_venue_by_month.php",
    data:"month="+$val+"&year="+$current_year+"&hostOruser="+$type_of_user+"&hostid="+$hostid,
    success:  function(data){
       jQuery("#loader").hide();
        jQuery('#listvenue_tab').html(data);
       
      
    if($current_month==0){
		$name=  getMonthName($current_month);
	}else{
	$name=  getMonthName($current_month-1);
     }
	$curntyear= jQuery('#current_year_for_venue').val()
	jQuery('#date_month_venue').html($name+" "+$curntyear)
    }
   
    }); 
    
    }  
   function get_revrs_venue_month(){
			jQuery("#loader").show();
			jQuery('#successmessage').html();
			
			$curnt = (new Date).getMonth() + 1;
			$curnt_year=(new Date).getFullYear() ;
			
			$current_month=     jQuery('#current_month_for_venue').val();         
			$current_year=     jQuery('#current_year_for_venue').val();
			$type_of_user=jQuery('#hostOruser').val();
			
			$current_year=parseInt($current_year);
			$current_month=parseInt($current_month);  
			
			$type_of_user=jQuery('#hostOruser').val();
		    $hostid=jQuery('#hostid').val();
		    
	    if($current_month==0 && $current_year!=$curnt_year) {
			  jQuery('#current_month_for_venue').val('12');
			  jQuery('#current_year_for_venue').val( $current_year-1);
		  }else if($current_month==1){
		jQuery('#current_month_for_venue').val('12');
		jQuery('#current_year_for_venue').val( $current_year-1);
		
	 }  else{
	    $current_month=$current_month-1;
        jQuery('#current_month_for_venue').val($current_month);		
        }
	     $val= jQuery('#current_month_for_venue').val();
	    $current_year=     jQuery('#current_year_for_venue').val(); 
	    
	   $.ajax({
	    type: "POST",
	    url: "get_venue_by_month.php",
	    data:"rmonth="+$val+"&ryear="+$current_year+"&hostOruser="+$type_of_user+"&hostid="+$hostid,
	    success:  function(data){
	    jQuery("#loader").hide();
	        jQuery('#listvenue_tab').html(data);
	       // window.location.reload(true);
	       if($current_month==$curnt && $curnt_year==$current_year){
	         jQuery('#current_month_for_venue').val()==$curnt;
	         jQuery('#get_revrs_venue_by_month').hide();
	         
            }
             if($current_month==0){
           $asd=11;
           $name=  getMonthName($asd);
           $current_y=$current_year-1;
           jQuery('#date_month_venue').html($name+" "+$current_y);
          
           }if($val==12){
			   $asd=11;
           $name=  getMonthName($asd);
          
           jQuery('#date_month_venue').html($name+" "+$current_year);
			   }else{
          $name=  getMonthName($current_month-1);
          jQuery('#date_month_venue').html($name+" "+$current_year);
           }
		
	    }         
          
	    });
	     
	     
    }
    </script>
     <span class="upcomin_venue_spn">
     
 
     </span>
     
     <div style="margin: 0px auto; width: 100%; text-align: center;">
     <span class="new_mnth"> 
     <?php if(isset($_SESSION['year_Edit']))
      {
      //echo date("n").date("n", strtotime($_SESSION['month_Edit']));
       if(date("n") < date("n", strtotime($_SESSION['month_Edit']))){
        echo ' <img onclick="get_revrs_venue_month()" id="get_revrs_venue_by_month"   style="cursor:pointer;"   src="images/left-arrow.png" width="20px";vertical-align: top; height="20px";>';
       }else{
        echo ' <img onclick="get_revrs_venue_month()" id="get_revrs_venue_by_month" style="cursor:pointer;display:none; vertical-align: top;"   src="images/left-arrow.png" width="20px";vertical-align: top; height="20px";>';
       }
          } else{
          echo ' <img onclick="get_revrs_venue_month()" id="get_revrs_venue_by_month" style="cursor:pointer;display:none; vertical-align: top;" src="images/left-arrow.png" width="20px";vertical-align: top; height="20px";>';
          }?>
    
     <span id="date_month_venue" >
    <?php if(isset($_SESSION['year_Edit'])){
       echo $_SESSION['month_Edit']."&nbsp;".$_SESSION['year_Edit'];
        $valyearhidden=date("Y", strtotime($_SESSION['year_Edit']));
       
         $valmonthhidden=date("n", strtotime($_SESSION['month_Edit']));
     }else{
          echo date('F Y'); $valyearhidden=date('Y'); $valmonthhidden=date('n');
          } ?>
     
      </span>
      <img onclick="get_venue_by_month()" src="images/right-arrow.png" width="20px"; height="20px"; style="vertical-align: top;">
     <input type="hidden" value="<?php echo $valmonthhidden;?>" name="current_month_for_venue" id="current_month_for_venue">
      <input type="hidden" value="<?php echo $valyearhidden;?>" name="current_year_for_venue" id="current_year_for_venue">
     </span>
     <? if($userType=="club"){?>
     <span style="float: right; margin-top:5px; "><a href="addvenue.php" class="button btn_add_venu">Add Venue</a></span></div>
     <? }?>
     </div>
   <?php if(isset($success)) { ?> <div style="color:#060"><?php echo $success ?></div> <?php } 
   if(isset($_GET['p']) && $_GET['p']=="all"){
       $sql = 'SELECT * FROM `venues` ORDER BY date ASC';
   }else{
     //$sql = 'SELECT * FROM `venues` ORDER BY modified_time DESC where  limit 0,5';


	if(isset($_SESSION['month_Edit'])){
		if(date("n", strtotime($_SESSION['month_Edit']))==date('n')){
		 $sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$_SESSION['year_Edit'].' AND MONTH(date) = '.date("m", strtotime($_SESSION['month_Edit'])).' AND DAY(date) >= DAY(NOW()) '.$userOrhost.' ORDER   BY    date ASC ';
		}else{
	 $sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$_SESSION['year_Edit'].' AND MONTH(date) = '.date("m", strtotime($_SESSION['month_Edit'])).$userOrhost.' ORDER   BY    date ASC ';
	}
	
	}else{
	$sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date) = MONTH(NOW()) AND DAY(date) >= DAY(NOW()) '.$userOrhost.'ORDER BY    date ASC ';
	}
   }
 
$retval = mysql_query( $sql);
$numResults = mysql_num_rows($retval);
?>
<div id='listvenue_tab'>
	<?
if($numResults > 9)
{
	$class = " class='scroll_Div1'";
}
if($numResults){
   ?>
  <div <?php echo $class;?>>
  
<!--<table  class="display" id="listvenue_tab" style="margin-left: 22px;margin-top: 10px;width: 92%;" >-->
 <table class='display loadmusic' id='listvenue_tab' style='' >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
            
			<th>Location</th>
            <th>Date & Time</th> <th>Map</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	
	$i=0;
	while($row1 = mysql_fetch_array( $retval))
	{
	  if($i%2 == '0')
{
	$class = " class='even' ";
}
else
{
	$class = " class='odd' ";
}
	?>
		<tr <?php echo $class;?>>
	
			<td>
			<p><?
			$stringlocation = (strlen($row1['location']) > 14) ? substr($row1['location'],0,10).'...' : $row1['location'];
			?>
			 <?php  if($userType=="user"){?>
				 
				 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
				 <? }else if($userType=="club"){?>
					 
					 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
					 <? } ?>		
			<p>
           </td>
           <td>
           
			<?php //echo date('M d,Y',strtotime($row1['date'])); ?>
			<? 
//echo $row1['start_time']."/////";
			$starttimedate = date('M d,Y H:i',strtotime($row1['start_time']));
			$endtimedate = date('M d,Y H:i',strtotime($row1['end_time']));
			echo $starttimedate." - ".$endtimedate;
			// $startime=strtotime($row1['start_time']);
			// $time_in_24_hour_format  = date("g:i a", $startime);// echo "&nbsp;".$time_in_24_hour_format."-"; 
			// $endtime=strtotime($row1['end_time']);
			// $time_in_24_hour_endformat  = date("g:i a", $endtime);
			// echo $time_in_24_hour_endformat; ?>
            
           </td>
           <td>
			   
			   <?php  if($userType=="user"){?>
			   <a href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="24px"; height="24px";></a>
		<?}else if($userType=="club"){?>
			 <a href="read_venue.php?id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="24px"; height="24px";></a>
		<? } ?>	  
		 
			 </td>
			<td  style="width=100px;">
		 <? if($userType=="club") {?>		
            <a href="editvenue.php?edit=<?php echo $row1['id']; ?>" > <img title="Edit Venue" src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img title="Delete Venue" src="images/del.png" width="25px"; height="25px";></a>
            <? }else{ ?>
            <a href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" > View</a>
           
            <? } ?></td></tr>
		<?php
		$i++;
		}
		?>
	</tbody>
	<input type="hidden" id="hostid" value="<? if(isset($_GET['host_id'])){echo $_GET['host_id'];}?>">
	<input type="hidden" id="hostOruser" value="<? echo $userType;?>">
	</form>
</table></div>
<? }else{?>
<table class='display loadmusic'>
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
             <th>Location</th>
            <th>Date & Time</th> <th>Map</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tr class="even"><td>
<div id="titles"> No upcoming venue.</div>
<input type="hidden" id="hostid" value="<? if(isset($_GET['host_id'])){echo $_GET['host_id'];}?>">
	<input type="hidden" id="hostOruser" value="<? echo $userType;?>">
</td>
</tr>
</table>
<? } ?>
<img src="images/ajax-loader.gif" style="display:none;" id="loader">
</div>	</div>	

<script>

function delrecoreds(id)
{
$val= jQuery('#current_month_for_venue').val();
	    $current_year= jQuery('#current_year_for_venue').val(); 
  if(confirm('Are You sure You want to delete this record'))
  {
	 $.get( "deletevenue.php?id="+id+"&month="+$val+"&year="+$current_year, function( data ) {
			window.location='listvenue.php';
		});
  }
   else
   {
	
	}

}
</script>
<!-- end here-->
		
	
	</div>	 
<script language="javascript">	

</script>
 </div>
<? if($_SESSION['user_type']=='user'){?>
 </div>
				<?php include('host_left_panel.php'); ?>
                     <? }else {  ?>
                     
                          <?php include('club-right-panel.php') ?>
                       		
                       <?php } ?>
   
  </div>
</div>
<?
include('footer.php');
?>

<?php

 unset($_SESSION['year_Edit']);
  unset($_SESSION['month_Edit']);

