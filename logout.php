<?php
session_start();
$_SESSION['userID'] = '';
unset($_SESSION['userID']);
unset($userID);
session_destroy();

header('Location: ./login.php');

?>