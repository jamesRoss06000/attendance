<?php
require_once("addClasseTreatment.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Classe à Base de Données</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- errors -->
    <?php
    if (isset($errors) && sizeof($errors) > 0) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php
            echo implode(" ", $errors);
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un nouveau classe à la base de données</h3>
            </div>
            <form action="addClasse.php" method="POST" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input name="classe" type="text" class="form-control" id="classe" placeholder="Entrez le nom de la classe" value="<?php if (isset($_POST['classe'])) {
                                                                                                                                                echo htmlentities($_POST['classe']);
                                                                                                                                            } ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="debut" type="date" class="form-control" id="debut" placeholder="Sélectionnez la date de début" value="<?php if (isset($_POST['debut'])) {
                                                                                                                                                echo htmlentities($_POST['debut']);
                                                                                                                                            } ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="fin" type="date" class="form-control" id="fin" placeholder="Entrer le numero de telephone" value="<?php if (isset($_POST['fin'])) {
                                                                                                                                            echo htmlentities($_POST['fin']);
                                                                                                                                        } ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-width">Ajouter information</button>
                    <a href="http://localhost/Attendance%20App/mainMenu.php" class="btn btn-danger btn-width">Annule / Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>