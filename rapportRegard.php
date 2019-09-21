<?php
require_once("rapportTreatment.php");
require_once("connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapport d'absence</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id='HTMLtoPDF'>
    <?php
        if (isset($_POST["classe"], $_POST["etudiant"])) {
            $id =  $_POST['etudiant'];
            $sql = ("SELECT `id`, `nom`, `email`, `classe` FROM `users` WHERE `nom` = :etudiant");
            $result = $conn->prepare($sql);
            $result->bindParam(":etudiant", $id);
            $request = $result->execute();
            echo "<div id='formDiv' class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>
            <h3 class='modal-title'>Rapport d absence généré</h3>
            </div>";
            echo "<div action='rapportRegard.php' method='post' class='modal-content'>";
            echo "<div class='form-row'>";
            echo "<table border='1' id='myTable'>";
            echo "<thead><tr><th>id</th><th>nom</th><th>email</th><th>classe</th></tr></thead>\n";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "<div class='form-group col-md-12'>";
            echo "</div";
            echo "</div";
            echo "</div";
            echo "</div";
            echo "</div";
        }
        
        ?>
        <?php
        if (isset($_POST["classe"], $_POST["etudiant"])) {
            $etudiant =  $_POST['etudiant'];
            $classe = $_POST['classe'];
            $sql = ("SELECT `date`, `cours`, `justified`, `justificatif` FROM `absences` WHERE `etudiant` = :etudiant AND `classe` = :classe");
            $result = $conn->prepare($sql);
            $result->execute([":etudiant" => $etudiant, ":classe" => $classe]);
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<br>";
            echo "<div action='rapportRegard.php' method='post' class='modal-content'>";
            echo "<div class='form-row'>";
            echo "<table border='1' id='myTable'>";
            echo "<thead><tr><th>date</th><th>cours</th><th>justifié<th>justificatif</th></tr></thead>\n";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "<div class='form-group col-md-12'>";
            echo "<a href='#' onclick='HTMLtoPDF()' class='btn btn-success btn-width'>Télécharger un PDF</button>";
            echo "<a href='mainMenu.php' class='btn btn-danger btn-width'>Annule</a>";
            echo "</div";
            echo "</div";
            echo "</div";
            echo "</div";
            echo "</div";
        }
        ?>
    </div>
    <!-- these js files are used for making PDF -->
	<script src="js/jspdf.js"></script>
	<script src="js/jquery-2.1.3.js"></script>
	<script src="js/pdfFromHTML.js"></script>
</body>

</html>