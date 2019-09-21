<?php
require_once("addUserTreatment.php");
require_once("ifSessionNotSet.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter l'utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
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
    <?php } ?>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter l'utilisateur à la base de données</h3>
            </div>
            <form action="addUser.php" method="post" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input name="name" type="text" class="form-control" id="name" placeholder="Nom" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="telephone" type="text" class="form-control" id="telephone" placeholder="Telephone" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="password" type="password" class="form-control" id="password" placeholder="Mot de passe" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Confirme mot de passe" value="">
                    </div>
                    <div class="form- group col-md-12">
                        <select name="role" id="role" class="form-control" placeholder="Role">
                            <option value="">Choisir le rôle parmi les options ci-dessous</option>
                            <option value="admin">Admin</option>
                            <option value="intervenant">Intervenant</option>
                            <option value="etudiant">Etudiant</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="classe" id="classe" class="form-control">
                            <option value="">Sélectionnez la classe</option>
                            <option value="NULL">N/A - Admin ou Intervenant</option>
                            <?php
                            while ($rows = $result->fetch_assoc()) {
                                $classe = $rows['classe'];
                                echo "<option value='$classe'>$classe</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-width">Ajouter information</button>
                    <a href="mainMenu.php" class="btn btn-danger btn-width">Annule / Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>