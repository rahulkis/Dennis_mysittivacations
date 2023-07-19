<?php 
  $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
?>

<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel"><?php echo $_POST['keyword']; ?></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="audio_tour_modal">
    <ul class="us-city-popups row">   

    <?php 
    if($_POST['keyword'] == 'Beautiful America'){

    $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%chicago%' AND tag = 'Tours4Fun' LIMIT 60";
    $result = $mysqli->query($randon_deals);?>
    <?php foreach ($result as $keys => $values) {
    if(!empty($values['tag'])){
    $new = substr($values['link'], strrpos($values['link'], '=' )+1);
    $buy_urls = str_replace('%3A%2F%2F', '://', $new);
    $buy_urlss = str_replace('%2F', '/', $buy_urls);
    $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
    $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
    $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
    $buy_url = $buy_urlsssss; 
    ?>     
    <li class="col-sm-3 col-md-3 col-xs-6">
    <a href="<?php echo $buy_url; ?>" target="_blank" class="cool_link">
    <img src="<?php echo $values['image_link']; ?>" loading="lazy">
    <span class="dealscity_name cityes_cityes_name"><?php echo substr($values['title'],0,20)."...";?></span>
    </a>
    </li>   
    <?php 
      }
    } 
  }else{
      $sql = "SELECT name,image_url FROM popular_cities limit 60";
      $result = $mysqli->query($sql);
      foreach ($result as $key => $value) {
      ?>  
      <li class="col-sm-3 col-md-3 col-xs-6">
      <a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state" class="cool_link">
      <img src="<?php echo $value['image_url']; ?>" loading="lazy">
      <span class="dealscity_name cityes_cityes_name"><?php echo $value['name'];?></span>
      </a>
      </li>   
      <?php } 
      } ?>     
    </ul>
  </div>
</div>