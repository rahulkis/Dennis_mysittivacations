<?php 
include("../Query.Inc.php");
$Obj = new Query($DBName);
include_once 'include/functions.php';
$user = new User();
$user_id=$_GET['user_id'];
 $countrysql="select country_id,name from country where country_id IN(223,38)";
 $country_list = mysql_query($countrysql);
 
 // get user total shouts 

		   $sql_total_s="select id from user_to_content where user_id='".$_SESSION['user_id']."'  AND cont_type='shout'  group by  cont_id";	
		   $cont_total_s = mysql_query($sql_total_s);
		    $total_con_s=@mysql_num_rows($cont_total_s);  
	 	// end here 
// end here 

// get user unread shouts 

			   $sql_cnt_s="select id from user_to_content where user_id='".$_SESSION['user_id']."'  AND cont_type='shout' AND is_read='0' AND owner_id!='".$_SESSION['user_id']."' group by  cont_id";	
			   $cont_cnt_s = mysql_query($sql_cnt_s);
				$ur_con_s=@mysql_num_rows($cont_cnt_s);  
// end here 
include("an-header.php");
 ?>
<div data-role="page" id="pagefive" class="pages">

 <div data-role="header" id="header">
<div class="row">
  <div class="col-xs-3"></div>
  <div class="col-xs-6"><h1>Search</h1></div>
  <div class="col-xs-3">
   <a href="#myPopup" data-rel="popup" ><img src="img/threelineimage.png"  /> </a>
   <div data-role="popup" id="myPopup" class="ui-content" style=" background: #555555;
border-color: #555555;" >
              
<ul class="list-group" id="list-group">
  <li class="list-group-item" id="list-group-item"> 
  	<a href="https://mysitti.com/mysitti_app/an-shouts.php?user_id=<?php echo $user_id; ?>"  data-ajax="false"  data-transition="slide">(<?php echo $total_con_s; ?>) Shouts <span class="badge" id="badge"><?php echo $ur_con_s; ?></span></a>
  </li>
  <li class="list-group-item" id="list-group-item">
  	<a href="https://mysitti.com/mysitti_app/add-shout.php?user_id=<?php echo $user_id; ?>" data-ajax="false"   data-transition="slide">Shout Out</a>
  </li>
 
    <li class="list-group-item" id="list-group-item">
  	<a href="https://mysitti.com/mysitti_app/an-usergroups.php?user_id=<?php echo $user_id; ?>"  data-ajax="false"   data-transition="slide">User One Groups</a>
  </li>
  <li class="list-group-item" id="list-group-item">
  	<a href="https://mysitti.com/mysitti_app/an-userhotsot.php?user_id=<?php echo $user_id; ?>" data-ajax="false"   data-transition="slide">User One Hot Spots</a>
  </li>
</ul>          

    </div>
  </div>
</div>    
</div>

  <div data-role="main" class="ui-content" id="main-content">
<form method="GET" action="an-user-hotspot.php" id="search" data-ajax="false">
<input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'] ?>">
<fieldset class="ui-field-contain" id="form-field">      
<div class="row">
  <div class="col-xs-4"><h4>country</h4></div>
  <div class="col-xs-8">
        <select name="country" id="country" onChange="showState(this.value);">
           <option value="">Select Country</option>
       <?php  while($row = mysql_fetch_array($country_list)) { ?>
            <option value="<?php echo $row["country_id"]; ?>"><?php echo $row["name"]; ?></option>
            <?php } ?>
        </select>  
  </div>
</div>  
</fieldset>


<fieldset class="ui-field-contain" id="form-field">      
<div class="row">
  <div class="col-xs-4"><h4>State</h4></div>
 <?   $countrysql1="select zone_id,name from zone where country_id='223' and status ='1'";
   $country_list1 = mysql_query($countrysql1); ?>
  <div class="col-xs-8">
  
        <select name="state" id="state" onchange="getcity(this.value);">
          <option value="">Select State</option>
         <?php 
            while($row1 = mysql_fetch_array($country_list1))
            { ?>
            <option value="<?php echo $row1["zone_id"]; ?>"  ><?php echo $row1["name"]; ?></option>
           <?php } ?>
        </select>  
  </div>
</div>  
</fieldset>


<fieldset class="ui-field-contain" id="form-field">      
<div class="row">
  <div class="col-xs-4"><h4>City</h4></div>
  <div class="col-xs-8">
       <select class="option-1" name="city_name" id="city_name">
<option value="">------- Select -------</option>
</select>
  </div>
</div>  
</fieldset>
<h4>OR</h4>
<fieldset class="ui-field-contain" id="form-field">      
<div class="row">
  <div class="col-xs-4"><h4>Zip Code / Postal Code</h4></div>
  <div class="col-xs-8">
	<input type="text" placeholder="Zip Code" name="zipcode" id="zipcode">
  </div>
</div>  
</fieldset>

<a href="javascript:void(0)" onClick="$('#search').submit();" class="ui-btn" id="ui-btn">SEARCH</a>

</form>



    
  </div>

  <?php include('an_footer.php'); ?>
    <script>
 function getcity(x)
			{
				$.get('<?php echo SITEROOT ?>getcity.php?state_id='+x, function(data) {
				$('#city_name').html(data);
				});
			}
			

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
function showState(x)
			{
				ajaxFunction("<?php echo SITEROOT ?>getstate.php?country_id="+x, function()
				{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
				s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
				sid = s[0].split(",");  
				//  sid = [1,2,3,]
				sval = s[1].split(",");      
				//  sval = [state1, state2, state3,]
				st = document.getElementById('state');
				st.length=0; 
				for(i=0;i<sid.length-1;i++)
				{
				st[i] = new Option(sval[i],sid[i]);
				}              
				}
				});
			}
			
			


 </script>


 
