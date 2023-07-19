
					<div id="calendar">
						<div style="float: left; margin: 10px 0;">
						  	See all list of <a style="font-style: italic; color: rgb(254, 205, 7);" href="listvenue.php">Upcoming Venues</a>
					  	</div>
						
						<!-- VENUE CALENDAR -->
		
		
        
      <?php   
      $hostID=$_SESSION['user_id'];
      $userID = $_SESSION['user_id'];
        function draw_calendar($month,$year,$events = array(),$new_eventsx = array(),$bookingsx=array()){
//echo "<pre>"; print_r($events); die;
	/* draw table */
	$calendar = '<table style="float:left;width:100%; border: 1px solid #000" cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
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
		$calendar.= '<td class="calendar-day"><div class="commondiv" style="position:relative;">';
			/* add in the day number */
			$calendar.= '<div class="day-number" style="padding:2px;">'.$list_day.'</div>';
			
            
            
            if($list_day < 10 )
            {
                $list_day = "0".$list_day;
            }
            else
            {
                $list_day = $list_day;
            }
            if($_GET['month']>10){
				$month=ltrim($month, '0');
			}
	 		$event_day = $year.'-'.$month.'-'.$list_day;
         //echo "<pre>";   
            //print_r($events);
            
			if(isset($events[$event_day])) {
				$i=0;$userType= $_SESSION['user_type'];
				foreach($events[$event_day] as $key=>$event) {
// echo $event['location'];
					$stringlocation = (strlen($event['location']) > 6) ? substr($event['location'],0,6).'...' : $event['location'];
				 	$evntdate=date('M d,  Y',strtotime($event['date'])); 
				 
				   if($userType=="user"){
				   	//echo $event['location'];
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
								 $b=0;
                                                    foreach($bookingsx  as $keysx=>$valueb ){
														//echo "<pre>";print_r($valueb);die;
														
														if($valueb['date']==$event['date'] && $b<3){
															if(isset($valueb['eventname']))
																{
																	$stringlocation = (strlen($valueb['location']) > 6) ? substr($valueb['location'],0,6).'...' : $valueb['location'];	
																}
																$evntdate=date('M d,  Y',strtotime($valueb['date'])); 
														$calendar.= "<a class='tooltip' href='bookings.php?page=edit&id=".$valueb['id']."'>".$stringlocation."
											<span class='event'><b>Booking Name : </b>".$valueb['location']."</br><b>Date : </b>".$evntdate."</span> </a><br /><br />";
								
														
														$b++;$i++;
															}
														
														
													}
												
							}
							elseif($key == "venue")
							{ 
								$e=0;
                                                    foreach($new_eventsx  as $keysx=>$valuex ){
														//echo "<pre>";print_r($valuex);die;
														
														if($valuex['date']==$event['date'] && $e<2){
															if(isset($valuex['eventname']))
																{
																	$stringlocation = (strlen($valuex['location']) > 6) ? substr($valuex['location'],0,6).'...' : $valuex['location'];	
																}
																$evntdate=date('M d,  Y',strtotime($valuex['date'])); 
															$calendar.= "<a class='tooltip' href='read_venue.php?id=".$valuex['id']."'>".$stringlocation."
	                                 <span class='event'><b>Location : </b>".$valuex['location']."</br><b>Date : </b>".$evntdate."</span> </a></br>";					   
                         	
														$e++;$i++;
															}
														
														
													}
					   			}
					    }
					    if($i==2)
					    {
							if($e>1){
					 		$calendar.="<a class='read_mor' href='listvenue.php'>View all</a>";
						}
						if($b>1){
											$calendar.="<a class='read_mor' href='bookings.php'>View all</a>";
										}
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
$next_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control calendarright"><img src="images/arrow_right.png" alt="" /></a>';

/* "previous month" control */
$previous_month_link = '<a href="?host_id='. $hostID.'&month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><img src="images/arrow_left.png" alt="" /></a>';


/* bringing the controls together */
$controls = '<form id="calendarhead" method="get">'.$previous_month_link.'<h2 class="monthhead">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>'.$next_month_link.' </form>';

/* get all events for the given month */
$new_events = array();
$bookings = array();

 $query = "SELECT id ,location, date FROM venues WHERE month(date) = '$month' AND year(date) = '$year' AND host_id='$userID'";

$result = mysql_query($query) or die('cannot get results!');
while($row = mysql_fetch_assoc($result)) {
	$new_events[$row['date']]['venue'] = $row;
	$new_eventsx[$row['id']] = $row;
}

$bookings_query = "SELECT id, book_type as location, requeted_date as date FROM bookings WHERE ((status LIKE '%Accept%') OR (status LIKE '%Confirm%') OR (status LIKE '%Done%') OR (status LIKE '%Accept%') ) AND month(requeted_date) = '$month' AND year(requeted_date) = '$year' AND host_id='$hostID'"
$booking_result = mysql_query($bookings_query) or die('cannot get results!');
while($booking_row = mysql_fetch_assoc($booking_result)) {
	
	$bookings[$booking_row['date']]['booking'] = $booking_row;
	$bookingsx[$booking_row['id']] = $booking_row;
	
}
$events = array_merge($bookings, $new_events);


echo '<div style="float:left; width: 100%; border: 1px solid #000; width: 99%;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$events,$new_eventsx,$bookingsx);
echo '<br /><br />';
		?>
		
		<!-- VENUE CALENDAR ENDS --> 	
						
						
						
					
					</div>
					<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>
					
<style>
.read_mor{
	font-size:9px;
}
</style>
