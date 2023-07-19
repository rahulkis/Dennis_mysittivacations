<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

 $state_id = $_GET['state_id'];

$page = $_GET['page'];

if($page == "events")
{

	if($state_id=="-1")
	{
		$response = $id."|".$sname;
		$response;
	}
	else
	{
		if($_GET['con']=='us')
		{
		    $result = mysql_query("SELECT city_name, city_id FROM `capital_city` 
		    LEFT JOIN zone on(zone.zone_id=capital_city.state_id)
			WHERE country_id='223' ORDER BY `city_name` ASC");
		}else if($_GET['con']=='ca')
		{
		     $result = mysql_query("SELECT city_name, city_id FROM `capital_city` 
			 LEFT JOIN zone on(zone.zone_id=capital_city.state_id)
		     WHERE country_id='38' ORDER BY `city_name` ASC");
		}else 
		{
		  	$result = mysql_query("SELECT city_name, city_id FROM `capital_city` WHERE `state_id` = ".$state_id." ORDER BY `city_name` ASC");
		}
				 $id=","; 
				 $sname="Select,";
				  $num = @mysql_num_rows($result);
				  if($num > 0)
				  {
						?>
						<!-- <select name="city_name" id="city_naames" onchange="other_city_show(this.value,'<? echo $_GET['type'];?>')" > -->
						<!--<option value="">Select City</option>-->
							   <!--<option value="other">Enter Other City</option>-->
						<?php 
						 while($row = @mysql_fetch_assoc($result))
						 {
							if(!empty($row['city_name']) && strlen($row["city_name"]) > 2)
							{

							?>
						   
						 <option value="<?php echo $row['city_id'];  ?>"><?php echo $row['city_name'];  ?></option>
						 <? }} ?>
						 <!-- </select > -->
						 
				 <? }else{ ?>
				   <!-- <select name="city_name" id="city_naamesss" onchange="other_city_show(this.value,'<? echo $_GET['type'];?>')" > -->
				  <option value="">Select City</option>
					 <option value="other">Enter Other City</option>
					  <!-- </select > -->
				 <!-- <option value="other">Enter Other City</option>-->
				<?php } 
				  
 	}
}
else
{

if($state_id=="-1")
{
	$response = $id."|".$sname;
	$response;
}
else
{
	if($_GET['con']=='us')
	{
	    $result = mysql_query("SELECT DISTINCT(`city_name`), city_id FROM `capital_city` WHERE `state_id` = '223' ORDER BY `city_name` ASC");
	}else if($_GET['con']=='ca')
	{
	     $result = mysql_query("SELECT DISTINCT(`city_name`), city_id FROM `capital_city` WHERE `state_id` = '38' ORDER BY `city_name` ASC");
	}
	else if($_GET['con']=='esp')
	{
	     $result = mysql_query("SELECT DISTINCT(`city_name`), city_id FROM `capital_city` WHERE `state_id` = '245' ORDER BY `city_name` ASC");
	}else 
	{
	  	$result = mysql_query("SELECT city_name, city_id FROM `capital_city` WHERE `state_id` = ".$state_id." ORDER BY `city_name` ASC");
	}
			 $id=","; 
			 $sname="Select,";
			  $num = @mysql_num_rows($result);
			  if($num > 0)
			  {
					?>
					<select name="city_name" id="city_naames" onchange="other_city_show(this.value,'<? echo $_GET['type'];?>')" >
					<option value="">--Select City--</option>
						  
					<?php 
					 while($row = @mysql_fetch_assoc($result))
					 {
						if(!empty($row['city_name']) && strlen($row["city_name"]) > 2){
						?>
					   
					 <option value="<?php echo $row['city_id'];  ?>"><?php echo $row['city_name'];  ?></option>
					 <? }} ?>
					 </select >
					 
			 <? }else{ ?>
			   <select name="city_name" id="city_naamesss" onchange="other_city_show(this.value,'<? echo $_GET['type'];?>')" >
			  <option value="">Select City</option>
				 <option value="other">Enter Other City</option>
				  </select >
			 <!-- <option value="other">Enter Other City</option>-->
			<?php } 
			  
 	}
}
?>
