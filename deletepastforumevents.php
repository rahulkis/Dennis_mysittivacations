<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


$currentdate = date('Y-m-d H:i:s');

@mysql_query("DELETE FROM `forum` WHERE `event_date` < '$currentdate' AND `user_id` = '0' AND `post_from` = 'city_forum' ");





