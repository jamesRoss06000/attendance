<?php
require_once("connection.php");
require_once("modifyAbsencesTreatment.php");

if (!empty($_POST)) {
    $absenceId = $_GET['id'];
    $justifie = $_POST['justifie'];
    $justificatif = $_POST['justificatif'];

    $add = $conn->prepare("UPDATE `absences` SET `justified`= :justifie, `justificatif`= :justificatif WHERE `id` = :id");
    $add->bindParam(':justifie', $justifie);
    $add->bindParam(':justificatif', $justificatif);
    $add->bindParam(':id', $absenceId, PDO::PARAM_INT);
    $add->execute();
    header('Location: modifyAbsencesHome.php');
    exit;
}
$absenceId = $_GET['id'];
$sqlSelect = "SELECT * FROM `absences` WHERE `id`='$absenceId'";
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
            <form action="modifyAbsence.php?id=<?php echo $absenceId ?>" method="post" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input name="classe" type="text" class="form-control" id="classe" placeholder="classe" value="<?php echo $result["classe"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="etudiant" type="text" class="form-control" id="etudiant" placeholder="etudiant" value="<?php echo $result["etudiant"]; ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <input name="cours" type="text" class="form-control" id="cours" placeholder="cours" value="<?php echo $result["cours"]; ?>">
                    </div>
                    <div class="form-group col-md-12" id="radioDiv">
                        <label class="radio-inline">
                            <input type="radio" id="nonBtn" name="justifie" value="non" checked>Non
                        </label>
                        &nbsp;
                        <label class="radio-inline">
                            <input type="radio" id="ouiBtn" name="justifie" value="oui">Oui
                        </label>
                    </div>
                    <div class="form-group col-md-12">
                        <select name="justificatif" type="select" class="form-control" id="justificatif" placeholder="justificatif" value="<?php echo $result["justificatif"]; ?>">
                            <option value="">Sélectionnez le justificatif</option>
                            <?php
                            while ($rows3 = $result3->fetch_assoc()) {
                                $jusificatif = $rows3['justificatif'];
                                echo "<option value='$jusificatif'>$jusificatif</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Modifiez la ligne</button>
                    <button type="cancel" class="btn btn-danger">Annule</button>
                </div>
            </form>
        </div>
    </div>
    <!-- <script>
        $(document).ready(function() {
            var etudiantBlocked = $("#justificatif");
            var selectedOrNot = $("#ouiBtn");
            selectedOrNot.on("click", function() {
                if ($(this).val() != "") {
                    etudiantBlocked.removeAttr("disabled");
                } else {
                    etudiantBlocked.attr("disabled", "");
                }
            });
        });
    </script> -->
</body>

</html>