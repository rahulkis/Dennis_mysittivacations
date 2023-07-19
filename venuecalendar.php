<?php
session_start();

include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
if($userType=='club'){
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$userOrhost=" AND host_id =".$userID;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="club" && $userArray[0][type_of_club]!=10){
$Obj->Redirect("home_club.php");
}
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
$Obj->Redirect("host_profile.php");
}
$hostID=$_GET['host_id'];
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=10){
	$Obj->Redirect("host_profile.php?host_id=".$hostID);
}
$userOrhost=" AND host_id =".$hostID;
}
$titleofpage="Calendar";
	
include('headhost.php');
include('header.php');
if($userType=='club'){
	include('headerhost.php');
}
?>
<script language="javascript">
	function enableclass()
	{
		document.getElementById("Savetonightlist").removeAttribute("disabled"); 
	}
</script>


<?
  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 

<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Calendar</h2>
				 
      <?php   
       $userID=$_SESSION['user_id'];  
        function draw_calendar($month,$year,$events = array()){
//echo "<pre>"; print_r($events); die;
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar" style="width:100%;">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row first-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			
            
            
            if($list_day < 10 )
            {
                $list_day = "0".$list_day;
            }
            else
            {
                $list_day = $list_day;
            }
            
	 		$event_day = $year.'-'.$month.'-'.$list_day;
         //echo "<pre>";   
            //print_r($events);
            
			if(isset($events[$event_day])) {
				$i=0;$userType= $_SESSION['user_type'];
				foreach($events[$event_day] as $key=>$event) {
					$stringlocation = (strlen($event['location']) > 6) ? substr($event['location'],0,6).'...' : $event['location'];
				 $evntdate=date('M d,  Y',strtotime($event['date'])); 
				 
				   if($userType=="user"){
				    	if($i<2)
					   	{
						   	if($key == "booking")
						 	{
								$calendar.= "<a class='tooltip' href='javascript:void(0);'>".$stringlocation."
							<span class='event'><b>Booking Name : </b>".$event['location']."</br><b>Date : </b>".$evntdate."</span> </a><br /><br />";
								
							}
							elseif($key == "venue")
							{
								$calendar.= "<a class='tooltip' href='read_venue.php?host_id=".$_GET['host_id']."&id=".$event['id']."'>".$stringlocation."</br>
	                                 <span class='event'><b>Location : </b>".$event['location']."</br><b>Date : </b>".$evntdate."</span> </a></br>";
	                     	}
					 	}
					 	if($i==2){
						 	$calendar.="<a class='read_mor' href=''>View all</a>";
					 	}
					   
				   }
				   elseif($userType=="club")
				   {
						if($i<2)
						{
							if($key == "booking")
							{
								$calendar.= "<a class='tooltip' href='bookings.php?page=edit&id=".$event['id']."'>".$stringlocation."
											<span class='event'><b>Booking Name : </b>".$event['location']."</br><b>Date : </b>".$evntdate."</span> </a><br /><br />";
												
							}
							elseif($key == "venue")
							{
					   			$calendar.= "<a class='tooltip' href='read_venue.php?id=".$event['id']."'>".$stringlocation."
	                                 <span class='event'><b>Location : </b>".$event['location']."</br><b>Date : </b>".$evntdate."</span> </a></br>";					   
                         	}
					    }
					    if($i==2)
					    {
					 		$calendar.="<a class='read_mor' href='listvenue.php'>View all</a>";
					 	}
				   }
				   
				 
				
				$i++;
				}
			}
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor; 

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

/* date settings */
$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
    if($x < 10)
    {
        $x = "0".$x;
    }
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

if(isset($_GET['month']))
{
    $month = "0".$_GET['month'];
}
else
{
    $month = date('m');
	
}



/* "next month" control */
$userType= $_SESSION['user_type'];
 if($userType=="club"){
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control calendarright"><img src="images/arrow_right.png" alt="" /></a>';

/* "previous month" control */
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><img src="images/arrow_left.png" alt="" /></a>';
} else if($userType=="user"){
$next_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control"><img src="images/arrow_right_black.png" alt="" /></a>';

/* "previous month" control */
$previous_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><img src="images/arrow_left_black.png" alt="" /></a>';
	
	
}

/* bringing the controls together */
$controls = '<form id="calendarhead" method="get">'.$previous_month_link.'<h2 class="monthhead">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>'.$next_month_link.' </form>';

/* get all events for the given month */
$new_events = array();
$bookings = array();

 $query = "SELECT id ,location, date FROM venues WHERE month(date) = '$month' ".$userOrhost." AND year(date) = '$year' ";

$result = mysql_query($query) or die('cannot get results!');
while($row = mysql_fetch_assoc($result)) {
	$new_events[$row['date']]['venue'] = $row;
}

$bookings_query = "SELECT id, book_type as location, requeted_date as date FROM bookings WHERE (status LIKE '%Accept%') OR (status LIKE '%Confirm%') OR (status LIKE '%Done%') ".$userOrhost." ";
$booking_result = mysql_query($bookings_query) or die('cannot get results!');
while($booking_row = mysql_fetch_assoc($booking_result)) {
	
	$bookings[$booking_row['date']]['booking'] = $booking_row;
	
}
$events = array_merge($bookings, $new_events);


if($userType=='club'){
echo '<div id="vieweventslist"><a class="button" href="listvenue.php">View Venue List</a></div>';
}else if($userType=='user'){
	echo '<div id="vieweventslist"><a class="button" href="listvenue.php?host_id='.$hostID.'">View Venue List</a></div>';
}
echo '<div id="bigcalendar" style="float:left; width: 99.75%; border-bottom: none;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$events);
echo '<br /><br />';
        ?>
		
		
		<!-- EVENTS CALENDAR ENDS --> 	
   
		 </div>
		 

 </div>
<? if($_SESSION['user_type']=='user'){?>
	
									<?php include('host_left_panel.php'); ?>
					
                     <? }else {  ?>
                     
                          <?php include('club-right-panel.php') ?>
                       		
                       <?php } ?>
   
  </div>
</div>
<?
include('footerhost.php');
?>



