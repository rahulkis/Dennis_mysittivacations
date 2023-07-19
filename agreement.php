<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>

<?php
    $sql = "select * from `pages` where page_id = '8'";
    $policyArray = $Obj->select($sql) ; 
    $policy=$policyArray[0]['page_data'];
    $policyname=$policyArray[0]['page_name'];
    $cid = $_POST['contid'];
	
	$rules_query = @mysql_query("SELECT contest_rule FROM contest WHERE contest_id = '$cid'");
	$get_rules = mysql_fetch_assoc($rules_query);
	
	
	
    if(isset($_POST['redirect']))
    {
        //$cid = $_POST['contid'];
        $redirect = "challenge.php?cont_id=".$cid ;
    }
    elseif (isset($_POST['redirect1'])) {
      # code...
        $redirect = $_POST['redirect1'];
    }
    else
    {
        $redirect = "mysitti_contests.php?contid=".$cid ;   
    }


 ?>
    
		
        <div id="wrapper" class="space">
              
                   <div class="content1" style="margin:0px;">
 <div id="title" style="border-bottom: 1px solid #808080;
    color: #FECD07;
    font-size: 17px;
    height: 42px;
    width: 100%;">Contest Rules</div>
                       <div class="content_txt" style=" color: #D4D4D4 !important;">
                         <p><?php echo nl2br($get_rules['contest_rule']); ?></p>
                       </div>
                   </div>
               </div>
               <div class="agreebuttons">
                  <input type="button" class="button" value="Agree" onclick="confirmagree('Agree','<?php echo $redirect; ?>');" />&nbsp;&nbsp;&nbsp;
                  <input type="button" class="button" value="DisAgree" onclick="confirmagree('DisAgree','<?php echo $redirect; ?>');" style="float: right;"/>
               </div>
               <script type="text/javascript">
                  function confirmagree(val,red)
                  {

                    if(val == "Agree")
                    {
                      $('#popup2').fadeOut('slow');
                      $('.b-modal').css('display','none');
                    }
                    else
                    {
                      window.location = red;
                    }
                  }
               </script>
          

