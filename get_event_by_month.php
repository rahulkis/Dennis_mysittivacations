<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$res='';
$userID=$_SESSION['user_id'];
if(isset($_POST['month'])){
$month=$_POST['month'];
$type_of_user=$_POST['hostOruser'];
$hostID=$_POST['hostid'];
if($type_of_user=='club'){
$userOrhost=" AND host_id =".$userID;
}else if($type_of_user=='user'){
	$userOrhost=" AND host_id =".$hostID;
}

$year=$_POST['year'];
if($month==date('n') && $year==date('Y')){
	$sql = 'SELECT * FROM `events`  WHERE YEAR(date) = "'.$year.'" AND MONTH(date) ="'. $month.'" DAY(date) >= DAY(now())"' .$userOrhost.'" AND city_id = '.$_SESSION['id'].' ORDER BY date ASC';
}else{
	$sql = 'SELECT * FROM `events`  WHERE YEAR(date) = "'.$year.'" AND MONTH(date) ="'. $month.$userOrhost.'" AND city_id = '.$_SESSION['id'].' ORDER BY date ASC';
}

	$retval = mysql_query( $sql);
	$numResults = mysql_num_rows($retval);
	

	
 
if($numResults > 9)
{
	$class = " class='scroll_Div1'";
}
if($numResults){
   ?>
  <div <?php echo $class;?>>
  
<div class="scroll_Div1no tab_scroll">
 <table class='display loadmusic'  style='' >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
             <th>Date</th>
			<th>Event Name</th>
            <th>Description</th>
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
           
			   <?php echo date('M d,Y',strtotime($row1['date'])); ?>
			
            
           </td><td>
			<p>
			<?
			$stringlocation = (strlen($row1['eventname']) > 14) ? substr($row1['eventname'],0,10).'...' : $row1['eventname'];
			if($type_of_user=="user"){?>
				 
				 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_event.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>

				 <? }else if($type_of_user=="club"){?>
					 
					  <a title="click to read more" style=" color: black;text-decoration: none;"href="read_event.php?id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
					 <? } ?>		
			<p>
			
           </td>
            <td>
           
			<p>
				
				<?php 
				$stringdescription = (strlen($row1['description']) > 14) ? substr($row1['description'],0,10).'...' : $row1['description'];
				echo $stringdescription ?><p>
			
            
           </td>
          
			<td  style="width=100px;">
		 <? if($type_of_user=="club") {?>		
            <a href="editevent.php?edit=<?php echo $row1['id']; ?>" > <img title="Edit Event" src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img title="Delete Event" src="images/del.png" width="25px"; height="25px";></a>
            <? }else{ ?>
            <a href="read_event.php?host_id=<?php echo $hostID;?>&id=<?php echo $row1['id']; ?>">View</a>
           
            <? } ?></td>
		</tr>
		<?php
		$i++;
		}
		?>
	</tbody>
	<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
	<input type="hidden" id="hostid" value="<? echo $_POST['hostid'];?>">
	</form>
</table></div></div>
<? }else{?>
<div class="scroll_Div1no tab_scroll">
<table class='display loadmusic'>
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
             <th>Date</th>
			<th>Event Name</th>
            <th>Description</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tr class="even"><td colspan="4">
<div id="titles"> No upcoming events.</div>
<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
<input type="hidden" id="hostid" value="<? echo $_POST['hostid'];?>">

</td>
</tr>

</table>
<? } ?></div></div>
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
	 $sql = 'SELECT * FROM `events`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.' AND DAY(date) >=DAY(now())'.$userOrhost.' AND city_id = '.$_SESSION['id'].' ORDER BY    date ASC  ';
}else{
	 $sql = 'SELECT * FROM `events`  WHERE YEAR(date) = '.$year.' AND MONTH(date) ='. $month.$userOrhost.' AND city_id = '.$_SESSION['id'].' ORDER BY date ASC  ';
}
	
	$retval = mysql_query( $sql);
	$numResults = mysql_num_rows($retval);
	?>
	<div id="listvenue_tab">
<?
if($numResults > 9)
{
	$class = " class='scroll_Div1'";
}
if($numResults){
   ?>
  <div <?php echo $class;?>>

  
<div class="scroll_Div1no tab_scroll">
 <table class='display loadmusic'  style='' >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
             <th>Date</th>
			<th>Event Name</th>
            <th>Description</th>
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
           
			   <?php echo date('M d,Y',strtotime($row1['date'])); ?>
			
            
           </td><td>
			<p>
			<?
			$stringlocation = (strlen($row1['eventname']) > 14) ? substr($row1['eventname'],0,10).'...' : $row1['eventname'];
			if($type_of_user=="user"){?>
				 
				 <a title="click to read more" style=" color: black;text-decoration: none;"href="read_event.php?host_id=<?php echo $hostID; ?>&id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>

				 <? }else if($type_of_user=="club"){?>
					 
					  <a title="click to read more" style=" color: black;text-decoration: none;"href="read_event.php?id=<?php echo $row1['id']; ?>" ><? echo $stringlocation ?></a>
					 <? } ?>		
			<p>
			
           </td>
            <td>
           
			<p>
				
				<?php 
				$stringdescription = (strlen($row1['description']) > 14) ? substr($row1['description'],0,10).'...' : $row1['description'];
				echo $stringdescription ?><p>
			
            
           </td>
          
			<td  style="width=100px;">
		 <? if($type_of_user=="club") {?>		
            <a href="editevent.php?edit=<?php echo $row1['id']; ?>" > <img title="Edit Event" src="images/Edit.png" width="25px"; height="25px";></a>
            
            &nbsp;<a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img title="Delete Event" src="images/del.png" width="25px"; height="25px";></a>
            <? }else{ ?>
             <a href="read_event.php?host_id=<?php echo $hostID;?>&id=<?php echo $row1['id']; ?>">View</a>
           
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
</table></div></div>
<? }else{?>
<div class="scroll_Div1no tab_scroll">
<table class='display loadmusic'>
	<thead>
		<tr bgcolor="#ACD6FE">
		
            
             <th>Date</th>
			<th>Event Name</th>
            <th>Description</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tr class="even"><td colspan="4">
<div id="titles"> No upcoming Event.</div>
<input type="hidden" id="hostOruser" value="<? echo $type_of_user;?>">
<input type="hidden" id="hostid" value="<? echo $hostID;?>">
</td>
</tr>
</table>
</div>
<? } ?>
<?
}
