<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");
// Le 'header' 'Access-Control-Allow-Origin' indique si la réponse peut être partagée avec le 
// code demandeur de l'origine donnée. J'utilise la valeur '*', qui permettra au code de toute
//  origine d'accéder à une ressource.

// Le 'Header' 'Access-Control-Allow-Headers' est utilisé en réponse à une demande de contrôle 
// d'accès avant vol qui inclut les en-têtes Access-Control-Request-Headers pour indiquer quels 
// en-têtes HTTP peuvent être utilisés pendant la demande réelle.

require_once("connection2.php");
// Se connecte à la base de données à l'aide de ce fichier.

$rest_json = file_get_contents("php://input"); // Lit le fichier choisi dans une 'string', lorsque
// ('php://input') lit les informations brutes envoyées à PHP.
$_POST = json_decode($rest_json, true); // Prend une 'string' JSON et la convertit en variable PHP.

if (isset($_POST["email"], $_POST["password"])) {
// Rien compliqué ici
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $result = $stmt->execute([':email' => $email, ':password' => $password]);
// Si les données correspondent à celles stockées dans la base de données, alors 'rowCount' est 
// supérieur à un. Toutes les lignes (ne devrait être qu'une lors de la vérification des 
// informations de connexion de l'utilisateur) sont ensuite placées dans un tableau ($output), 
// encodées en json et renvoyées dans nos fichiers ioniques comme données dans un objet.
    if ($stmt->rowCount()>0) {
        $output = array();
        $output = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($output);
    } else {
        $errors["email"] = "Error";
        $errors["password"] = "Error";
        echo json_encode($errors);
    }// Le 'else' a été utilisé pendant le test, les erreurs s'affichaient dans le fichier console.log.
}