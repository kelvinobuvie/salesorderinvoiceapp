<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
 header('Location: login.php');
}
$userID = $_SESSION['userID'];

if(empty($_POST['itemDescription'])){
  $itemDescription = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Item description is required.</div>';
  exit();
}

if(empty($_POST['unitPrice'])){
  $unitPrice = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Item unit price is required.</div>';
  exit();
}

  $itemDescription = strtolower(filter_var($_POST['itemDescription'], FILTER_SANITIZE_STRING));
  $unitPrice = filter_var($_POST['unitPrice'], FILTER_SANITIZE_NUMBER_INT);
  

  $checkstmt = $conn->prepare('SELECT * FROM items WHERE itemDescription = :itemdescription AND itemUnitPrice = :unitprice LIMIT 1');
  $checkstmt->bindParam(':itemdescription', $itemDescription);
  $checkstmt->bindParam(':unitprice', $unitPrice);
  $checkstmt->execute();

  $rowCount = $checkstmt->rowCount();

  if($rowCount >= 1){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:30%;">Record already exist!</div>';
  exit();
  }

  $insertstmt = $conn->prepare('INSERT INTO items (itemDescription, itemUnitPrice) VALUES (:itemdescription, :unitprice)');
  $insertstmt->bindParam(':itemdescription', $itemDescription);
  $insertstmt->bindParam(':unitprice', $unitPrice);
  
  
  if($insertstmt->execute()){
    echo '<div id="response" class="btn btn-success btn-md" style="width:30%;">Success!</div>';
  exit();
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, contact your administrator.</div>';
  exit();
  }

  

?>