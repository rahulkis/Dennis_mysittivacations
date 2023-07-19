<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$value = $_POST['formatted2'];
	$exp = explode(",", $value);

	$cy = $exp[0];
	if($cy == "Washington") {
	$cyhy = "washington-dc";
	$cysp = "washington%20dc";
	} else {
		$cyhy = str_replace(' ', '-', strtolower($exp[0]));
		$cysp = str_replace(' ', '%20', strtolower($exp[0]));
		$tn = str_replace(' ', '', $exp[1]);
	}

$start = 0;
$limit = 15;
// 	if(isset($_GET['page']))
// 	{
// 	$page = $_GET['page'];
// 	$start = ($page-1)*$limit;
// 	}
$sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$tn."' OR state_name = '".$cy."'";
$result = mysql_query($sql);

	$nurows = mysql_num_rows($result);
	
    if($nurows > 0) {
    while($row = mysql_fetch_assoc($result))
    {

    	$html .= "<div id='games'>
    				<ul class='for-sports-list'>";
    					if(!empty($row['NBA']))
    					{

    						$string = $row['NBA'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/nba.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>NBA</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['NFL']))
    					{

    						$string = $row['NFL'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/nfl.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>NFL</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['NHL']))
    					{

    						$string = $row['NHL'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/nhl.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>NHL</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['MLB']))
    					{

    						$string = $row['MLB'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/mlb.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>MLB</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['MLS']))
    					{

    						$string = $row['MLS'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/soccer.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>MLS</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['CFL']))
    					{
    						$string = $row['CFL'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='images/football.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								<span style='display:none;'>".$array[0]."</span>
									<p>CFL</p>
								</div>
							</a>
						</li>";
						}

						if(!empty($row['Colleges']))
    					{
    						$string = $row['Colleges'];
    						$array = explode(',', $string);

						$html .= "<li>
							<a href='javascript:;' class='list-inner'>
								<div class='list-inner-top'>
									<img src='imagesNew/ncaa-logo.jpg' />
								</div>
								
								<div class='list-inner-bottom'>
								    <span style='display:none;'>".$array[0]."</span>
									<p>Colleges</p>
								</div>
							</a>
						</li>";
						}

						$html .= "</ul></div>";


								
	    	
    }
    echo $html;
    } else {

    	$html .= "<h1 class='record_not_found'>Events not found.</h1>";
    	echo $html;
    	
    }
   
    	
 //    	$total=ceil($rows/$limit);
 //    	if($rows < 0)
 //    	{
 //    	echo '<div class="pagination_new">';
	// 		if($total > 1)
	// 		{
	// 			echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
	// 			if ($page <= 1)
	// 				echo "<span>Previous</span>";
	// 			else            
	// 				echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
	// 			echo "  ";
	// 			if(!isset($_GET['page']))
	// 			{
	// 				$y = '1';
	// 			}
	// 			else
	// 			{
	// 				$y = $_GET['page'];
	// 			}

	// 			$z = '0';
	// 			$pageNumber = (int) $_GET['page'];
	// 			for ($x=$y;$x<=$total;$x++){
	// 				if($z < 9)
	// 				{
	// 					echo " ";
	// 					if ($x == 1)
	// 					{
	// 						echo "<span class='active_range'>$x</span>";
	// 					}
	// 					else
	// 					{ ?>
	 						<!-- <a href='?page=<?php// echo $x; ?>'><span class='<?php //echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php //echo $x; ?></span></a> -->
	 				<?php	//}
	// 				}
	// 				$z++;
	// 			}
	// 			if($page == $total) 
	// 				echo "<span>Next</span>";
	// 			else           
	// 				echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

	// 			echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
	// 		}
	// 	echo "</div>";
	// }
    	
?>
<script type="text/javascript">
	$(function(){
			$(".teamName").click(function(){

		    var team = $(this).text();
			if (team == '') {
              alert("Please fill city field.");
            } else {
			$.ajax({
			    url: "teamMainlisting.php",
			    type: "POST",
			    data: {
			      teamnm: team
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('article#atrl').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		  	return false;    
			}
			}); 
		}); 
	$(function(){
		$("#games").on('click','li',function (){
		    var myVar = $(this).find('.list-inner-bottom p').text();
		    var geodemo = $('.formatted_geocontrast').val();
		    $.ajax({
                type: 'POST',
                url: 'teamMainlisting.php',
                data: {manyTeam: myVar, formatedcity: geodemo},
                beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
                success: function(data) {
		            $('article#atrl').html(data);
		            $("#loader").removeClass("loading");
		        }
         });
		});
	});
</script>