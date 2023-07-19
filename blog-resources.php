<section id="our_blogs" class="sec_pad bg_grey">
    <div class="container">
        <div class="heading">
            <h4>Our blogs & resources</h4>
            <p>Here are some beautiful destinations</p>
        </div>
        <div class="blogs_slider owl-carousel owl-theme">
            <?php 
            require($_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php');
            if(!$detect->isMobile()) {
            $args = array(
            'posts_per_page' => 12 // Specify how many posts you'd like to display
        );
        }else{
            $args = array(
            'posts_per_page' => 3 // Specify how many posts you'd like to display
        );
        }
            $latest_posts = new WP_Query( $args );
            if ( $latest_posts->have_posts() ) {
                while ( $latest_posts->have_posts() ) {
                    $latest_posts->the_post(); ?>
                    <div class="item">
                        <div class="row m-0">
                            <div class="col-lg-6">
                                <?php $img_url = get_the_post_thumbnail_url(); 
                                if ($img_url == ''){ ?>
                                   <img src="<?php echo $SiteURL; ?>image_2022_02_09T13_15_02_553Z.png" class="img-fluid" loading="lazy">
                               <?php } else {?>
                                <img src="<?php echo $img_url; ?>" class="img-fluid" loading="lazy">
                            <?php } ?>
                        </div>
                        <div class="col-lg-6 ps-0">
                            <div class="item_content">
                                <span class="date"><i class="far fa-calendar-alt me-3"></i><?php the_time('M j, Y') ?></span>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <h3><?php the_title(); ?></h3>
                                </a>
                                <?php the_excerpt(); ?>
                                <div class="text-end"><i class="fas fa-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            <? }
        } else {
            echo '<p>There are no posts available</p>';
        }
        wp_reset_postdata();
        ?>
    </div>
</div>
</section>