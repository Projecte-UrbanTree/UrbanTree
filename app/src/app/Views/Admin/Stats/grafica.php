<?php

$servername = "localhost";
$username = "urbantree";
$password = "J0HMXAJ6XE";
$dbname = "urbantree";

// Crear connexió
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar connexió
if ($conn->connect_error) {
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(array("message" => "Conexió fallida: " . $conn->connect_error));
    exit();
}

// Afegir encapçalaments CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function obtenir_dades($conn, $taula): array {
    $sql = "SELECT * FROM $taula";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Mètode GET per obtenir les dades de la base de dades
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['endpoint'])) {
        if ($_GET['endpoint'] === 'dades1') {
            $data = obtenir_dades($conn, 'task_types');
            $response = array_map(function($item) {
                return ['name' => $item['name'], 'valor' => $item['hours']];
            }, $data);
            echo json_encode($response);
        } elseif ($_GET['endpoint'] === 'dades2') {
            $data = obtenir_dades($conn, 'work_orders_users');
            $response = array_map(function($item) {
                return ['name' => $item['user_id'], 'valor' => $item['hours_worked']];
            }, $data);
            echo json_encode($response);
        } elseif ($_GET['endpoint'] === 'dades3') {
            $data = obtenir_dades($conn, 'work_reports');
            $response = array_map(function($item) {
                return ['name' => $item['work_order_id'], 'valor' => $item['spent_fuel']];
            }, $data);
            echo json_encode($response);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint no trobat"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Endpoint no especificat"));
    }
}

// Mètode POST per enviar dades i realitzar accions com actualitzacions o insercions
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['endpoint'])) {
        if ($_POST['endpoint'] === 'insertar') {
            // Exemple d'inserció a la base de dades
            if (isset($_POST['taula']) && isset($_POST['dades'])) {
                $taula = $_POST['taula'];
                $dades = $_POST['dades'];

                // Inserir dades a la base de dades
                $columns = implode(", ", array_keys($dades));
                $values = implode(", ", array_map(function($item) {
                    return "'" . $item . "'";
                }, array_values($dades)));

                $sql = "INSERT INTO $taula ($columns) VALUES ($values)";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(array("message" => "Dades inserides correctament"));
                } else {
                    echo json_encode(array("message" => "Error en la inserció: " . $conn->error));
                }
            } else {
                echo json_encode(array("message" => "Dades incompletes per la inserció"));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Endpoint no trobat per POST"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Endpoint no especificat"));
    }
}

$conn->close();
?>
