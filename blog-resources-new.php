<div class="slider-section blog-section blog-resource-section"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Blog & Resource</h2>
				   <p>Here are some beautiful destinations</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="blog-block">
					<ul>
					 <?php 
        require($_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php');
            if(!$detect->isMobile()) {
            $args = array(
            'posts_per_page' => 5,
            'offset' => 2 // Specify how many posts you'd like to display
        );
        }else{
            $args = array(
            'posts_per_page' => 3 // Specify how many posts you'd like to display
        );
        }
            $latest_posts = new WP_Query( $args );
            if ( $latest_posts->have_posts() ) {
				$loop_Count=1;
                while ( $latest_posts->have_posts() ) {
                    $latest_posts->the_post(); 
					 $img_url = get_the_post_thumbnail_url(); 
					if($loop_Count==1){?>
						<li class="discount-block first" data-aos="zoom-in-right">
						<a href="https://www.mysittivacations.com/blog/essentials-for-things-to-do-in-los-angeles/">
                                   <img src="<?php echo $img_url?>" class="img-fluid firstImg" loading="lazy">
                       
							<div class="blog-details first" style="position: relative;">
								<div class="date-sec">
									
									<img src="<?php echo $SiteURL; ?>images/thing-to-do/cal.png" loading="lazy"> <p style="color:black"><?php the_time('M j, Y'); ?></p>
								</div>
								<h3 style="color: black"> Essentials For Things to Do in Los Angeles </h3>
							</div>
						</a>
						</li>
					<?php }else{ 
						if ($img_url == ''){
							 $image_url=$SiteURL.''.'image_2022_02_09T13_15_02_553Z.png';
						} else {
							$image_url=$img_url; 
						} 
						
						$cal_url=$SiteURL.''.'images/thing-to-do/cal.png';
						
						$newhtml.= '<li class="discount-block" data-aos="zoom-in-left">
											<a href="' . get_permalink() . '">
											<img src='.$image_url.' loading="lazy">
											<div class="blog-details">
												<div class="date-sec"><img src='.$cal_url.'>'.get_the_date('M j, Y').'</div>
												<h3>' . get_the_title() . '</h3>
											</div>
											</a>
										</li>
										';
						
					}
						 $loop_Count++;
					}
						 echo '<li><ul>'.$newhtml.'</ul></li>';
					} else {
						echo '<p>There are no posts available</p>';
					}
					wp_reset_postdata();
					?>
					
				</div>
				<div class="view-tag" data-aos="zoom-in-down">
					<a href="/blog">View All</a>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.blog-resource-section li.discount-block.first img {
    height: 642px;
    object-fit: cover;
    border-radius: 16px;
}
</style>