<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

 $state_id = $_GET['state_id'];
if($state_id=="-1")
{
 $response = $id."|".$sname;
  $response;
}
else
{
 
  $result = mysql_query("SELECT DISTINCT(`city_name`), city_id FROM `capital_city` WHERE `state_id` = ".$state_id." ORDER BY `city_name` ASC");
 $id=","; 
 $sname="Select,";
  $num = @mysql_num_rows($result);
  if($num > 0)
  {
   
   if(isset($_GET['header_search'])){
	
		 $car_arr = array();
		 while($row = @mysql_fetch_assoc($result))
		 {
		 	if(strlen($row["city_name"]) > 2 && $row["city_name"] != "" && $row["city_name"] != " ")
		 	{
		  		$car_arr[] = $row['city_name'];
		 	}
	 	}	
		 
		 echo json_encode($car_arr);	
	
	}else{
	 
	  	?>
        <option value="">--Select City--</option>
              
		<?php 
		 while($row = @mysql_fetch_assoc($result))
		 { 
		 	if(strlen($row["city_name"]) > 2 && $row["city_name"] != "" && $row["city_name"] != " ")
		 	{
		  		?>
		  		<option value="<?php echo $row['city_id'];  ?>"><?php echo $row['city_name'];  ?></option>

		  		<?php
		 	}

		 }	 
	 
	 
	}
   
   
	
  }else{ ?>
  
  <option value="">Select City</option>
    
 <!-- <option value="other">Enter Other City</option>-->
<?php } 
 }
?>