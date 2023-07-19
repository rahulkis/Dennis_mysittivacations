<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

if($_GET['type']=='private')
{
	$type=$_GET['type'];
}else
{
	$type='public';
}

	if(isset($_GET['id']))
	{
		$result1 = mysql_query("SELECT u.first_name,u.last_name,u.id,u.image_nm FROM   chat_users_groups as cg 
		left join user as u on(u.id=cg.user_id) where cg.group_id='".$_GET['id']."' AND cg.user_id!='".$_SESSION['user_id']."' group by cg.user_id ");
	
		$gname=@mysql_query("select * from  chat_groups where id=".$_GET['id']."");
		$group_dtl=@mysql_fetch_assoc($gname);
	}
	

		
		
	if(isset($_POST['delete'])){
		
		if(count($_POST['del_id']) > 0)
			{
				
				$delete_ids = array_filter($_POST['del_id']);
				$ids=implode(",", $delete_ids);
				$sql_del=mysql_query("delete from  chat_users_groups where  group_id='".$_GET['id']."' AND  user_id IN(".$ids.")");
				if($sql_del)
				{	
					$_SESSION['success']="Friend deleted successfully";
					header('location: group_list.php?id='.$_GET['id']); exit;
				}
			}
		
	}		
		
		


?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<script src="js_validation/add_contest.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="css/v2style.css" />
<link type="text/css" rel="stylesheet" href="css/responsive.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js_validation/add_contest.js" type="text/javascript"></script>
<script>
$(function() {
	 <?php 
	 	$sql_dis=mysql_query("select DISTINCT(u.id),u.first_name,u.last_name,u.profilename from user as u left join friends as f on(f.friend_id=u.id) where f.user_id='".$_SESSION['user_id']."'"); 
	  	$i=0;
		while($rs=@mysql_fetch_assoc($sql_dis)) 
		{
			if(!empty($rs['first_name']) || !empty($rs['profilename']))
			{
				$val[$i]['id']=$rs['id'];
				if(!empty($rs['first_name']))
				{
					$val[$i]['label']=$rs['first_name']." ".$rs['last_name'];	
				}
				elseif(!empty($rs['profilename']))
				{
					$val[$i]['label']=$rs['profilename'];
				}
				
				$i++;
			}
		}
		$js_array = json_encode($val); 
	?>
		var availableTags = <?php echo $js_array ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt2').val($('#txt2').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
	});

function confirm_delete()
{

	var r = confirm("Are you sure want to delete!");
	if (r == true) {
		return true;
	} else {
		return false;
	}
	
}		
</script>
<style type="text/css">
table.display tr {
	background: none repeat scroll 0 0;
	color:#fff;
}
</style>
<?php
   if(isset($_POST['add_HostContest']))
  {			
			if(isset($_POST['user_id']))
			{
			   $users= explode(",",$_POST['user_id']) ;
			   for($i=0;$i<count($users)-1;$i++)
			   {
					  $user_id = $_SESSION['user_id'];
					$ThisPageTable='chat_users_groups';
					$ValueArray = array($_GET['id'],$users[$i]);	
					$FieldArray = array('group_id','user_id');
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
			   }
			 }	  
			
			if($Success > 0)
			{
					header('Location: group_list.php?id='.$_GET['id']); exit;
			}
}

if($_REQUEST['id'])
{
 $sql_sel=mysql_query("select * from  chat_groups where id='".$_GET['id']."'");
 $get_dtl=@mysql_fetch_assoc($sql_sel);
}
?>
<div id="modal" class="popupContainer popupContainer v2_addgroup_modal">
  <div class="v2_add_group_wrapper">
    <form name="shout_frm" id="shout_frm" method="post" onsubmit="return confirm_delete();">
      <header class="popupHeader">
        <h3 id="title"><?php echo $group_dtl['group_name']; ?>
          <input class="button" name="delete" type="submit" value="Delete" id="submit3" style="float:right;" /><br /></h3>
          <div style="clear:both"></div>
      
      </header>
      
      <!-- Social Login -->
      <table class="v2_group_lst" id="example" >
        <thead>
          <tr bgcolor="">
            <th></th>
            <th align="right"> </th>
          </tr>
        </thead>
        <tbody>
          <? if(@mysql_num_rows($result1) > 0){
				while($row1 =@mysql_fetch_array($result1))
				{ ?>
          <tr>
            <td><? if($row1['image_nm']){ ?>
              <img height=25 width=25 src='<?php echo $row1['image_nm'];?>'>
              <?php }else { ?>
              <img height=25 width=25 src='images/no_image.jpg'>
              <?php } ?>
              &nbsp; <?php echo $row1['first_name'].' '.$row1['last_name'] ?></td>
            <td align="right"><input type="checkbox" name="del_id[]" value="<?php echo $row1['id'];?>" ></td>
          </tr>
          <? }
				}else
				{ ?>
          <tr>
            <td class="nouser_error"> No users found in group</td>
          </tr>
          <? }
			?>
        </tbody>
      </table>
    </form>
    <div class="popupBody add_grp_poup_body">  
      <div class="user_register">
        <form name="add_contest" onsubmit="return validate_contest1();"  method="post"  enctype="multipart/form-data">
          <label>Add User:</label>
          <textarea name="group_name" id="search_val"  ></textarea>
          <input type="hidden" name="user_id" id="txt2">
          <div id="submit_btn" class="glist_btns">
            <input class="button" name="add_HostContest" type="submit" value="Add User" id="submit3" />
            <input style="width:120px !important" name="exit" type="button" class="button" value="Exit" onclick="javascript:self.close();" id="exit" />
          </div>
          <input type="hidden" value="<?php echo $_GET['id']; ?>" name="edit_id">
        </form>
      </div>
    </div>
  </div>
</div>
