<?php
require_once("connection.php");

$sql = "SELECT * FROM users";
$result = $conn->prepare($sql);
$request = $result->execute();

echo "<table border='1' id='myTable'>";
echo "<thead><tr><th>Id</th><th>Nom</th><th>Telephone</th><th>Email</th><th>Mot de pass</th><th>Role</th><th>Classe</th><th>Supprimez une ligne</th><th>Modifiez une ligne</th></tr></thead>\n";
$i = 1;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if ($i < 1){
    echo "<tr>";
    foreach ($row as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "<td><a class='btn btn-danger btn-md' href='deleteUser.php?id=".$row['id']."'>Delete</a></td>";
    echo "<td><a class='btn btn-warning btn-modal btn-md' href='modifyUser.php?id=".$row['id']."'>Modify</a></td>";
    echo "</tr>";
    }
    $i++;
}
echo "</table>";