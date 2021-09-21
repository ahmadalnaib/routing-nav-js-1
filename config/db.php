<?php
// database
$mysqli=new mysqli("localhost",'root','','2022');
if($mysqli->connect_error){
  die('no coneect' .$mysqli->connect_error);
}
