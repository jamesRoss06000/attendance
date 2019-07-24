<?php
require_once("addPlanningTreatment.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter une leçon à la planification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("etudiant").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("etudiant").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "getUsers.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
</head>

<body>
<?php
    // If any errors, show them using Bootstrap 
    if (isset($errors) && sizeof($errors) > 0) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php // $errors is an array we turn to a string using the IMPLODE fonction 
            echo implode(" ", $errors);
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }  ?>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter une leçon à la planification</h3>
            </div>
            <form action="addPlanning.php" method="POST" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select name="classe" id="classe" class="form-control" onchange="showUser(this.value)">
                            <option value="">Sélectionnez la classe</option>
                            <?php
                            while ($rows = $result->fetch_assoc()) {
                                $classe = $rows['classe'];
                                echo "<option value='" . $rows['classe'] . "'>$classe</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <input name="date" type="date" class="form-control" id="date">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="time" type="time" class="form-control" id="time">
                    </div>
                    <div class="form-group col-md-12">
                        <select name="duration" id="duration" class="form-control">
                            <option value="">Sélectionnez le duration</option>
                            <option value="0h30">0h30</option>
                            <option value="1h00">1h00</option>
                            <option value="1h30">1h30</option>
                            <option value="2h00">2h00</option>
                            <option value="2h30">2h30</option>
                            <option value="3h00">3h00</option>
                            <option value="3h30">3h30</option>
                            <option value="4h00">4h00</option>
                            <option value="4h30">4h30</option>
                            <option value="5h00">5h00</option>
                            <option value="5h30">5h30</option>
                            <option value="6h00">6h00</option>
                            <option value="6h30">6h30</option>
                            <option value="7h00">7h00</option>
                            <option value="7h30">7h30</option>
                            <option value="8h00">8h00</option>
                            <option value="Demi jour">Demi jour</option>
                            <option value="1 jour">1 jour</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="lieux" id="lieux" class="form-control">
                            <option value="">Sélectionnez le campus</option>
                            <?php
                            while ($rows = $result4->fetch_assoc()) {
                                $campus = $rows['campus'];
                                echo "<option value='$campus'>$campus</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="cours" id="cours" class="form-control">
                            <option value="">Sélectionnez le cours</option>
                            <option value="Suivi individuel">Suivi individuel</option>
                            <option value="Projet emergence">Accomp. collectif au projet emergence</option>
                            <option value="Outils Numeriques">Workshop support et outils numériques</option>
                            <option value="Découverte des metiers">Atelier découverte des métiers en CFA</option>
                            <option value="Projet ancrage">Accomp. collectif au projet ancrage</option>
                            <option value="CFA">Semaine en CFA</option>
                            <option value="Posture Entreprise">Workshop Posture et Entreprise</option>
                            <option value="Semaine Entreprise">Semaine en entreprise</option>
                            <option value="Projet Entreprise">Accomp. collectif au projet et entreprise</option>
                            <option value="Créativité et autonomie">Workshop créativité, coopération et autonomie</option>
                            <option value="Reseaux sociaux">Workshop réseaux sociaux et identité numérique</option>
                            <option value="Entretiens de sécurisation">Entretiens de sécurisation</option>
                            <option value="Workshop Creativite">Workshop Creativite</option>
                            <option value="Workshop Numerique">Workshop Numerique</option>
                            <option value="Workshop Mobilite">Workshop Mobilite</option>
                            <option value="Atelier Projet">Atelier Projet</option>
                            <option value="Rencontres Metiers">Rencontre Metiers</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="intervenant" id="intervenant" class="form-control">
                            <option value="">Sélectionnez l'intervenant</option>
                            <?php
                            while ($rows2 = $result2->fetch_assoc()) {
                                $intervenant = $rows2['nom'];
                                echo "<option value='" . $rows2['id'] . "'>$intervenant</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-width">Ajouter information</button>
                    <a href="http://localhost/Attendance%20App/mainMenu.php" class="btn btn-danger btn-width">Annule / Retour</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var etudiantBlocked = $("#name");
            var selectedOtNot = $("#classe");
            selectedOtNot.on("click", function() {
                if ($(this).val() != "") {
                    etudiantBlocked.removeAttr("disabled");
                } else {
                    etudiantBlocked.attr("disabled", "");
                }
            });
        });
    </script>
</body>

</html>