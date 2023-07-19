<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if($_SESSION['user_type'] == "user"){
$Obj->Redirect("home_user.php");
}

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);

$titleofpage="Pass Detail";

    $userID = $_SESSION['user_id'];
	/******************/
?>



									<table>
									<thead>
									<tr bgcolor="#ACD6FE">
                                        <th>Pass Name</th>
										<th>User Name</th>
										<th>Pass Redeem Date</th>
									</tr>
									</thead>
									<tbody>
										<?php
											
											$get_redeems = @mysql_query("SELECT redeem_date,user_id FROM downloadpasses WHERE host_id='".$_GET['u_id']."' AND pass_id='".$_GET['p_id']."' AND status = '1'");
											$count_Redeems = mysql_num_rows($get_redeems);
											

																while($row = mysql_fetch_assoc($get_redeems)){
																
																$get_userdata = mysql_query("SELECT first_name, last_name, profilename FROM user WHERE id = '".$row['user_id']."'");
																$get_u_data = mysql_fetch_assoc($get_userdata);
																?>

																<tr <?php echo $class;?>>
																
                                                                    <td><?php echo $_GET['p_name']; ?></td>
                                                                
																	<?php if(empty($get_u_data['profilename'])){ ?>
																	
																		<td><?php echo $get_u_data['first_name'].$get_u_data['last_name']; ?></td>
																	
																	<?php }else{ ?>
																	
																		<td><?php echo $get_u_data['profilename']; ?></td>
																	
																	<?php } ?>
                                                                    
																	<td><?php echo date('F j, Y l h:i:s A', strtotime($row['redeem_date'])); ?></td>
																</tr>										
															
															<?php  } ?>

									</tbody>
									</table>


<?php
$file="Report.xls";
//$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
//echo $test;
?>