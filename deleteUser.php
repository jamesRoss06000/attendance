<?php
require_once("connection.php");

$userId =$_GET['id'];
$sql = "DELETE FROM `users` WHERE `Id`='$userId'";
$req = $conn->prepare($sql);
$req->execute(); 
header("Location: modifyUserHome.php")
?>