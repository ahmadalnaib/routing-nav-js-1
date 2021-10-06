<?php
session_start();
if(isset($_SESSION['logged_in'])){
  $_SESSION=[];
  $_SESSION['success_message']="bye bye";
  header('location:index.php');
  
}