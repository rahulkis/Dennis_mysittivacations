<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}


$titleofpage=" List Category";

include('header_start.php');
include('header.php');
include('headerhost.php');
?>
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
<?
function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}/*
$rows = array(
    array(
        'id' => 33,
        'parent_id' => 0,
    ),
    array(
        'id' => 34,
        'parent_id' => 0,
    ),
    array(
        'id' => 27,
        'parent_id' => 33,
    ),
    array(
        'id' => 17,
        'parent_id' => 27,
    ),
);
$tree = buildTree($rows);
echo "<pre>";
print_r( $tree );die;*/
?>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script> 
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Edit Category</h2>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
					<?
					$asd=array();
					$i=0;
					$sql="SELECT host_category.id ,host_category_parent.parent_category_id FROM `host_category` join `host_category_parent` on host_category.host_id=42 and host_category_parent.category_id=host_category.id ";
					$data=mysql_query($sql);
					while($row=mysql_fetch_array($data)){
						  $asd[$i]['id']=$row['id'];
						  $asd[$i]['parent_id']=$row['parent_category_id'];$i++;
						}
						$tree = buildTree($asd);
echo "<pre>";
//print_r( $tree );
						echo "<pre>";
						//print_r($asd);
						foreach($tree as $asds){
							print_r($asds);
						}
						die;
					?>

		 </div>
		 

 </div>
 <?
if($_SESSION['user_type'] != 'user')
    		{
    			include('club-right-panel.php');
    		}
    		else
    		{
    			 include('friend-right-panel.php');
    		}
?>
   
  </div>
</div>
<?
include('footer.php');
?>

<script>

function delrecoreds(id)
{
	 
  if(confirm('Are You sure You want to delete this record'))
  {
	  
	 $.get( "deletecategory.php?id="+id, function( data ) {
		window.location='manage_category.php';
		});
  }
   else
   {
	
	}

}
</script>
<script language="javascript">	
 function cancelEdit(){
   window.location='manage_category.php'
 }
</script>
