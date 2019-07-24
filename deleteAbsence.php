<?php
require_once("connection.php");

$absenceId =$_GET['id'];
$sql = "DELETE FROM `absences` WHERE `Id`='$absenceId'";
$req = $conn->prepare($sql);
$req->execute(); 
header("Location: modifyAbsencesHome.php")
?>