<?php
require_once("connection.php");
require_once("modifyUserTreatment.php");

if (!empty($_POST)) {
    $absenceId = $_GET['id'];
    $justifie = $_POST['justifie'];
    $justificatif = $_POST['justificatif'];

    $add = $conn->prepare("UPDATE `users` SET `justified`= :justifie, `justificatif`= :justificatif WHERE `id` = :id");
    $add->bindParam(':id', $userId, PDO::PARAM_INT);
    $add->bindParam(':nom', $nom);
    $add->bindParam(':telephone', $telephone);
    $add->bindParam(':email', $email);
    $add->bindParam(':password', $password);
    $add->bindParam(':role', $role);
    $add->bindParam(':classe', $classe);
    $add->execute();
    header('Location: modifyUserHome.php');
    exit;
}
$userId = $_GET['id'];
$sqlSelect = "SELECT * FROM `users` WHERE `id`='$userId'";
$req = $conn->prepare($sqlSelect);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifiez une ligne</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="modifyUser.php?id=<?php echo $userId ?>" method="post" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input name="nom" type="text" class="form-control" id="nom" placeholder="nom" value="<?php echo $result["nom"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="telephone" type="text" class="form-control" id="telephone" placeholder="telephone" value="<?php echo $result["telephone"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="email" type="text" class="form-control" id="email" placeholder="email" value="<?php echo $result["email"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="password" type="text" class="form-control" id="password" placeholder="password" value="<?php echo $result["password"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="role" type="text" class="form-control" id="role" placeholder="role" value="<?php echo $result["role"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="classe" type="text" class="form-control" id="classe" placeholder="classe" value="<?php echo $result["classe"]; ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Modifiez la ligne</button>
                    <button type="cancel" class="btn btn-danger">Annule</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>