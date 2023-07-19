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
				ajaxFunction("getstate.php?country_id="+x, function()
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
			
			function getcity(x)
			{
				$.get('getcity.php?state_id='+x, function(data) {
				$('#city_name').html(data);
				});
			}
			function getcity_profile(x)
			{
				$.get('getcity.php?state_id='+x, function(data) {
				$('#city_name_profile').html(data);
				});
			}
    

			function validate_country()
			{
				if( document.user_serach.country.value== "" )
				{
					alert( "Please provide country!" );
					document.user_serach.country.focus() ;
					return false;   
				}	
			}
        
		$(document).ready(function() {	
			
			//select all the a tag with name equal to modal
			$('a[name=modal]').click(function(e) {
			//Cancel the link behavior
			e.preventDefault();
			
			//Get the A tag
			var id = $(this).attr('href');
			
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			
			//Set heigth and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//transition effect		
			$('#mask').fadeIn(1000);	
			$('#mask').fadeTo("slow",0.8);	
			
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
			
			//Set the popup window to center
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);
			
			//transition effect
			$(id).fadeIn(2000); 
			
			});
			
			//if close button is clicked
			$('.window .close').click(function (e) {
			//Cancel the link behavior
			e.preventDefault();
			
			$('#mask').hide();
			$('.window').hide();
			});		
			
			//if mask is clicked
			$('#mask').click(function () {
			$(this).hide();
			$('.window').hide();
			});			
			
			$(window).resize(function () {
			
			var box = $('#boxes .window');
			
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			
			//Set height and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
			
			//Set the popup window to center
			box.css('top',  winH/2 - box.height()/2);
			box.css('left', winW/2 - box.width()/2);
			
			});
			
			});
			
			
			// JavaScript Document
$(document).ready(function() {
$('li.category').addClass('minusimageapply');
//$('li.category').children().addClass('selectedimage');
$('li.category').children().show();
$('li.category').each(
function(column) {
$(this).click(function(event){
if (this == event.target) {
if($(this).is('.plusimageapply')) {
$(this).children().show();
$(this).removeClass('plusimageapply');
$(this).addClass('minusimageapply');
}
else
{
$(this).children().hide();
$(this).removeClass('minusimageapply');
$(this).addClass('plusimageapply');
}
}
});
}
);
});
    