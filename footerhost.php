<section id="footer">
  <div class="content part7">
    <div class="fnav">
      <ul>
        <li><a href="#">About Us </a></li>
        <li><a href="#">Contact Us </a></li>
        <li><a href="#">Suggestion Box</a></li>
      </ul>
    </div>
    <p>Copyright 2013 mysittidev.com All Rights Reserved</p>
    <div class="media">
      <ul>
        <li><a href="#"><img src="images/fb_bottom.png" alt=""> </a></li>
        <li><a href="#"><img src="images/tw_bottom.png" alt=""> </a></li>
        <li><a href="#"><img src="images/gplus.png" alt=""> </a></li>
        <li><a href="#"><img src="images/email.png" alt=""> </a></li>
        <li><a href="#"><img src="images/youtube.png" alt=""> </a></li>
      </ul>
    </div>
  </div>
</section>
<script type="text/javascript" src="js/smk-accordion.js"></script> 
<script type="text/javascript">
		jQuery(document).ready(function($){
			
			$(".filter").smk_Accordion({
				closeAble: true, //boolean
		
			});			
		});
	</script> 
<!-- sidebar accordion js --> 
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script> 
<script type="text/javascript">
$('.photoslider1').bxSlider({
  minSlides: 2,
  maxSlides: 4,
  slideWidth: 235,
  slideMargin: 20
});
$('.photoslider1').bxSlider({
  minSlides: 2,
  maxSlides: 4,
  slideWidth: 235,
  slideMargin: 20
});
</script> 
<script>
// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('header').removeClass('nav-up').addClass('nav-down');
        }
    }
    
    lastScrollTop = st;
}
</script> 
<script src="js/viewportchecker.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.logo').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInUp', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	jQuery('.welcome').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInUp', // Class to add to the elements when they are visible
	    offset: 100    
	   });   
	   
	   jQuery('.subhead').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInUp', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   
	   jQuery('.part3').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInUp', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   
	  
	   jQuery('.part4').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated pulse', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   jQuery('.part5').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInRight', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   jQuery('.part6').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInLeft', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	    jQuery('.part7').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInRight', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   jQuery('.search').addClass("hidden").viewportChecker({
	    classToAdd: 'visible animated bounceInDown', // Class to add to the elements when they are visible
	    offset: 100    
	   }); 
	   
});            
</script>
</body>
</html>
