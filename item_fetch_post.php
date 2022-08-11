<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
  header('Location: login.php');
}

$itemDescription = $_POST['itemDescription'];

$itemstmt = $conn->prepare("SELECT * FROM items WHERE itemID = :itemDescription LIMIT 1");
$itemstmt->bindParam(':itemDescription', $itemDescription, PDO::PARAM_INT);

if($itemstmt->execute()){
$rowCount = $itemstmt->fetch(PDO::FETCH_ASSOC);

if(!$rowCount){
  echo '1';
  exit();
}

echo json_encode($rowCount);
exit();

}else{
  echo '0';
  exit();
}

?>