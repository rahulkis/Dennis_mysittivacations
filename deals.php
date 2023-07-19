<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Deals"; 
include('Header.php');	// not login

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/deals.css">

<script type="text/javascript">
$(document).ready(function() {
	$("body").on('click', '.top', function() {
		$("nav.menu").toggleClass("menu_show");
	});
	 if (window.matchMedia("(max-width: 767px)").matches)  
        { $('.incase_mobile').css('display','block');
            $('.incase_desktop').css('display','none');
        } else { 
        	$('.incase_mobile').css('display','none');
           
        } 
	    $('.menu_icon').click(function() {

	    $('html, body').animate({
	      scrollTop: $("#myCarousel").offset().top
	    }, 1000);
	})
});
</script>
<?php
function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
		$key = str_replace(' ','+',$key);
	    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	    $output= json_decode($geocode);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;
			$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
		// endif;
	else:
		if(!empty($key)):
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
		else:

			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
		endif;
	endif;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
?>
  <div class="planTap custom-isangoapi-plan">
        Planning a Vacation?<br> Plan Smarter!
      </div>

<div class="v2_content_wrapper car_rental_main container">
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
      </div>
    </div>
  </div>
<div class="random">

<div class="v2_content_wrapper ">

	<div class="row random_change">
		<?php
    if(isset($_GET['city']) && !empty($_GET['city'])){
                $rec_limit = 20;
            if( isset($_GET{'page'} ) ) {
                $page = $_GET{'page'} + 1;
                $offset = $rec_limit * $page ;
             }else {
                $page = 0;
                $offset = 0;
             }
           if($_GET['city'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
       $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
           }else{
                $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_GET['city']."%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
             $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_GET['city']."%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";        
           }
            
            $result = $mysqli->query($randon_deals);
            $resultpeek = $mysqli->query($randon_dealspeek);
         $count = $result->num_rows;
         $count2 = $resultpeek->num_rows;
         $counts = ($count + $count2);
            if($counts > 0){
                    ?>
            <section id="pinBoot">
                <?php 
                if($count > 0){


                 foreach ($result as $key => $value) {
                    foreach ($resultpeek as $keys => $values) {
                    if(!empty($values['tag'])){
                        if($keys == $key){
                        ?>
                <article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
                    <div class="PictureCard-overlay">
                        <div class="PictureCard-title"><?php echo $values['tag']; ?></div>
                        <div class="PictureCard-wrapper">
                            <div class="PictureCard-data">
                                <span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
                            </div>
                            <div class="PictureCard-menu">
                                <div>
                                    <div class="PictureCard-timebox _outbound">
                                        <div class="PictureCard-timebox-col">
                                            <span class=""><?php echo $values['title']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></a>
                </article>
            <?php           
                    }
                    }
                    }
                ?>
                <article class="white-panel vacationss"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
                    <div class="PictureCard-overlay">
                        <div class="PictureCard-title"><?php echo $value['tag']; ?></div>
                        <div class="PictureCard-wrapper">
                            <div class="PictureCard-data">
                                <span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
                            </div>
                            <div class="PictureCard-menu">
                                <div>
                                    <div class="PictureCard-timebox _outbound">
                                        <div class="PictureCard-timebox-col">
                                            <span class=""><?php echo $value['title']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></a>
                </article>
            <?php   
         } }else{
    foreach ($resultpeek as $keys => $values) {

        ?>
<article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
                    <div class="PictureCard-overlay">
                        <div class="PictureCard-title"><?php echo $values['tag']; ?></div>
                        <div class="PictureCard-wrapper">
                            <div class="PictureCard-data">
                                <span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
                            </div>
                            <div class="PictureCard-menu">
                                <div>
                                    <div class="PictureCard-timebox _outbound">
                                        <div class="PictureCard-timebox-col">
                                            <span class=""><?php echo $values['title']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></a>
                </article>
        <?php
    }

         }?>
            </section>
            <?php if($counts > 39){ ?>
                <div class="paggination_bottom">
                    <?php
                    $citysp =   $_GET['city'];
                    $city = str_replace(' ', '%20', $citysp);
                    if( $page > 0 ) {
                        $last = $page - 2;
                        echo "<a href =deals.php?city=$city&page=$last>Last 40 Records</a> |";
                        echo "<a href =deals.php?city=$city&page=$page>Next 40 Records</a>";
                    }else if( $page == 0 ) {
                        echo "<a href =deals.php?city=$city&page=$page class='dealNext' >Next 40 Records</a>";
                    }else if( $left_rec < $rec_limit ) {
                        $last = $page - 2;
                        echo "<a href =deals.php?city=$city&page=$last class='dealLast' >Last 40 Records</a>";
                    }
                    ?>
                </div>
                    <?php 
                }    } }
		
 
?>
	</div>
</div>
</div>

<script type="text/javascript">
 $('.slider-single').slick({
 	slidesToShow: 1,
 	slidesToScroll: 1,
 	arrows: true,
 	fade: false,
 	adaptiveHeight: true,
 	infinite: false,
	useTransform: true,
 	speed: 400,
 	cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
 });

 $('.slider-nav')
 	.on('init', function(event, slick) {
 		$('.slider-nav .slick-slide.slick-current').addClass('is-active');
 	})
 	.slick({
 		slidesToShow: 7,
 		slidesToScroll: 7,
 		dots: false,
 		focusOnSelect: false,
 		infinite: false,
 		responsive: [{
 			breakpoint: 1024,
 			settings: {
 				slidesToShow: 5,
 				slidesToScroll: 5,
 			}
 		}, {
 			breakpoint: 640,
 			settings: {
 				slidesToShow: 4,
 				slidesToScroll: 4,
			}
 		}, {
 			breakpoint: 420,
 			settings: {
 				slidesToShow: 3,
 				slidesToScroll: 3,
		}
 		}]
 	});

 $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
 	$('.slider-nav').slick('slickGoTo', currentSlide);
 	var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
 	$('.slider-nav .slick-slide.is-active').removeClass('is-active');
 	$(currrentNavSlideElem).addClass('is-active');
 });

 $('.slider-nav').on('click', '.slick-slide', function(event) {
 	event.preventDefault();
 	var goToSingleSlide = $(this).data('slick-index');

 	$('.slider-single').slick('slickGoTo', goToSingleSlide);
 });</script>
<script>

 $(document).ready(function() {
	$('#myCarousel').carousel({
	interval: 10000
	})
    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});
    
    
});

</script>

<script>
$("#carousel").owlCarousel({
  autoplay: true,
  lazyLoad: true,
  loop: true,
  
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 7000,
  smartSpeed: 800,
  nav: true,
  responsive: {
    0: {
      items: 1
    },

    600: {
      items: 3
    },

    1024: {
      items: 4
    },

    1366: {
      items: 4
    }
  }
});
</script>


 <script>
 $(document).ready(function() {
$('#pinBoot').pinterest_grid({
no_columns: 3,
padding_x: 5,
padding_y: 5,
margin_bottom: 100,
single_column_breakpoint: 700
});
});

;(function ($, window, document, undefined) {
    var pluginName = 'pinterest_grid',
        defaults = {
            padding_x: 5,
            padding_y: 5,
            no_columns: 3,
            margin_bottom: 100,
            single_column_breakpoint: 700
        },
        columns,
        $article,
        article_width;

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        var self = this,
            resize_finish;

        $(window).resize(function() {
            clearTimeout(resize_finish);
            resize_finish = setTimeout( function () {
                self.make_layout_change(self);
            }, 11);
        });

        self.make_layout_change(self);

        setTimeout(function() {
            $(window).resize();
        }, 500);
    };

    Plugin.prototype.calculate = function (single_column_mode) {
        var self = this,
            tallest = 0,
            row = 0,
            $container = $(this.element),
            container_width = $container.width();
            $article = $(this.element).children();

        if(single_column_mode === true) {
            article_width = $container.width() - self.options.padding_x;
        } else {
            article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
        }

        $article.each(function() {
            $(this).css('width', article_width);
        });

        columns = self.options.no_columns;

        $article.each(function(index) {
            var current_column,
                left_out = 0,
                top = 0,
                $this = $(this),
                prevAll = $this.prevAll(),
                tallest = 0;

            if(single_column_mode === false) {
                current_column = (index % columns);
            } else {
                current_column = 0;
            }

            for(var t = 0; t < columns; t++) {
                $this.removeClass('c'+t);
            }

            if(index % columns === 0) {
                row++;
            }

            $this.addClass('c' + current_column);
            $this.addClass('r' + row);

            prevAll.each(function(index) {
                if($(this).hasClass('c' + current_column)) {
                    top += $(this).outerHeight() + self.options.padding_y;
                }
            });

            if(single_column_mode === true) {
                left_out = 0;
            } else {
                left_out = (index % columns) * (article_width + self.options.padding_x);
            }

            $this.css({
                'left': left_out,
                'top' : top
            });
        });

        this.tallest($container);
        $(window).resize();
    };

    Plugin.prototype.tallest = function (_container) {
        var column_heights = [],
            largest = 0;

        for(var z = 0; z < columns; z++) {
            var temp_height = 0;
            _container.find('.c'+z).each(function() {
                temp_height += $(this).outerHeight();
            });
            column_heights[z] = temp_height;
        }

        largest = Math.max.apply(Math, column_heights);
        _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
    };

    Plugin.prototype.make_layout_change = function (_self) {
        if($(window).width() < _self.options.single_column_breakpoint) {
            _self.calculate(true);
        } else {
            _self.calculate(false);
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin(this, options));
            }
        });
    }

})(jQuery, window, document);
 </script>
 <?php
	include('LandingPageFooter.php');
 ?>
