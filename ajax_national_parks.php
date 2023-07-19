	<?php
	
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
  session_start();
   if($_SESSION['city_name'] == 'Washington D.C.'){
  $sql = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 70";
}else{
  $sql = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 70 ";
}
  //$sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' order by id DESC ";
  $result = $mysqli->query($sql);
  ?>
   <ul class="us-city-popup row">
  <?php
  foreach ($result as $keys => $values) { ?>
   
      <li class="col-sm-4 col-md-4 col-xs-4">
        
        <a href="<?php echo $values['link']; ?>">
          <span class="dealscity_name cityes_cityes_name"><?php echo substr($values['title'], 0, 25).'...'; ?></span>
          <img src="<?php echo $values['image_link']; ?>">
        </a>
      </li>
  
    <?php } ?>
      </ul>



      <style>
        .modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body {
    padding: 0;
    margin: 0 auto;
    display: block;
}
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body ul.us-city-popup.row {
    width: 100%;
    padding: 0;
    margin: 10px 0 0;
}
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body ul.us-city-popup.row li {
    position: relative;
    box-shadow: 0px 0px 10px #0000002b;
    padding: 5px;
    width: 31%;
    margin: 0 auto 15px;
    border-radius: 10px;
    overflow: hidden;
}
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body ul.us-city-popup.row li a {
    height: auto;
    display: block;
}
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body ul.us-city-popup.row li img {
    width: 100%;
    height: 180px;
    border-radius: 10px;
}
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body ul.us-city-popup.row li a span.dealscity_name.cityes_cityes_name {
    margin: 0 !important;
    position: absolute;
    background: #fff;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 10px 0px;
    font-size: 14px;
    text-align: center;
}

      </style>
