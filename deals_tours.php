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
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="container">
		<div class="row">
			<section id="pinBoot">
				<article class="white-panel"><img src="images/Blockchain.jpg" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-wrapper">
							<div class="PictureCard-cityName">London</div>
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ 164</span><time class="PictureCard-duration" datetime="2019-12-04T16:50:00+05:30">Wed 4 Dec</time>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class="">7 Day Italy, Switzerland and France Tour from Paris</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>

				<article class="white-panel"> <img src="images/blog-2.jpg" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-wrapper">
							<div class="PictureCard-cityName">London</div>
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ 164</span><time class="PictureCard-duration" datetime="2019-12-04T16:50:00+05:30">Wed 4 Dec</time>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class="">7 Day Italy, Switzerland and France Tour from Paris</span>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>
				
				<article class="white-panel"><img src="images/Blockchain.jpg" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-wrapper">
							<div class="PictureCard-cityName">London</div>
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ 164</span><time class="PictureCard-duration" datetime="2019-12-04T16:50:00+05:30">Wed 4 Dec</time>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class="">7 Day Italy, Switzerland and France Tour from Paris</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>

				<article class="white-panel"> <img src="images/blog-2.jpg" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-wrapper">
							<div class="PictureCard-cityName">London</div>
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ 164</span><time class="PictureCard-duration" datetime="2019-12-04T16:50:00+05:30">Wed 4 Dec</time>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class="">7 Day Italy, Switzerland and France Tour from Paris</span>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>
			</section>
		</div>
	</div>
<style>

#pinBoot {
  position: relative;
  max-width: 100%;
  width: 100%;
  margin:70px 0;
}

.white-panel img {
  width: 100%;
  max-width: 100%;
  height: auto;
  position:relative;
}
.PictureCard-overlay {
    z-index: 3;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: end;
    -webkit-justify-content: flex-end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    padding: 10px;
    box-sizing: border-box;
    -webkit-transition: .3s background-color;
    transition: .3s background-color;
}
.PictureCard-wrapper {
    color: #fff;
    font-weight: 700;
    -webkit-transition: .3s -webkit-transform;
    transition: .3s -webkit-transform;
    transition: .3s transform;
    transition: .3s transform,.3s -webkit-transform;
    -webkit-transform: translateY(28px);
    transform: translateY(28px);
}
.PictureCard-cityName {
    font-size: 24px;
}
.PictureCard-data {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: end;
    -webkit-align-items: flex-end;
    -ms-flex-align: end;
    align-items: flex-end;
}
.PictureCard-price {
    font-size: 20px;
}
.PictureCard-duration {
    line-height: 1.8;
}
.PictureCard-menu {
    height: 28px;
}
.PictureCard-overlay:hover {
    background-color: rgba(0,0,0,.75);
}
.PictureCard-overlay:hover .PictureCard-wrapper {
    -webkit-transform: translateY(0);
    transform: translateY(0);
}
.PictureCard-overlay:hover .PictureCard-data {
    border-bottom: 1px solid rgba(255,255,255,.2);
    padding-bottom: 8px;
}
.PictureCard-timebox._outbound {
    padding-top: 10px;
}
.PictureCard-timebox {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    font-size: 12px;
}
.white-panel {
  position: absolute;
  background: white;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
  padding: 0px !important;
  width:370px !important;
  overflow:hidden;
}

.white-panel h1 {
  font-size: 1em;
}
.white-panel h1 a {
  color: #A92733;
}

</style>
<?php
	include('LandingPageFooter.php');
 ?>
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