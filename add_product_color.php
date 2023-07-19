				
					<div class="row">
					<div style="display:none;"  id="color_added_ajax" class="successmessage" for="parent_category"></div>
					
					<span class="label">Color Name<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="colorname"   id="colorname"  />
					<div style="display:none;" class="errorforsignup2" for="parent_category">This field is required.</div>
					<br />
					</span>					
					</div>
					<div class="row" style="padding-top:20px;">
					<span class="formw">
					<input class="button" type="button" name="addcolor" id="addcolor" value="Save" onclick="checkformval()" >					
					</span>
					</div>
					<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 
					
<script language="javascript">	
	function checkformval(){
		if(!$("#colorname").val()){
		  $('.errorforsignup2').show();
		  return false;
		}else{
			val=$("#colorname").val();
			 $('.errorforsignup2').hide();
					$.ajax({
					type: "POST",
					url: "ajax_data_store.php",
					data:"addcolor="+val,
					success:  function(data){	
							
						 if(data){
							 $('#avblcolorsel1').append(data);	
							 $("#colorname").focus();
							  $('#color_added_ajax').html('Color added successfully');
							  $('#color_added_ajax').show();
						 }else{
							 
							 $('#color_added_ajax').html('Color already exist');
							  $('#color_added_ajax').show();
						 }
					}

					}); 

		}
		
	}
	function add_more_color_div(){
		$('#add_more_color_div_toggle').toggle();
	}
	$(document).ready(function(){
		$("#colorname").on('focus', function(){
			$('.errorforsignup').hide();
			 $('#color_added_ajax').html('');
			 $('#color_added_ajax').hide();
			});
		
		});

</script>

<style>
.errorforsignup2 {
  color: red;
  float: left;
  font-size: 13px;
  font-weight: normal;
  line-height: 22px;
  width: 100%;
}
</style>
