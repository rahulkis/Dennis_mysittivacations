<?php

include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$titleofpage=" Report";	

if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}


if(isset($_POST['updatestatusid'])){
	$sql="UPDATE `store_order_status` SET `status` = '".$_POST['val']."' WHERE `id` = ".$_POST['updatestatusid'];
   mysql_query($sql);
	$invoice=$_POST['invoice'];
	 $sql="select payer_email from purchases where invoice=".$invoice;
	 $data=mysql_query($sql);	
	 if(mysql_num_rows($data)){
	     $row=mysql_fetch_array($data)	 ;
	     $email=$data['payer_email'];
	     
		 if($_POST['val']==1){
			$msgx=" your order  has statred processing will be dispatch soon you will get a mail when it dispatch";
		 }
		 if($_POST['val']==2){
			$msgx=" your order is  complete wil be diliver to you soon ";
		 }
		 if($_POST['val']==3){
			$msgx=" your order has been cancled due to some reason, sorry for inconvenience";
		 }
		 include('order_statuschnage_email.php');
	 }
	    
   
 	
   die;
}

  /******************/


?> 

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
 	<?php  include('store_right_bar.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Report</h3>   
				<div class="store-button-div">				
				<span class="store-button-div-span">
				<a class="button btn_add_venu" href="store.php">Store</a>
				</span>
				</div>
				<?php if($_GET['msg']){ 
                           if($_GET['msg']=='d_error'){ 
					          echo '<div id="errormessage" class="NoRecordsFound message" >End date should be grater then start date .</div>';
						  }else if($_GET['msg']=='f_error'){ 
							   echo '<div id="errormessage" class="message" >Date can not be future date. </div>';
						  }
					}?>
				<form action="report_excel.php" method="POST" id="reportform">
				<div class="row">
					<span class="label">
					Start  Date
					<font color="red">*</font>
					</span>
					<span class="formw">
					<input class="reportdate" type="text" value="<? echo date("d-m-Y");?>" required="" name="eventstartDate" value="" readonly="readonly">
					<br>
					</span>
					</div>
					<div class="row">
					<span class="label">
					End Date
					<font color="red">*</font>
					</span>
					<span class="formw">
					<input class="reportdate"  value="<? echo date("d-m-Y");?>" type="text" required="" name="eventendDate" value="" readonly="readonly">
					<br>
					</span>					
					</div>
                    
                <ul class="btncenter_new">	
                	<li> <input id="getreport" class="button" type="submit"  value="Get Report" name="getreport"></li>
                </ul>
				</form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<?php include('Footer.php');?>


