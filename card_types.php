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
function setCorsHeaders() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

// Utilisation de la fonction pour définir les en-têtes CORS dans votre script
setCorsHeaders();
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



function getCards()
{
    global $conn;
    $query = "SELECT * FROM card_types";
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

    $type_name = $data['type_name'];

    $query = "INSERT INTO card_types (type_name ) VALUES ('$type_name ')";
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
    $query = "DELETE FROM card_types WHERE id = $id";
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
    if (isset($data['type_name'])) {
        $type_name  = $data['type_name'];


        $type_query = "SELECT type_id FROM card_type WHERE type_id = ?";
        $type_stmt = $conn->prepare($type_query);
        $type_stmt->bind_param("s", $type_id);
        $type_stmt->execute();
        $result = $type_stmt->get_result();
        $type_row = $result->fetch_assoc();
        $type_id = $type_row['type_id'];


        $query = "UPDATE card_types
            SET  type_name = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $type_name, $id);

        if ($stmt->execute()) {
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
