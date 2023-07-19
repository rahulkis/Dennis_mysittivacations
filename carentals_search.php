<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropCity = rawurlencode($_POST['formatted']);
$pickupdate = $_POST['checkin'];
$pickuptime  = date("h:i", strtotime($_POST['checktime']));
$dropofDate = $_POST['checkout']; 
$dropofftime = date("h:i", strtotime($_POST['checkouttime']));


  $urlgo = "http://api.hotwire.com/v1/search/car?apikey=askvpcgfkw6fc2xrrcwkg5k6&startdate=".$pickupdate."&enddate=".$dropofDate."&dest=".$dropCity."&pickuptime=".$pickuptime."&dropofftime=".$dropofftime."&includeResultsLink=true&resultType=N";


    
        $xml = simplexml_load_file($urlgo) or die("ERROR: Cannot create SimpleXML object");

        $array = json_decode(json_encode((array)$xml), TRUE);
        
          $car_resutl  = $array['Result']['CarResult'];



                    foreach($car_resutl as $key => $carData){

                      $CurrencyCode[$key] = $carData['CurrencyCode'];
                      $DeepLink[$key] = $carData['DeepLink'];
                      $SubTotal[$key] = $carData['SubTotal'];
                      $TaxesAndFees[$key] = $carData['TaxesAndFees'];
                      $TotalPrice[$key] = $carData['TotalPrice'];
                      $CarTypeCode[$key] = $carData['CarTypeCode'];
                      $DailyRate[$key] = $carData['DailyRate'];
                      $LocationDescription[$key] = $carData['LocationDescription'];
                      $MileageDescription[$key] = $carData['MileageDescription'];
                      $PickupAirport[$key] = $carData['PickupAirport'];
                      $RentalAgency[$key] = $carData['RentalAgency'];
                      $ResultsDeepLink[$key] = $carData['ResultsDeepLink'];
        
                    }

                       
                       $typecode = "'".implode("','",$CarTypeCode)."'";

                
                        $sql = "SELECT * FROM `hotwire_car_rentals`
                                WHERE `hotwire_car_rentals`.`us` IN (".$typecode.")
                                ORDER BY FIELD(`hotwire_car_rentals`.`us`,".$typecode.")";

                         $result = mysql_query($sql);
                         $nurows = mysql_num_rows($result);

        
                          if($nurows > 0) {
                            $i=0;
                            while($row = mysql_fetch_assoc($result))
                            {
                                                     
                             $car_type = $row['car_type'];
                             $cartypecode = $row['us'];
                             $descriptions = $row['descriptions'];
                             $no_of_people = $row['no_of_people'];
                             $no_of_large_suitecase = $row['no_of_large_suitecase'];
                             $no_of_small_suitecase = $row['no_of_small_suitecase'];   
                             $car_image = $row['car_image']; 


                            $html .= "<div class='row new_common'>
                                  <div class='col-sm-3'>
                                    <div class='rent-car'>
                                     <a href=".$DeepLink[$i]." target='_blank'>
                                        <img src= ".$car_image." width='150' height='63'>
                                     </a>
                                     <span class='agency-names'>".$RentalAgency[$i]."</span> 
                                    </div>
                                  </div>
                                  <div class='col-sm-4'>
                                    <div class='car-details'>
                                       <h1>".$car_type."</h1>
                                        <p class='icon'>icon</p>
                                       <p class='desc'>".$descriptions."</p>
                                       <p class='desc'>".$MileageDescription[$i]." miles"."</p>
                                       <div class='number_lugguage'>
                                       <span class='no_of_people'>".'x'.$no_of_people."</span>
                                       <span class='no_of_large'>".'x'.$no_of_large_suitecase."</span>
                                       <span class='no_of_small'>".'x'.$no_of_small_suitecase."</span>
                                       </div>

                                    </div>
                                  </div>
                                  <div class='col-sm-3'>
                                    <p class='cance'>Free Cancellation</p>
                                    <span>";
                                     if(!empty($ResultsDeepLink[$i])) {
                                    $html .= "<a href=".$ResultsDeepLink[$i]." target='_blank' class='alldealss'>Hot Rates<img src= '/images/fire.png'></a>";
                                     }
                                    $html .= "</span>
                                  </div>

                                  <div class='col-sm-2 other_details'>
                                    <h1 class='amounts'>$".$DailyRate[$i]."</h1>
                                    <p class='desper'>Per Day</p>
                                    <p class='totalamotn'>$".$TotalPrice[$i]."</p>
                                    <a href=".$DeepLink[$i]." target='_blank' class='continubutton'>Select Car</a>
                                  </div>
                                </div>";  
                             
                                $i++;
                                }

                               echo $html;
                            }else{

                               echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
                            }

?>
  