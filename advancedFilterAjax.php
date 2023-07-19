<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
require_once("admin/paging.php");
$mainCats = $_POST['maincats'];
$subCats = $_POST['subcats'];

$implodedMainCat = implode(",", $mainCats);

if(isset($_POST['subcats']) && !empty($_POST['subcats']))
{
	$implodedSubCat = implode(",", $subCats);	
}




function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
// echo $lat1."<br />";
// echo $lat2."<br />";
// echo $lon1."<br />";
// echo $lon2;
// exit;
// $nan = acos($lat1);

// var_dump($nan, is_nan($nan));
// exit;


	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if ($unit == "K") 
	{

		$d_cal = $miles * 1.609344;
		$val = round($d_cal , 2);
		return $val;
	} 
	else if ($unit == "N") 
	{
		$d_cal = $miles * 0.8684;
		$val = round($d_cal , 2);
		return $val;
	} 
	else 
	{
		$val = round($miles , 2);
		return $val;
	}
}



if(isset($_POST['longitude']))
{
	$currentCitylong = $_POST['longitude'];
	$currentCitylat = $_POST['latitude'];
	$miles = $_POST['miles'];

	if(isset($_POST['searchstring']))
	{
		$string = trim($_POST['searchstring']);
		if(!empty($string))
		{
			$getAllArtists = mysql_query('SELECT * FROM `clubs` as `c`
							WHERE `c`.`type_of_club` IN ('.$implodedMainCat.')
							AND `c`.`club_name` LIKE "%'.$string.'%"
							ORDER BY `id` ASC ');
		}
		else
		{
			$getAllArtists = mysql_query("SELECT * FROM `clubs` as `c`
						WHERE `c`.`type_of_club` IN ($implodedMainCat)
						ORDER BY `id` ASC ");
		}
	}
	else
	{
		$getAllArtists = mysql_query("SELECT * FROM `clubs` as `c`
						WHERE `c`.`type_of_club` IN ($implodedMainCat)
						ORDER BY `id` ASC ");
	}

	
	//echo distance(33.7828349, -84.3837164, 33.7828349, -84.3837164, "M"); exit;
	while($search = mysql_fetch_assoc($getAllArtists))
	{
		if(!empty($search['latitude']) && $search['latitude'] != '00.000000')
		{
			$distancemiles = distance($currentCitylat, $currentCitylong, $search['latitude'], $search['longitude'], "M");
			$type_details_of_club = $search['type_details_of_club'];
			foreach($subCats as $category)
			{
				$category = trim($category);
				if (preg_match("/\b$category\b/i", $type_details_of_club)) 
				{
					if($distancemiles <= $miles) 
					{ 
						$HostIdArray[] = $search['id'];
					}
				} 
			}
		}		
	}
	//echo "<pre>"; print_r($HostIdArray); exit;


}
else
{

	if(isset($_POST['searchstring']))
	{
		$string = trim($_POST['searchstring']);
		if(!empty($string))
		{
			// echo 'SELECT * FROM `clubs` as `c`
			// 				WHERE `c`.`type_of_club` IN ('.$implodedMainCat.')
			// 				AND `c`.`club_name` LIKE "%'.$string.'%"
			// 				ORDER BY `id` ASC '; die;
			$getAllArtists = mysql_query('SELECT * FROM `clubs` as `c`
							WHERE `c`.`type_of_club` IN ('.$implodedMainCat.')
							AND `c`.`club_city` = "'.$_SESSION['id'].'"
							AND `c`.`club_name` LIKE "%'.$string.'%"
							ORDER BY `id` ASC ');
		}
		else
		{
			$getAllArtists = mysql_query("SELECT * FROM `clubs` as `c`
						WHERE `c`.`type_of_club` IN ($implodedMainCat)
						AND `c`.`club_city` = '$_SESSION[id]'
						ORDER BY `id` ASC ");
		}
	}
	else
	{
		$getAllArtists = mysql_query("SELECT * FROM `clubs` as `c`
						WHERE  `c`.`club_city` = '$_SESSION[id]'
						AND `c`.`type_of_club` IN ($implodedMainCat)
						ORDER BY `id` ASC ");
	}

	while($search = mysql_fetch_assoc($getAllArtists))
	{
		$type_details_of_club = $search['type_details_of_club'];
		if(isset($_POST['subcats']) && !empty($_POST['subcats']))
		{		
			foreach($subCats as $category)
			{
				$category = trim($category);
				if (preg_match("/\b$category\b/i", $type_details_of_club)) 
				{
					$HostIdArray[] = $search['id'];
				} 
			}
		}
		else
		{
			$HostIdArray[] = $search['id'];
		}
	}
}


unset($_SESSION['MAINCAT']);
 // echo "<pre>"; print_r($HostIdArray);exit;
$_SESSION['MAINCAT'] = $mainCats;


// echo "<pre>"; print_r($implodedMainCat); echo "<br />"; print_r($implodedSubCat); die;

$newArray = array_unique($HostIdArray);
$getresult = implode(",", $newArray);
$sql  = "SELECT * FROM `clubs` as `c`
		WHERE `c`.`club_city` = '$_SESSION[id]'
		AND `c`.`id` IN ($getresult)
		ORDER BY `id` ASC ";

// $_SESSION['FilterSQL'] = $sql;
$get_search_results12 = mysql_query($sql);
  
$count_clubs_res = mysql_num_rows($get_search_results12);


$rowCount = 0;
$total = 0;
$total = $count_clubs_res;
if(isset($_POST['page']))
{
	$page = $_POST['page'];
}
else
{
	$page = '1';
}
$limit = '30';  //limit
$i=$limit*($page-1);

$pager = Pager::getPagerData($total, $limit, $page);
$offset = $pager->offset;
$limit  = $pager->limit;
$page   = $pager->page;
$sql = $sql . " limit $offset, $limit";
$get_search_results  = mysql_query($sql);
if($count_clubs_res > 0)
{
	while($s_row = mysql_fetch_assoc($get_search_results))
	{
	?>
		<li>
			<div class="results_listing listings_filter_search">
				<div class="hotListing">
					<div class="filter_post_left">
						<div class="content width_100" id="forumcontent">
						<?php 
							if(!empty($s_row['image_nm']))
							{ 
						?>
								<a href="<?php echo $s_row['image_nm']; ?>" rel="lightbox"> <img src="<?php echo $s_row['image_nm']; ?>" alt=""> </a>
						<?php 	}
							else
							{ 
								//$nm = rand(91,100);
						?>
								<img src="/hot_spots/<?php echo $s_row['type_of_club'].".jpg"; ?>">
						<?php 	} ?>
						</div>
					</div>
					<div class="filter_post_right">
						<h1>
			<?php 
							$checkClaimHost = mysql_query("SELECT * FROM `claimhosts` WHERE `claim_host_id` = '$s_row[id]' ");
							if(mysql_num_rows($checkClaimHost) > 0 || $s_row['non_member'] == '0')
							{
			?>
								<a style="cursor:pointer;" href="host_profile.php?host_id=<?php echo $s_row['id']; ?>">
			<?php 				}
							else
							{
			?>
								<a style="cursor:pointer;" target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">
			<?php 				}
								echo $s_row['club_name']; ?>
								</a> 
						</h1>
						<div class="location">
							<p><span><?php echo $s_row['club_address']; ?></span><br>
			<?php
							$exp_club_details = explode(',' , $s_row['type_details_of_club']);
							$imp_club_details = implode(', ' , $exp_club_details);
							//echo $imp_club_details;
			?>
							</p>
							<p><a target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">Map</a></p>
							<div style="clear:both"></div>
						</div>
					</div>
				</div>
			</div>
		</li>
	<?php 
	} // ENDWHILE

	$search_string = "";
	echo '&pagination&';
			echo "<a href='javascript:void(0);' onclick='ajaxPagination(1);'><span title='First'>&laquo;</span></a>";
			if ($page <= 1)
			{
				//echo "<span>Previous</span>";
			}
			else            
			{
				$prevPage = $page-1;
				//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Previous</span></a>";
				echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$prevPage.")'><span>Previous</span></a>";
				//echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Previous</span></a>";
			}
			echo "  ";
			
			
			for($x = max(1, $pager->page - 5); $x <= min($pager->page + 5, $pager->numPages); $x++){
			
			
			//for ($x=1;$x<=$pager->numPages;$x++){
				echo "  ";
				if ($x == $pager->page)
				{
					echo "<span class='active'>$x</span>";
				}
				else
				{
					echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$x.");'><span>".$x."</span></a>";
				}
				// echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>".$x."</span></a>";
			}
			if($page == $pager->numPages) 
			{
				//echo "<span>Next</span>";
			}
			else
			{           
				$nextPage = $page+1;
				// echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Next</span></a>";
				echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$nextPage.");'><span>Next</span></a>";
			}
			$totalPages = $pager->numPages;
			//echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span title='Last'>&raquo;</span></a>";
			echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$totalPages.");'><span title='Last'>&raquo;</span></a>";
}
else
{
	?>
	<li style="float: left;
line-height: 5;
text-align: center;
width: 98%;">
			<div class="results_listing listings_filter_search">
				<div class="hotListing">
					<h3 id="advancedNorecords">No Results Found.</h3>
				</div>
			</div>
		</li>&pagination&
	<?php
}