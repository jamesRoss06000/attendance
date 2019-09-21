<?php
session_start();
require_once("addCampusTreatment.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter Campus à Base de Données</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                <h3 class="modal-title">Ajouter un nouveau campus à la base de données</h3>
            </div>
            <form action="addCampus.php" method="POST" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input name="campus" type="text" class="form-control" id="campus"placeholder="Entrer le nom du campus" value="<?php if (isset($_POST['campus'])) {
                                                                                                                                            echo htmlentities($_POST['campus']);
                                                                                                                                        } ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="adresse" type="text" class="form-control" id="adresse" placeholder="Entrer l'adresse" value="<?php if (isset($_POST['adresse'])) {
                                                                                                                                        echo htmlentities($_POST['adresse']);
                                                                                                                                    } ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="telephone" type="number" class="form-control" id="telephone" placeholder="Entrer le numero de telephone" value="<?php if (isset($_POST['telephone'])) {
                                                                                                                                                            echo htmlentities($_POST['telephone']);
                                                                                                                                                        } ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Entrer l'email" value="<?php if (isset($_POST['email'])) {
                                                                                                                                    echo htmlentities($_POST['email']);
                                                                                                                                } ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-width">Ajouter information</button>
                    <a href="mainMenu.php" class="btn btn-danger btn-width">Annule / Retour</a>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (!isset($_SESSION['admin'])) {
        echo "<b>Please login to use this system</b>";
        echo "<td><a class='btn btn-danger btn-modal btn-md' id='login' href='index.php'>Click To Login</a></td>";
        echo "<script>$(':button').prop('disabled', true);</script>";
    }
    ?>
</body>

</html>