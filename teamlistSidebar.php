<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$value = $_POST['formatted'];
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

$sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$tn."' OR state_name = '".$cy."'";
$result = mysql_query($sql);

	$nurows = mysql_num_rows($result);
	
    if($nurows > 0) {
    while($row = mysql_fetch_assoc($result))
    {
    	
    	$html .= "<label>".$row['state_name']."</label>";
    						if(!empty($row['NBA']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>NBA</h2>
												<ul>";
												$res = explode(",", $row['NBA']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}

							if(!empty($row['NFL']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>NFL</h2>
												<ul>";
												$res = explode(",", $row['NFL']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}	
							
							if(!empty($row['NHL']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>NHL</h2>
												<ul>";
												$res = explode(",", $row['NHL']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}

							if(!empty($row['MLB']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>MLB</h2>
												<ul>";
												$res = explode(",", $row['MLB']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}

							if(!empty($row['MLS']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>MLS</h2>
												<ul>";
												$res = explode(",", $row['MLS']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}

							if(!empty($row['CFL']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>CFL</h2>
												<ul>";
												$res = explode(",", $row['CFL']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul></div>";
								}

							if(!empty($row['Colleges']))
								{
									$html .= "<div class='bar-block'>
												<h2 class='hdg'>Colleges</h2>
												<ul id='myList'>";
												$res = explode(",", $row['Colleges']);
																																		
												for ($i=0; $i < count($res); $i++) { 
													$html .= "<li class='teamName'>".$res[$i]."</li>";
												}
									$html .= "</ul>
									<div id='loadMore'>Load more</div>
									<div id='showLess'>Show less</div>
									</div>";
								}	
								
	    	
    }
    echo $html;
    } else {

    	$html .= "<h1 class='record_not_found'>Events not found.</h1>";
    	echo $html;
    	
    }
    	
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
			$(".teamName").click(function(){

		    var team = $(this).text();
			if (team == '') {
              alert("Please fill city field.");
            } else {
			$.ajax({
			    url: "teamDealSection.php",
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
				   	$('.custom-sports-slider').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		  	return false;    
			}
			}); 
		});
	$(document).ready(function () {
		      size_li = $("#myList li").size();
		      var x=5;
		      $('#myList li:lt('+x+')').show();
		      $('#loadMore').click(function () {
		          x= (x+20 <= size_li) ? x+20 : size_li;
		          $('#myList li:lt('+x+')').show();
		           $('#showLess').show();
		          if(x == size_li){
		              $('#loadMore').hide();
		          }
		      });
		      $('#showLess').click(function () {
		          x=(x-20<0) ? 5 : x-20;
		          $('#myList li').not(':lt('+x+')').hide();
		          $('#loadMore').show();
		           $('#showLess').show();
		          if(x == 5){
		              $('#showLess').hide();
		          }
		      });
		  });
</script>