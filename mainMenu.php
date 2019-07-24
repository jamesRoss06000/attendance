<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Sélectionnez l'action à prendre</h3>
            </div>
            <div class="form-row modal-content" id="contentDiv">
                <a href="http://localhost/Attendance%20App/addPlanning.php"><button type="submit" class="btn btn-success btn-width">
                        Ajouter une leçon à la planification</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addGroupOfStudents.php"><button type="submit" class="btn btn-success btn-width">
                        Ajouter groupe d'étudiants et/ou une classe et durée</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addEtudiantToCours.php"><button type="submit" class="btn btn-success btn-width">
                        Inscrire l'étudiant dans un leçon</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addAbsences.php"><button type="submit" class="btn btn-success btn-width">Ajouter absence</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/modifyAbsencesHome.php"><button type="submit" class="btn btn-success btn-width">Modifier/Supprimer absence</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/rapport.php"><button type="submit" class="btn btn-success btn-width">Exécuter un rapport</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addUser.php"><button type="submit" class="btn btn-success btn-width">Ajouter un utilisateur</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addCampus.php"><button type="submit" class="btn btn-success btn-width">
                        Ajouter un nouveau campus</button></a>
                <br>
                <a href="http://localhost/Attendance%20App/addJustificatif.php"><button type="submit" class="btn btn-success btn-width">Ajouter un nouveau justificatif</button></a>
                <br>
            </div>
        </div>
    </div>
</body>

</html>