<?php
//exit;
include("Query.Inc.php");
$Obj = new Query($DBName);
/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/
$userID = $_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
if(isset($userID))
{
//include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}

if(isset($_REQUEST['id'])){
	$userID=$_REQUEST['id'];
}
else {
$userID=$_SESSION['user_id'];	

 if(isset($_POST['delete_photo']))
		{
			  $ids=implode(",",$_POST['delete_photo']);
			 $del=mysql_query("delete from uploaded where img_id IN(".$ids.")");
			  if($del)
			  {	
			  	   $_SESSION['success']="Images deleted successfully";
				  //header('location:upload_photo.php'); exit;
			  }
		}
}
//include('header_start.php');
?>
<script>
function validate_image()
{
	if(document.getElementById('image_file').value== "" )
	 {
		alert( "Please provide image!" );
		document.getElementById('image_file').focus() ;
		return false;   
	}
alert(getExtension(document.getElementById('image_file').value).toLowerCase());
    var ext = getExtension(document.getElementById('image_file').value).toLowerCase();
	if(ext!='jpg'|| ext!='gif'|| ext!='bmp'||ext!='png')
	{
		alert( "Please valid image!" );
		document.getElementById('image_file').focus() ;
		return false;
	}
}
</script>

<script language="javascript" type="text/javascript">
var xmlhttp;
function ajaxFunction(url,myReadyStateFunc)
{ 
   if (window.XMLHttpRequest)
   { 
      // For IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   }
   else
   {
      // For IE5, IE6
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange= myReadyStateFunc;        // myReadyStateFunc = function
   xmlhttp.open("GET",url,true);
   xmlhttp.send();
}

//******************* Image Like Unlike
//function like_unlike(like,img_id,who_like_id,img_user_id)
//{
//	
// ajaxFunction("like_unlike.php?action="+like+"&img_id="+img_id+"&who_like_id="+who_like_id+"&img_user_id="+img_user_id ,function()
//    { 
//        if (xmlhttp.readyState==4 && xmlhttp.status==200)
//        {
//               var s = xmlhttp.responseText;
//			   s=s.split("|");
//               Divid = s[1];
//			   alert("likeDiv_"+Divid);
//			   matter=s[0];
//			  
//			 //document.getElementById("likeDiv_"+img_id).innerHTML = 'unlike';
//        }
//	});
//}

//*************************
</script>
  

</head>


 
 
 

<script>
	 

  $(document).ready(function() {
       
      
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
 

</script>	
	 <div class="home_wrapper">

<script type="text/javascript" src="http://www.adipalaz.com/scripts/jquery/jquery.nestedAccordion.js"></script>
<script type="text/javascript">
 
$.fn.accordion.defaults.container = false; 
$(function() {
  $("#acc3").accordion({initShow: "#current"});  
   
   
});
 
</script>




 <?php $rootcat =  mysql_query("SELECT * FROM host_category  WHERE status = 1"); ?>
<ul id="acc3" class="accordion">
	 
  <?php while($rootcatt = mysql_fetch_array($rootcat)){  ?>	
     	 <li><a href="#"><?php echo $rootcatt['category_name'];?></a>		  
       <?php  $child1 =  mysql_query("SELECT * FROM host_category_parent WHERE parent_id =".$rootcatt['id']." and  status = 1");?>
                   <ul>
		  	<?php   while($child11 = mysql_fetch_array($child1)){ ?>
                       <li><a href="#">--<?php echo $child11['category_name'];?></a>		
				    			  
		<?php $child2 =  mysql_query("SELECT * FROM host_category_parent2 WHERE parent_id =".$child11['id']." and  status = 1"); ?>
                                     <ul>
					<?php  while($child22 = mysql_fetch_array($child2)){ ?>
                                               <li><a href="#">----<?php echo $child22['category_name'];?></a> </li>		 
						  
					<?php  } ?>
                                      </ul> 
                        </li>
			<?php  }?>
                     </ul> 
        </li>
		 
	<?php } ?>
 </ul>

	 
     
     
      </div>  

 
 
    <?php include('footer.php') ?>

<?php
}
else
{
$Obj->Redirect("index.php");
}
?>
