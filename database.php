<?php
try {
    $db = new PDO('sqlite:za_numbers.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Crea la tabella numeri se non esiste già
    $db->exec("CREATE TABLE IF NOT EXISTS numeri (
        id INTEGER PRIMARY KEY,
        tipo TEXT,
        numero TEXT
    )");
} catch (PDOException $e) {
    die("Errore nella connessione al database: " . $e->getMessage());
}
?>
