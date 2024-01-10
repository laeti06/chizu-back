<?php
include("./db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Access-Control-Allow-Credentials: true");


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
    if (isset($data['picture'], $data['name'], $data['power'], $data['type_name'])) {
        $picture = $data['picture'];
        $name = $data['name'];
        $power = $data['power'];
        $type_name = $data['type_name'];

        $query = "INSERT INTO cards (picture, name, power, type_id) VALUES (?, ?, ?, (SELECT type_id FROM card_types WHERE type_name = ?))";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $picture, $name, $power, $type_name);
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
                'message' => 'Erreur lors de l\'ajout de la carte. avec parametre '+
                $picture+' '+$name+' '+$power+' '+$type_name
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
    $query = "DELETE FROM cards WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

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
}
function modCard($id)
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['picture'], $data['name'], $data['power'], $data['type_name'])) {
        $picture = $data['picture'];
        $name = $data['name'];
        $power = $data['power'];
        $type_name  = $data['type_name'];

        $type_query = "SELECT type_id FROM card_types WHERE type_name = ?";
        $type_stmt = $conn->prepare($type_query);
        $type_stmt->bind_param("s", $type_name);
        $type_stmt->execute();
        $result = $type_stmt->get_result();
        $type_row = $result->fetch_assoc();
        $type_id = $type_row['type_id'];


        $query = "UPDATE cards 
            SET picture = ?, name = ?, power = ?, type_id = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $picture, $name, $power, $type_id, $id);

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
            'message' => 'Erreur lors de la modification de la carte.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
