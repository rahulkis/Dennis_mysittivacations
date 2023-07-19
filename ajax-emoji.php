<?php

include("Query.Inc.php");
$Obj = new Query($DBName);
// dd($_POST);
// header('Content-Type: application/json');
$content = trim($_POST['content']);

if($content != "")
{
  //save message to the DB
  $message = json_encode($content);
  
  $db->table('messages')->insert([
    'content' => $message
  ]);

  $reponse = ['content' => json_decode($message)];
  echo json_encode($reponse);
  die;
}
return null;

