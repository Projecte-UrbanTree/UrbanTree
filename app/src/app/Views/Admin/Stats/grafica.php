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
    echo json_encode(array("error" => "Conexió fallida", "message" => $conn->connect_error));
    exit();
}

// Afegir encapçalaments CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

// Definir la resposta per les peticions
if (isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];
    switch ($endpoint) {
        case 'dades1':
            // Dades 1 - Tasques completades
            $query = "SELECT name, hours AS valor FROM task_types";  // Exemple
            break;
        case 'dades2':
            // Dades 2 - Hores treballades
            $query = "SELECT user_id AS name, hours_worked AS valor FROM work_orders_users";  // Exemple
            break;
        case 'dades3':
            // Dades 3 - Consum
            $query = "SELECT work_order_id AS name, spent_fuel AS valor FROM work_reports";  // Exemple
            break;
        default:
            echo json_encode(array("error" => "Endpoint no reconegut"));
            exit();
    }

    // Comprovar si la consulta es valida
    $result = $conn->query($query);
    if (!$result) {
        echo json_encode(array("error" => "Error en la consulta SQL", "message" => $conn->error));
        exit();
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Enviar resposta en format JSON
    echo json_encode($data);
    exit();
} else {
    echo json_encode(array("error" => "Endpoint no especificat"));
}

$conn->close();
?>
