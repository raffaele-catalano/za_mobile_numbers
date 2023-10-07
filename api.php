<?php
header("Content-Type: application/json");

function respondWithError($message, $httpStatusCode = 400) {
    http_response_code($httpStatusCode);
    echo json_encode(["error" => $message]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    respondWithError("Metodo HTTP non supportato.", 405);
}

if (!isset($_GET["tipo"])) {
    respondWithError("Parametro 'tipo' mancante nella richiesta GET");
}

$tipo = strtolower($_GET["tipo"]);
// var_dump($tipo); die;

if (!in_array($tipo, ['all', 'valid', 'invalid'])) {
    respondWithError("Tipo non valido");
}
    
include 'database.php';

try {
    $db = new PDO('sqlite:za_numbers.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    respondWithError("Errore nella connessione al database: " . $e->getMessage());
}

$sql = 'SELECT numero FROM numeri WHERE 1';
$stmt = $db->prepare($sql);

if ($tipo != 'all') {
    $sql .= ' AND tipo = :tipo';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':tipo', $tipo);
} else {
    $stmt = $db->prepare($sql);
}


if ($stmt->execute()) {
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (empty($result)) {
        respondWithError("Nessun numero trovato con il tipo '$tipo'.");
    } else {
        echo json_encode($result);
    }
} else {
    respondWithError("Errore nella query del database.");
}
// Chiudere la connessione al database
$db = null;
?>
