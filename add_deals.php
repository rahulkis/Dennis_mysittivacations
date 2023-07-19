<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Deals"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
?>
<style type="text/css">	
	#submit_btn1 {
    width: 100%;
    overflow: hidden;
    text-align: center;
}
#submit_btn1 {
    width: 300px!important;
    text-align: center;
    margin: 20px auto!important;
}
#middle {
    min-height: 913px!important;
    }
    #middle1 {
    width: 455px;
    min-height: 600px;
    overflow: hidden;
    margin: 30px 10px 0 10px;
    border: 1px solid #d1cfcf;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    float: left;
}

</style>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({
			selector:'textarea',
			toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
			fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
			menubar: false
		});</script>
<link href="https://mysitti.com/css/style.css" rel="stylesheet" type="text/css">


?>
<div class="random">
<div class="v2_content_wrapper ">
<?php
if(isset($_POST['add'])){
		$tittle = $_POST['tittle'];
		$short = mysql_escape_string($_POST['short_desc']);
		//$file = $_FILES['file'];
		$link = $_POST['link'];
		$content = mysql_escape_string($_POST['content']);
	      $errors= array();
	      $file_name = $_FILES['file']['name'];
	      $file_size =$_FILES['file']['size'];
	      $file_tmp =$_FILES['file']['tmp_name'];
	      $file_type=$_FILES['file']['type'];
	      $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
	      
	      $extensions= array("jpeg","jpg","png");
	      
	      if(in_array($file_ext,$extensions)=== false){
	         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	      }
      
	      if(empty($errors)==true){
	         move_uploaded_file($file_tmp,"randon_deals/".$file_name);
	      
				$ValueArray = array($tittle, $file_name, $link, $short, $content, '1');
				$FieldArray = array('tittle', 'image', 'link', 'short_desc', 'content', 'status');
				$Success = $Obj->Insert_Dynamic_Query('random_deals', $ValueArray, $FieldArray);
				echo "add Successfully";
	      }else{
	         print_r($errors);
	      }
   }

if(isset($_POST['add_adv'])){
		$adv_link = $_POST['adv_link'];
		$content = mysql_escape_string($_POST['content']);
	      $errors= array();
	      $file_name = $_FILES['advertise_img']['name'];
	      $file_size =$_FILES['advertise_img']['size'];
	      $file_tmp =$_FILES['advertise_img']['tmp_name'];
	      $file_type=$_FILES['advertise_img']['type'];
	      $file_ext=strtolower(end(explode('.',$_FILES['advertise_img']['name'])));
	      
	      $extensions= array("jpeg","jpg","png");
	      
	      if(in_array($file_ext,$extensions)=== false){
	         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	      }
      
	      if(empty($errors)==true){
	         move_uploaded_file($file_tmp,"randon_deals/".$file_name);
	      
				$ValueArray = array($file_name, $adv_link, '1');
				$FieldArray = array('image_url', 'image_link', 'status');
				$Success = $Obj->Insert_Dynamic_Query('add_advertisement', $ValueArray, $FieldArray);
				echo "add Successfully";
	      }else{
	         print_r($errors);
	      }
   }
?>
	<div class="row">
	<!--left-->
		<div id="middle" style="margin-right:50px; border:hidden;width:900px; height:100%;">
                              	<h1 style= "text-align: center; font-size: 20px "> Deals </h1>
                  
                        <form name="update_user" method="post" enctype="multipart/form-data">
                        	<div class="login">   
                            <div id="profile_box">
                            <ul>
                            <li> Tittle:</li>
                            <li><input name="tittle" type="text" value=""></li>
                            </ul>
                            <ul>  
                            <li>Short Description:</li>
                            <li><textarea name="short_desc"></textarea></li>
                            </ul>
                            <ul>  
                            <li>Upload Image:</li>
                            <li><input name="file" type="file"></li>
                            </ul>
                            <ul>
                            <li>Button Link:</li>
                            <li><input name="link" type="text"></li>
                            </ul>                             <ul>  
                            <li>Content:</li>
                            <li>	<textarea name="content"></textarea></li>
                            </ul>
                         
                        </div>
                    </div>
                       <div id="submit_btn1"><input class="button" name="add" type="submit" value="Add">
                        <a href="random_deals.php"><input class="button" name="cancel" type="button" value="Cancel"></a></div>
                        </form>
     </div>

                   <div id="middle1" style="margin-right:50px; border:hidden;width:900px; height:100%;">
                   	<h1 style= "text-align: center; font-size: 20px ">Advertisement</h1>
             	 <form name="update_user" method="post" enctype="multipart/form-data" >
                        	<div class="login">   
                            <div id="profile_box">
                            <ul>  
                            <li>Upload Adv :</li>
                            <li><input name="advertise_img" type="file"></li>
                            </ul>
                            <ul>
                            <li>Adv Link:</li>
                            <li><input name="adv_link" type="text"></li>
                            </ul> 
                        </div>
                    </div>
                       <div id="submit_btn1"><input class="button" name="add_adv" type="submit" value="Add">
                        <a href="random_deals.php"><input class="button" name="cancel" type="button" value="Cancel"></a></div>
                    </form>
                    </div>
             
               
            <div id="right2">
            <div class="advertise" style="margin-top:30px; border:hidden"></div>
            <div class="advertise" style="border:hidden"></div>
            </div>
            
            </div>

	</div>
</div>
</div>

<?php
	include('LandingPageFooter.php');
 ?>