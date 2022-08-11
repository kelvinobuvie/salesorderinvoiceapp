<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$customerID = $_POST['customerID'];

$custstmt = $conn->prepare("SELECT * FROM customers WHERE customerID = :customerID");
$custstmt->bindParam(':customerID', $customerID);

if($custstmt->execute()){

$rowCount = $custstmt->rowCount();

if($rowCount < 1){
  echo '1';
  exit();
}

$records = $custstmt->fetchAll(PDO::FETCH_OBJ);
echo json_encode($records);
exit();

}else{
  echo '0';
  exit();
}

?>