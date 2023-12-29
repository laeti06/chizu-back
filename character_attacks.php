<?php
include("./db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

// Autoriser toutes les origines à accéder à cet endpoint
header("Access-Control-Allow-Origin: *");
// Autoriser les méthodes spécifiées
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
// Autoriser certains en-têtes dans la requête
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Indiquer si les cookies et les informations d'identification peuvent être envoyés
header("Access-Control-Allow-Credentials: true");
// Répondre à la requête OPTIONS pour les demandes pré-vérification CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


switch ($request_method) {
    case 'GET':
        if (!empty($GET["id"])) {
            $id = intval($_GET["id"]);
            getCards($id);
        } else {
            getCards();
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getCards()
{
    global $conn;
    $query = "SELECT * FROM character_attacks";
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addCard()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);

    $attack_name = $data['attack_name'];
    $damage = $data['damage'];
    

    $query = "INSERT INTO character_attacks (attack_name, damage) VALUES ('$attack_name','$damage')";
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 'success',
            'message' => 'Carte ajoutée avec succès.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        $response = array(
            'status' => 'error',
            'message' => 'Erreur lors de l\'ajout de la carte.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

function supCard($id)
{
    global $conn;
    $id = intval($id);
    $query = "DELETE FROM cards WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 'success',
            'message' => 'Carte ajoutée avec succès.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        $response = array(
            'status' => 'error',
            'message' => 'Erreur lors de l\'ajout de la carte.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
