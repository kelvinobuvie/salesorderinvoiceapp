<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$userID = $_SESSION['userID'];


if(empty($_POST['ordernumber'])){
  $ordernumber = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Invalid order number, cannot process invoice!</div>';
  exit();
}


  $ordernumber = $_POST['ordernumber'];

  $checkstmt = $conn->prepare('SELECT * FROM salesorder WHERE salesOrderNumber = :ordernumber AND assignedTo = :userid');
  $checkstmt->bindParam(':ordernumber', $ordernumber, PDO::PARAM_STR);
  $checkstmt->bindParam(':userid', $userID, PDO::PARAM_STR);
  $checkstmt->execute();

  $rowCount = $checkstmt->rowCount();

  if($rowCount < 1){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:40%;">Record does not exist, do contact your administrator!</div>';
  exit();
  }

  $invoicenumber = date("Ymd") . "/" . rand();
  $modifieddate = date("d-m-Y");

  $insertstmt = $conn->prepare('UPDATE salesorder SET invoiceNumber = :invoicenumber, modifiedBy = :userid, modifiedDate = :modifieddate WHERE salesOrderNumber = :ordernumber AND assignedTo = :assignedto');
  $insertstmt->bindParam(':invoicenumber', $invoicenumber, PDO::PARAM_STR);
  $insertstmt->bindParam(':userid', $userID, PDO::PARAM_INT);
  $insertstmt->bindParam(':modifieddate', $modifieddate, PDO::PARAM_STR);
  $insertstmt->bindParam(':ordernumber', $ordernumber);
  $insertstmt->bindParam(':assignedto', $userID);
  
  if($insertstmt->execute()){
    echo '1';
  exit();
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, kindly contact your administrator.</div>';
  exit();
  }

  

?>