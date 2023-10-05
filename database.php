<?php
try {
    $db = new PDO('sqlite:za_numbers.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tabella dei numeri
    $db->exec("CREATE TABLE IF NOT EXISTS numeri (
        id INTEGER PRIMARY KEY,
        tipo TEXT,
        numero TEXT
    )");

    // Tabella delle modifiche
    $db->exec("CREATE TABLE IF NOT EXISTS registro (
        id INTEGER PRIMARY KEY,
        id_num INTEGER,
        dettagli TEXT,
        data_modifica DATETIME,
        FOREIGN KEY (id_num) REFERENCES numeri (id)
    )");
} catch (PDOException $e) {
    die("Errore nella connessione al database: " . $e->getMessage());
}
?>
