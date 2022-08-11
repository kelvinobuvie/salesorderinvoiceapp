<?php
session_start();
include_once('function.php');

if(empty($_POST['username'])){
  $username = '';
  echo '<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%; margin-top:10px;"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Username is required</div>';
  exit();
}

if(empty($_POST['password'])){
  $password = '';
  echo '<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%; margin-top:10px;"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp; Password is required</div>';
  exit();
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

$checkstmt = $conn->prepare('SELECT * FROM staffs WHERE staffUsername = :username AND staffPassword = :password AND staffStatus = 1');
  $checkstmt->bindParam(':username', $username, PDO::PARAM_STR);
  $checkstmt->bindParam(':password', $password, PDO::PARAM_STR);
  $checkstmt->execute();

  $rowCount = $checkstmt->fetch(PDO::FETCH_ASSOC);

  if(!$rowCount){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:45%;">Invalid credentials!</div>';
    exit();
  }

  $_SESSION['userID'] = $rowCount['userID'];

  echo '1';

?>