<?php
require_once("connection.php");

$sql = "SELECT * FROM absences";
$result = $conn->prepare($sql);
$request = $result->execute();

echo "<table border='1' id='myTable'>";
echo "<thead><tr><th>Id</th><th>Classe</th><th>Etudiant<th>Justifié</th><th>Justificatif</th><th>Cours</th><th>Supprimez une ligne</th><th>Modifiez une ligne</th></tr></thead>\n";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "<td><a class='btn btn-danger btn-md' href='deleteAbsence.php?id=".$row['id']."'>Delete</a></td>";
    echo "<td><a class='btn btn-warning btn-modal btn-md' href='modifyAbsence.php?id=".$row['id']."'>Modify</a></td>";
    echo "</tr>";
}
echo "</table>";