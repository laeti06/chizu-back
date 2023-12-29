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
    case "POST":
        addCard();
        break;
    case 'DELETE':
        $id = intval($_GET["id"]);
        supCard($id);
        break;
    case 'PUT':
        $id = intval($_GET["id"]);
        modCard($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getCards($id = null)
{
    global $conn;
    if (!empty($id)) {
        $query = "SELECT * FROM cards WHERE id=" . intval($id);
    } else {
        $query = "SELECT * FROM cards";
    }
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
    if (isset($data['picture'], $data['name'], $data['power'], $data['type'])) {
        $picture = $data['picture'];
        $name = $data['name'];
        $power = $data['power'];
        $type = $data['type'];

        $query = "INSERT INTO cards (picture, name, power, type) VALUES ('$picture','$name', '$power', '$type')";
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
function modCard($id)
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['picture'], $data['name'], $data['power'], $data['type'])) {
        $picture = $data['picture'];
        $name = $data['name'];
        $power = $data['power'];
        $type = $data['type'];
        
        $query = "UPDATE cards 
            SET picture = '$picture', name = '$name', power = '$power', type = '$type' 
            WHERE id = $id";


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
