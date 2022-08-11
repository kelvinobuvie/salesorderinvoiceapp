<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
 header('Location: login.php');
}

$userID = $_SESSION['userID'];

if(empty($_POST['itemDescription'])){
echo '<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%; margin-top:10px;"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp;Atleast one item selection is required</div>';
exit();

}

if(empty($_POST['arritemDescription']) || empty($_POST['arritemQuantity']) || empty($_POST['arrunitPrice'])){
echo '<div style="padding:8px;background-color:#FF8800;color:#FFF;border-radius:0px;font-size:18px;width:100%; margin-top:10px;"> &nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign icon-size"></span> &nbsp;Atleast one item selection is required</div>';
exit();

}

$salesOrderNumber = date("Ymd") . mt_rand(10, 100);
$customerID = $_POST['customerName'];
$salesOrderDescription = filter_var($_POST['salesOrderDescription'], FILTER_SANITIZE_STRING);
$customerTelephone = filter_var($_POST['customerTelephone'], FILTER_SANITIZE_STRING);
$purchaseOrderNumber = filter_var($_POST['purchaseOrderNumber'], FILTER_SANITIZE_STRING);
$PONumber = "PO/".date("Ymd")."/".$purchaseOrderNumber;
$contactName = filter_var($_POST['contactName'], FILTER_SANITIZE_STRING);
$createdDate = date("d-m-Y");
$dueDate = filter_var($_POST['dueDate'], FILTER_SANITIZE_STRING);
$salesOrderCarrier = $_POST['salesOrderCarrier'];
$assignedTo = $_POST['assignedTo'];
$billingAddress = filter_var($_POST['billingAddress'], FILTER_SANITIZE_STRING);
$shippingAddress = filter_var($_POST['shippingAddress'], FILTER_SANITIZE_STRING);
$salesAdjustment = 0 + filter_var($_POST['salesAdjustment'], FILTER_SANITIZE_NUMBER_INT);
$salesCommission = 0 + filter_var($_POST['salesCommission'], FILTER_SANITIZE_NUMBER_INT);
$salesTax = filter_var($_POST['salesTax'], FILTER_SANITIZE_STRING);
$additionalInformation = filter_var($_POST['additionalInformation'], FILTER_SANITIZE_STRING);


$itemDescription = $_POST['arritemDescription'];
$itemQuantity = $_POST['arritemQuantity'];
$unitPrice = $_POST['arrunitPrice'];
$counter = count($_POST['arritemDescription']) - 1;


$checkstmt = $conn->prepare('SELECT * FROM salesorder WHERE salesOrderOwner = :customerName AND purchaseOrderNumber = :PONumber AND createdDate = :dueDate LIMIT 1');
  $checkstmt->bindParam(':customerName', $customerID, PDO::PARAM_INT);
  $checkstmt->bindParam(':PONumber', $PONumber, PDO::PARAM_STR);
  $checkstmt->bindParam(':dueDate', $createdDate, PDO::PARAM_STR);
  $checkstmt->execute();

  //$rowCount = $checkstmt->fetch(PDO::FETCH_ASSOC);

  //if(!$rowCount){
  //  echo '<div id="response" class="btn btn-danger btn-md" style="width:40%;">Record Already Exist!</div>';
  //  exit();
  //}


for($i = 0; $i < count($_POST['arritemDescription']); $i++){
  $salesTotal = $itemQuantity[$i] * $unitPrice[$i];
  
  $insertstmt = $conn->prepare('INSERT INTO salesorder (salesOrderNumber, purchaseOrderNumber, salesOrderOwner, salesOrderDescription, customerPhoneNumber, createdDate, contactName, dueDate, salesOrderCarrier, salesCommission, assignedTo, createdBy, billingAddress, shippingAddress, itemName, itemQuantity, itemUnitPrice, salesOrderTax, salesAdjustment, salesTotal, additionalInformation) VALUES (:salesOrderNumber, :purchaseOrderNumber, :salesOrderOwner, :salesOrderDescription, :customerPhoneNumber, :createdDate, :contactName, :dueDate, :salesOrderCarrier, :salesCommission, :assignedTo, :createdBy, :billingAddress, :shippingAddress, :itemName, :itemQuantity, :itemUnitPrice, :salesOrderTax, :salesAdjustment, :salesTotal, :additionalInformation)');
  $insertstmt->bindParam(':salesOrderNumber', $salesOrderNumber);
  $insertstmt->bindParam(':purchaseOrderNumber', $PONumber);
  $insertstmt->bindParam(':salesOrderOwner', $customerID);
  $insertstmt->bindParam(':salesOrderDescription', $salesOrderDescription);
  $insertstmt->bindParam(':customerPhoneNumber', $customerTelephone);
  $insertstmt->bindParam(':createdDate', $createdDate);
  $insertstmt->bindParam(':contactName', $contactName);
  $insertstmt->bindParam(':dueDate', $dueDate);
  $insertstmt->bindParam(':salesOrderCarrier', $salesOrderCarrier);
  $insertstmt->bindParam(':salesCommission', $salesCommission);
  $insertstmt->bindParam(':assignedTo', $assignedTo);
  $insertstmt->bindParam(':createdBy', $userID);
  $insertstmt->bindParam(':billingAddress', $billingAddress);
  $insertstmt->bindParam(':shippingAddress', $shippingAddress);
  $insertstmt->bindParam(':itemName', $itemDescription[$i]);
  $insertstmt->bindParam(':itemQuantity', $itemQuantity[$i]);
  $insertstmt->bindParam(':itemUnitPrice', $unitPrice[$i]);
  $insertstmt->bindParam(':salesOrderTax', $salesTax);
  $insertstmt->bindParam(':salesAdjustment', $salesAdjustment);
  $insertstmt->bindParam(':salesTotal', $salesTotal);
  $insertstmt->bindParam(':additionalInformation', $additionalInformation);
  //$insertstmt->execute();


  if($insertstmt->execute()){
    if($i == $counter){
    echo '<div id="response" class="btn btn-success btn-md" style="width:30%;">Success!</div>';
    exit();
    }
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, kindly contact your administrator.</div>';
    exit();
  }
  
} 

?>