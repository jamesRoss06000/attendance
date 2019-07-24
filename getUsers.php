<?php
require_once("connection.php");
$id =  $_GET["q"];

$result3 = "SELECT id, nom FROM users WHERE classe = :classe";
$stmt = $conn->prepare($result3);
$stmt->bindParam(":classe", $_GET['q']);
$stmt->execute();
$users = $stmt->fetchAll();
echo "<option value=\"\">Sélectionnez l'étudiant'</option>";

foreach ($users as $key => $value) {
    echo "<option value='" . $value['nom'] . "'>" . $value['nom'] . "</option>";
}
