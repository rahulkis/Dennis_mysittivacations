<?php
include("Query.Inc.php");

$Obj = new Query($DBName);
$res='';
$userID=$_SESSION['user_id'];
if(isset($_POST['month'])){
$month=$_POST['month'];
$year=$_POST['year'];
 $type_of_user=$_POST['hostOruser'];
$hostID=$_POST['hostid'];
if($type_of_user=='club'){
$userOrhost=" AND host_id =".$userID;
}else if($type_of_user=='user'){
	$userOrhost=" AND host_id =".$hostID;
}


if($month==date('n') && $year==date('Y')){
	$sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.' AND DAY(date) >=DAY(now()) '.$userOrhost.' ORDER BY    date ASC  ';
}else{
	$sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.$userOrhost.' ORDER BY    date ASC  ';
}



	$retval = mysql_query( $sql);
	$numResults = mysql_num_rows($retval);
	?>

<?
	if($numResults > 9)
{
	$class = " class='scroll_Div1'";
}
if($numResults){
   ?>
  <div <?php echo $class;?>>
  

 <table class='display loadmusic'  style='margin-top:10px;' >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#ACD6FE">
		   
			<th>Location</th>
            <th>Date & Time</th> <th>Map</th>
			<th>Action</th></tr>
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
			 <?php  if($type_of_user=="user"){?>
				 
				 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
				 <? }else if($type_of_user=="club"){?>
					 
					 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
					 <? } ?>		
			<p>
           </td>
           <td>
           
			<?php $starttimedate = date('M d,Y H:i',strtotime($row1['start_time']));
			$endtimedate = date('M d,Y H:i',strtotime($row1['end_time']));
			echo $starttimedate." - ".$endtimedate; ?>
            
           </td>
           <td>
			   
			   <?php  if($type_of_user=="user"){?>
			   <a href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="24px"; height="24px";></a>
		<?}else if($type_of_user=="club"){?>
			 <a href="read_venue.php?id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="24px"; height="24px";></a>
		<? } ?>	  
		 
			 </td>
			<td  style="width=100px;">
		 <? if($type_of_user=="club") {?>		
            <a href="editevent.php?edit=<?php echo $row1['id']; ?>" > <img title="Edit Event" src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img title="Delete Event" src="images/del.png" width="25px"; height="25px";></a>
            <? }else{ ?>
            
            
             <a href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" > View</a>
           
            <? } ?></td></tr>
		<?php
		$i++;
		}
		 ?>
	</tbody>
	<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
	<input type="hidden" id="hostid" value="<? echo $hostID;?>">
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
<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
	<input type="hidden" id="hostid" value="<? echo $hostID;?>">
</td>
</tr>
</table>
<? } ?></div>
<?
}


if(isset($_POST['rmonth'])){
$month=$_POST['rmonth'];
$year=$_POST['ryear'];
 $type_of_user=$_POST['hostOruser'];
$hostID=$_POST['hostid'];
if($type_of_user=='club'){
$userOrhost=" AND host_id =".$userID;
}else if($type_of_user=='user'){
	$userOrhost=" AND host_id =".$hostID;
}

if($month==date('n') && $year==date('Y')){
	 $sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.' AND DAY(date) >=DAY(now()) '.$userOrhost.' ORDER BY    date ASC  ';
}else{
	$sql = 'SELECT * FROM `venues`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.$userOrhost.' ORDER BY    date ASC  ';
}

	$retval = mysql_query( $sql);
	$numResults = mysql_num_rows($retval);?>
	<div id='listvenue_tab'>
	<?if($numResults > 9)
{
	$class = " class='scroll_Div1'";
}
if($numResults){
   ?>
  <div <?php echo $class;?>>
  
<table class='display loadmusic' id='listvenue_tab' style='margin-top:10px;' >
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
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		
		<td>
			<p><?
			$stringlocation = (strlen($row1['location']) > 14) ? substr($row1['location'],0,10).'...' : $row1['location'];
			?>
			 <?php  if($type_of_user=="user"){?>
				 
				 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
				 <? }else if($type_of_user=="club"){?>
					 
					 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_venue.php?id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
					 <? } ?>		
			<p>
           </td>
           <td>
           
			<?php echo date('M d,Y',strtotime($row1['date'])); ?>
			<? 
			$startime=strtotime($row1['start_time']);
			$time_in_24_hour_format  = date("g:i a", $startime);?>
			<?php echo "&nbsp;".$time_in_24_hour_format."-"; ?>
			<?php 
			$endtime=strtotime($row1['end_time']);
			$time_in_24_hour_endformat  = date("g:i a", $endtime);
			echo $time_in_24_hour_endformat; ?>
            
           </td>
           <td><a href="read_venue.php?id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="25px"; height="25px";></a></td>
			
			<td  style="width=100px;">
		 <? if($type_of_user=="club") {?>		
            <a href="editvenue.php?edit=<?php echo $row1['id']; ?>" > <img title="Edit Event" src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img title="Delete Event" src="images/del.png" width="25px"; height="25px";></a>
            <? }else{ ?>
            <a href="read_venue.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" > View</a>
           
            <? } ?></td></tr>
		<?php
		$i++;
		}
		?>
	</tbody>
	<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
	<input type="hidden" id="hostid" value="<? echo $hostID;?>">
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
<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
	<input type="hidden" id="hostid" value="<? echo $hostID;?>">
</td>
</tr>

</table>
<? } ?>
<?
}
