<?php
session_start();
include_once('function.php');

if($_SESSION['userID'] == ''){
 header('Location: login.php');
}

$userID = $_SESSION['userID'];

if(empty($_POST['staffID'])){
  $staffID = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff ID is required.</div>';
  exit();
}

if(empty($_POST['firstName'])){
  $firstName = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff firstname is required.</div>';
  exit();
}

if(empty($_POST['lastName'])){
  $lastName = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff lastname is required.</div>';
  exit();
}

if(empty($_POST['phoneNumber'])){
  $phoneNumber = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff telephone number is required.</div>';
  exit();
}

if(empty($_POST['department'])){
  $department = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff department selection is required.</div>';
  exit();
}

if(empty($_POST['homeAddress'])){
  $homeAddress = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff home address is required.</div>';
  exit();
}

if(empty($_POST['permanentAddress'])){
  $permanentAddress = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">Staff home address is required.</div>';
  exit();
}

if(empty($_POST['staffCity'])){
  $staffCity = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">City is required.</div>';
  exit();
}

if(empty($_POST['staffState'])){
  $staffState = "";
  echo '<div id="response" class="btn btn-danger btn-lg btn-block">State selection is required.</div>';
  exit();
}


  $staffID = filter_var($_POST['staffID'], FILTER_SANITIZE_STRING);
  $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
  $otherNames = filter_var($_POST['otherNames'], FILTER_SANITIZE_STRING);
  $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
  $phoneNumber = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING);
  $department = $_POST['department'];
  $homeAddress = filter_var($_POST['homeAddress'], FILTER_SANITIZE_STRING);
  $permanentAddress = filter_var($_POST['permanentAddress'], FILTER_SANITIZE_STRING);
  $staffCity = filter_var($_POST['staffCity'], FILTER_SANITIZE_STRING);
  $staffState = $_POST['staffState'];
  $department = $_POST['department'];
  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  $checkstmt = $conn->prepare('SELECT * FROM staffs WHERE staffID = :staffID LIMIT 1');
  $checkstmt->bindParam(':staffID', $staffID);
  $checkstmt->execute();

  $rowCount = $checkstmt->rowCount();

  if($rowCount >= 1){
    echo '<div id="response" class="btn btn-danger btn-md" style="width:30%;">Record already exist!</div>';
  exit();
  }

  $insertstmt = $conn->prepare('INSERT INTO staffs (staffID, staffFirstName, staffOtherNames, staffLastName, staffPhoneNumber, staffHomeAddress, staffPermanentAddress, staffCity, staffState, staffDepartment, staffUsername, staffPassword) VALUES (:staffID, :firstName, :otherNames, :lastName, :phoneNumber, :homeAddress, :permanentAddress, :staffCity, :staffState, :department, :username, :password)');
  $insertstmt->bindParam(':staffID', $staffID);
  $insertstmt->bindParam(':firstName', $firstName);
  $insertstmt->bindParam(':otherNames', $otherNames);
  $insertstmt->bindParam(':lastName', $lastName);
  $insertstmt->bindParam(':phoneNumber', $phoneNumber);
  $insertstmt->bindParam(':homeAddress', $homeAddress);
  $insertstmt->bindParam(':permanentAddress', $permanentAddress);
  $insertstmt->bindParam(':staffCity', $staffCity);
  $insertstmt->bindParam(':staffState', $staffState);
  $insertstmt->bindParam(':department', $department);
  $insertstmt->bindParam(':username', $username);
  $insertstmt->bindParam(':password', $password);
  
  if($insertstmt->execute()){
    echo '<div id="response" class="btn btn-success btn-md" style="width:30%;">Success!</div>';
  exit();
  }else{
    echo '<div id="response" class="btn btn-info btn-md" style="width:30%;">Unable to save, kindly contact your administrator.</div>';
  exit();
  }

  

?>