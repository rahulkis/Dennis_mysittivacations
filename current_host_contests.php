<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];

$userType= $_SESSION['user_type'];



$titleofpage="Host Contests";	



if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); 
}
else
{
	$Obj->Redirect('index.php');
}

		

?>

<script type="text/javascript">

	$(document).ready( function() {
		$('html, body').animate({
			scrollTop: $(".v2_inner_main").offset().top - 150
		}, 1000);
	});
</script>

<div class="clear"></div>
<div class="v2_container">
 <div class="v2_inner_main">
  <div class="v2_inner_main_content">
   <div class="support_inner v2_mysitti_contest_lissts">
    <h3 id="title" class="h3">Host Contests</h3>
    <?php 

					if($message['success'] != "")

					{ 

						echo '<div id="successmessage" class="message" >'.$message['success']."</div>";

					}

					if($message['error'] != "")

					{					 

						echo '<div id="errormessage" class="message" >'.$message['error']."</div>";

					} 

					?>
	<script type="text/javascript" src="<?php echo $SiteURL;?>js/jquery.countdown.js"></script> 
	<script type="text/javascript" src="<?php echo $SiteURL;?>js/lodash.min.js"></script>
    <div class="s_main_list v2_recent_contests">
     <table>
      <tr>
       <?php

						$sql="SELECT contest.contest_id, contest.contest_img, contest.host_id ,contest.contest_title, contest.contest_start, contest.contest_end ,clubs.club_name , clubs.image_nm FROM contest JOIN clubs

							ON  contest.host_id=clubs.id where contest.status=1 and contest.contest_city=".$_SESSION['id'];

					 	$retval = mysql_query($sql);			  

					    	$count_records = mysql_num_rows($retval);

						$i=0;

						if($count_records > 0)	

						{

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
								$contestStarttime = $row1['contest_start']." ".$row1['start_time'];
								$contestEndtime = $row1['contest_end']." ".$row1['end_time'];
								$contestImage = $SiteURL.str_replace("../../","", $row1['contest_img']);
								$battleStartdatetime = $row1['battle_date_start'];
								$battleEnddatetime = $result['battle_date_end'];
								$contestName = $row1['contest_title'];
								$contestVideo = $row1['contest_video'];
								$contestID = $row1['contest_id'];
								$newcontestEndTime = date('Y/m/d H:i:s',strtotime($contestEndtime));

								

					?>
       <td>
       <div class="s_listboxwrap left_even" <?php echo $class;?>>
         <div class="contestname1 s_border_bottom"> <span class="s_cont_h"><? echo $row1['contest_title'];?></span> </div>
         <div class="timer main-example">
		<script type="text/javascript">
		$(document).ready(function(){
			var  contestID = '<?php echo $contestID; ?>';
			var  endtime = '<?php echo $newcontestEndTime; ?>';
			$(window).on('load', function() {
				var labels = ['Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
				nextYear = endtime,
				template = _.template($('#main-example-template_'+contestID).html()),
				currDate = '00:00:00:00:00',
				nextDate = '00:00:00:00:00',
				parser = /([0-9]{2})/gi,
				$example = $('#main-example_'+contestID);
				// Parse countdown string to an object
				function strfobj(str) 
				{
					var parsed = str.match(parser),
					obj = {};
					labels.forEach(function(label, i) {
					obj[label] = parsed[i]
					});
					return obj;
				}
				// Return the time components that diffs
				function diff(obj1, obj2) 
				{
					var diff = [];
					labels.forEach(function(key) {
						if (obj1[key] !== obj2[key]) {
							diff.push(key);
						}
					});
					return diff;
				}
				// Build the layout
				var initData = strfobj(currDate);
				labels.forEach(function(label, i) 
				{
					$example.append(template({
						curr: initData[label],
						next: initData[label],
						label: label
					}));
				});
				// Starts the countdown
				$example.countdown(nextYear, function(event) 
				{
					var newDate = event.strftime('%w:%d:%H:%M:%S'),
					data;
					if (newDate !== nextDate) 
					{
						currDate = nextDate;
						nextDate = newDate;
						// Setup the data
						data = {
						'curr': strfobj(currDate),
						'next': strfobj(nextDate)
						};
						// Apply the new values to each node that changed
						diff(data.curr, data.next).forEach(function(label) 
						{
							var selector = '.%s'.replace(/%s/, label),
							$node = $example.find(selector);
							// Update the node
							$node.removeClass('flip');
							$node.find('.curr').text(data.curr[label]);
							$node.find('.next').text(data.next[label]);
							// Wait for a repaint to then flip
							_.delay(function($node) {
								$node.addClass('flip');
							}, 50, $node);
						});
					}
				});
			});
		});
		</script> 
		<script type="text/template" id="main-example-template_<?php echo $contestID; ?>">
			<div class="time <%= label %>">
				<span class="count curr top"><%= curr %></span>
				<span class="count next top"><%= next %></span>
				<span class="count next bottom"><%= next %></span>
				<span class="count curr bottom"><%= curr %></span>
				<span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
			</div>
		</script>
		<div class="countdown-container" id="main-example_<?php echo $contestID; ?>"></div>




         </div>
         <div class="s_img">
          <!-- <p class="host_contest_cname"> <? echo $row1['club_name'];?></p> -->
          <p class="contest_datetime"><? echo date('M d,Y',strtotime($row1['contest_start']))." - ".date('M d,Y',strtotime($row1['contest_end']))?></p>
          <div class="contestimage1"> <img src="<?php echo $contestImage;?>"> </div>
          </div>
           
           <div class="enterContest"> <a  data-icon="&#8250;" class=" " href="view_contestent.php?cont_id=<?php echo$row1['contest_id'];?>&hostID=<?php echo $row1['host_id'];?>">Enter Here</a> </div>
          
         </div>
       </td>
       <?php 

                    							$i++;	

                    						}

						}

						else

						{

							echo "<div class='NoRecordsFound'>No Record(s) Fround!</div>";

						}

					?>
      </tr>
     </table>
    </div>
   </div>
  </div>
 </div>
</div>
<style type="text/css">
 @media only screen and (min-width:768px) {
* {
  margin: 0;
}
html, body {
  height: 100%;
}
#v2_wrapper{
  min-height: 100%; 
  margin-bottom: -378px; 
}

#v2_wrapper:after {
  content: "";
  display: block;
}
#v2_wrapper:after {
  height: 378px; 
}
#v2_footer {
  height: 378px; 
}
#v2_footer {
  height: 378px;
  position: relative;
  z-index: 2147483647;
}
 }
 
 
	.main-example {
  margin: 0 auto;
  width: 355px;
}
.main-example .countdown-container {
 
	height: 100%;
	margin: 5px 10px 0;
}
.main-example .time {
  border-radius: 5px;
  box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
  display: inline-block;
  text-align: center;
  position: relative;
  height: 30px;
  width: 40px;

  -webkit-perspective: 500px;
  -moz-perspective: 500px;
  -ms-perspective: 500px;
  -o-perspective: 500px;
  perspective: 500px;

  -webkit-backface-visibility: hidden;
  -moz-backface-visibility: hidden;
  -ms-backface-visibility: hidden;
  -o-backface-visibility: hidden;
  backface-visibility: hidden;

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);

  -webkit-transform: translate3d(0,0,0);
  -moz-transform: translate3d(0,0,0);
  -ms-transform: translate3d(0,0,0);
  -o-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}
.main-example .count {
  background: #202020;
  color: #f8f8f8;
  display: block;
  font-family: 'Oswald', sans-serif;
  font-size: 20px;
  line-height: 25px;
  overflow: hidden;
  position: absolute;
  text-align: center;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
  top: 0;
  width: 100%;

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);

  -webkit-transform-style: flat;
  -moz-transform-style: flat;
  -ms-transform-style: flat;
  -o-transform-style: flat;
  transform-style: flat;
}
.main-example .count.top {
  border-top: 1px solid rgba(255,255,255,0.2);
  border-bottom: 1px solid rgba(255,255,255,0.1);
  border-radius: 5px 5px;

/*  -webkit-transform-origin: 50% 100%;
  -moz-transform-origin: 50% 100%;
  -ms-transform-origin: 50% 100%;
  -o-transform-origin: 50% 100%;
  transform-origin: 50% 100%;*/
}
.main-example .count.bottom {
  background-image: linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -webkit-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -moz-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -ms-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -o-linear-gradient(rgba(255,255,255,0.1), transparent);
  /*border-top: 1px solid #000;*/
  /*border-bottom: 1px solid #000;*/
  /*border-radius: 0 0 5px 5px;*/
  line-height: 0;
  height: 0;
  top: 50%;

  -webkit-transform-origin: 50% 0;
  -moz-transform-origin: 50% 0;
  -ms-transform-origin: 50% 0;
  -o-transform-origin: 50% 0;
  transform-origin: 50% 0;
}
.main-example .count.next {
}
.main-example .label {
  font-size: normal;
  margin-top: 5px;
  display: block;
  position: absolute;
  top: 35px;
  width: 100%;
}
/* Animation start */
.main-example .count.curr.top {
  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  -ms-transform: rotateX(0deg);
  -o-transform: rotateX(0deg);
  transform: rotateX(0deg);
  z-index: 3;
}
.main-example .count.next.bottom {
  -webkit-transform: rotateX(90deg);
  -moz-transform: rotateX(90deg);
  -ms-transform: rotateX(90deg);
  -o-transform: rotateX(90deg);
  transform: rotateX(90deg);
  z-index: 2;
}
/* Animation end */
.main-example .flip .count.curr.top {
  -webkit-transition: all 250ms ease-in-out;
  -moz-transition: all 250ms ease-in-out;
  -ms-transition: all 250ms ease-in-out;
  -o-transition: all 250ms ease-in-out;
  transition: all 250ms ease-in-out;

  -webkit-transform: rotateX(-90deg);
  -moz-transform: rotateX(-90deg);
  -ms-transform: rotateX(-90deg);
  -o-transform: rotateX(-90deg);
  transform: rotateX(-90deg);
}
.main-example .flip .count.next.bottom {
  -webkit-transition: all 250ms ease-in-out 250ms;
  -moz-transition: all 250ms ease-in-out 250ms;
  -ms-transition: all 250ms ease-in-out 250ms;
  -o-transition: all 250ms ease-in-out 250ms;
  transition: all 250ms ease-in-out 250ms;

  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  -ms-transform: rotateX(0deg);
  -o-transform: rotateX(0deg);
  transform: rotateX(0deg);
}

</style>
<?php include('Footer.php');?>
