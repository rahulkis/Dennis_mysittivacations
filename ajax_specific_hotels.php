<?php
  include 'Query.Inc.php';
  $Obj = new Query($DBName);
  error_reporting(0);
  $SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";
  $info        = $_POST['info'];
?>
 <h2 class='modal-title'>Hotels Deals</h2>
        <ul class="landing_page_hotel_deals landing_page_hotel_modal">
          <?php
            // $sql = "SELECT * FROM ".$_POST['modal_table']." WHERE afflication_name = '".$_POST['modal_affiliationName']."' AND description LIKE '%".$_POST['modal_whereCity']."%'";
           $sql = "SELECT * FROM cj_xml_data WHERE afflication_name = 'Hotels.com' AND description rlike '[[:<:]]".$_SESSION['city_name']."[[:>:]]'limit 30";
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)):
        $new = strstr($row['buy_url'], 'www.hotels.com');
        $buy_urls = str_replace('%2F', '/', $new);
        $buy_urlss = str_replace('%2F%3', '/', $buy_urls);
        $buy_urlsss = str_replace('1%3', '/', $buy_urlss);
         $buy_url = 'https://'.$buy_urlss;        
            ?>
              <li class="col-sm-4 col-md-4 col-xs-6 li_hotel_modal">
                <a target="_blank" href="<?php echo $buy_url; ?>">
        <div class="hotel_imges hotel_imgaes">
           <?php   $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                  <img src="<?php echo $url; ?>"></div>
                  <h3><?php echo substr($row['product_name'], 0,30); ?></h3>
                  <?php if(!empty($row['retail_price'])): ?>
                  <p><?php echo substr($row['description'], 0, 30); ?></p>
                  <h4 class="retail_hotel_price"><?php echo "$".$row['retail_price']." (".$row['currency'].")" ; ?></h4>
                  <?php endif; ?>
                  <h3 class="original_price tours_price original_price_new"><?php echo "$".$row['price']." (".$row['currency'].")" ; ?></h3>
                </a>
              </li>
          <?php
              endwhile;
          ?>
        </ul>
