<?php

if (!empty($_REQUEST['user_id']) && !empty($_REQUEST['user_type'])) {

    $user_id = int($_REQUEST['user_id']);
    $user_type = mysql_real_escape_string($_REQUEST['user_type']);
    $country = int($_REQUEST['country']);
    $state = int($_REQUEST['state']);
    $city = int($_REQUEST['city']);

    mysql_query("update default_city_selected set country='$country' , state='$state' , city='$city' where user_id='$user_id'and user_type='$user_type'  ");
    $affectedrow = mysql_affected_rows();
    if ($affectedrow == '1') {
        $data['code'] = '300';
        $data['msg'] = 'Successfully Updated';
        $data['country'] = $country;
        $data['state'] = $state;
        $data['city'] = $city;
    }
    elseif ($affectedrow == '0') {
        $data['code'] = '301';
        $data['msg'] = 'Not Updated';
    }
    $jsondata['repsonse'] = $data;
}
else {
    $data['code'] = '302';
    $data['error'] = 'wrong url';
    $jsondata['response'] = $data;
}
echo json_encode($jsondata);
