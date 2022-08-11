<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$userID = $_SESSION['userID'];

if(empty($_POST['customerName'])){
  $customerName = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Customer name is required.</div>';
  exit();
}

if(empty($_POST['contactName'])){
  $contactName = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Contact name is required.</div>';
  exit();
}

if(empty($_POST['contactTelephone'])){
  $contactTelephone = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Contact telephone number is required.</div>';
  exit();
}

if(empty($_POST['billingAddress'])){
  $billingAddress = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Customer billing address is required.</div>';
  exit();
}

if(empty($_POST['shippingAddress'])){
  $shippingAddress = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Customer shipping address is required.</div>';
  exit();
}

if(empty($_POST['customerCity'])){
  $customerCity = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">City is required.</div>';
  exit();
}

if(empty($_POST['customerState'])){
  $customerState = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">State selection is required.</div>';
  exit();
}


  $customerName = strtolower(filter_var($_POST['customerName'], FILTER_SANITIZE_STRING));
  $contactName = filter_var($_POST['contactName'], FILTER_SANITIZE_STRING);
  $contactTelephone = filter_var($_POST['contactTelephone'], FILTER_SANITIZE_STRING);
  $billingAddress = filter_var($_POST['billingAddress'], FILTER_SANITIZE_STRING);
  $shippingAddress = filter_var($_POST['shippingAddress'], FILTER_SANITIZE_STRING);
  $customerCity = filter_var($_POST['customerCity'], FILTER_SANITIZE_STRING);
  $customerState = $_POST['customerState'];

  $checkstmt = $conn->prepare('SELECT * FROM customers WHERE customerName = :customerName LIMIT 1');
  $checkstmt->bindParam(':customerName', $customerName);
  $checkstmt->execute();

  $rowCount = $checkstmt->rowCount();

  if($rowCount >= 1){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:30%;">Record already exist!</div>';
  exit();
  }

  $insertstmt = $conn->prepare('INSERT INTO customers (customerName, customerContactName, customerContactNumber, billingAddress, shippingAddress, customerCity, customerState) VALUES (:customerName, :contactName, :contactTelephone, :billingAddress, :shippingAddress, :customerCity, :customerState)');
  $insertstmt->bindParam(':customerName', $customerName);
  $insertstmt->bindParam(':contactName', $contactName);
  $insertstmt->bindParam(':contactTelephone', $contactTelephone);
  $insertstmt->bindParam(':billingAddress', $billingAddress);
  $insertstmt->bindParam(':shippingAddress', $shippingAddress);
  $insertstmt->bindParam(':customerCity', $customerCity);
  $insertstmt->bindParam(':customerState', $customerState);
  
  if($insertstmt->execute()){
    echo '<div id="response" class="btn btn-success btn-md" style="width:30%;">Success!</div>';
  exit();
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, contact your administrator.</div>';
  exit();
  }

  

?>