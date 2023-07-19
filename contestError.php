<h1 id="title">You Have already Entered this Contest!</h1>
<?php 
$cntid = $_POST['id'];
$redirect = $_POST['redirect'];
?>
<input type="button" value="Go Back" class="button" onclick="window.location.href = '<?php echo $redirect; ?>'" />