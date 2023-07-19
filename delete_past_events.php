<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
$currendate = date('Y-m-d H:i:s');
$currendate2 = date('Y-m-d');
$previous_date = date('Y-m-d H:i:s', strtotime($currendate .' -1 day'));
$PreviousDate = date('Y-m-d', strtotime($currendate2 .' -2 day'));

// mail('sumit.manchanda@kindlebit.com', 'Cron Check', 'Successfully Executed !');

mysql_query("DELETE FROM `forum` WHERE `user_id` = '0' AND `event_date` < '$previous_date'  ");
mysql_query("DELETE FROM `croncheck` WHERE `executiondate` < '$PreviousDate'  ");
mysql_query("DELETE FROM `events` WHERE `date` < '$previous_date'  ");
// echo "DELETE FROM `croncheck` WHERE `executiondate` < '$PreviousDate' ";