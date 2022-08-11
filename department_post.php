<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
 header('Location: login.php');
}

if(empty($_POST['department'])){
  $department = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Department is required.</div>';
  exit();
}


  $department = filter_var($_POST['department'], FILTER_SANITIZE_STRING);

  $checkstmt = $conn->prepare('SELECT * FROM departments WHERE departmentDescription = :department LIMIT 1');
  $checkstmt->bindParam(':department', $department, PDO::PARAM_STR);
  $checkstmt->execute();

  $rowCount = $checkstmt->fetch(PDO::FETCH_ASSOC);

  if($rowCount >= 1){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:30%;">Record already exist!</div>';
  exit();
  }

  $insertstmt = $conn->prepare('INSERT INTO departments (departmentDescription) VALUES (:department)');
  $insertstmt->bindParam(':department', $department, PDO::PARAM_STR);
  
  if($insertstmt->execute()){
    echo '<div id="response" class="btn btn-success btn-md" style="width:30%;">Success!</div>';
  exit();
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, kindly contact your administrator.</div>';
  exit();
  }

  

?>