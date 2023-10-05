<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];

        if ($file["error"] === UPLOAD_ERR_OK) {
            $tempFilePath = $file["tmp_name"];

            $fileType = mime_content_type($tempFilePath);
            if ($fileType === "text/csv" || $fileType === "application/csv" || $fileType === "application/vnd.ms-excel") {
                $csvData = file_get_contents($tempFilePath);

                $csvRows = explode("\n", $csvData);

                $isFirstRow = true;

                $validNumberSum = [];
                $updatedNumberSum = [];
                $invalidNumberSum = [];

                include 'database.php';

                try {
                    $db = new PDO('sqlite:za_numbers.db');
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Errore nella connessione al database: " . $e->getMessage());
                }

                foreach ($csvRows as $row) {
                    $row = trim($row);

                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }

                    $fields = explode(",", $row);
                    $phoneNumber = trim($fields[1]);

                    $validPattern = '/^27\d{9}$/';
                    $updatedPattern = '/^27\d{9}_DELETED_\d+$/';

                    if (preg_match($validPattern, $phoneNumber)) {
                        $validNumber = $phoneNumber;
                        array_push($validNumberSum, $validNumber);
                        echo "Numero valido: $phoneNumber<br>";

                        $stmt = $db->prepare("INSERT INTO numeri (tipo, numero) VALUES (:tipo, :numero)");
                        $stmt->bindParam(':tipo', $tipo);
                        $stmt->bindParam(':numero', $numero);

                        $tipo = 'valido';
                        $numero = $validNumber;
                        $stmt->execute();
                    } elseif (preg_match($updatedPattern, $phoneNumber)) {
                        $updatedNumber = $phoneNumber;
                        array_push($updatedNumberSum, $updatedNumber);
                        echo "Numero aggiornato: $phoneNumber<br>";

                        $stmt = $db->prepare("INSERT INTO numeri (tipo, numero) VALUES (:tipo, :numero)");
                        $stmt->bindParam(':tipo', $tipo);
                        $stmt->bindParam(':numero', $numero);

                        $tipo = 'aggiornato';
                        $numero = $updatedNumber;
                        $stmt->execute();
                    } else {
                        $invalidNumber = $phoneNumber;
                        array_push($invalidNumberSum, $invalidNumber);
                        echo "Numero non valido: $phoneNumber<br>";

                        $stmt = $db->prepare("INSERT INTO numeri (tipo, numero) VALUES (:tipo, :numero)");
                        $stmt->bindParam(':tipo', $tipo);
                        $stmt->bindParam(':numero', $numero);

                        $tipo = 'non valido';
                        $numero = $invalidNumber;
                        $stmt->execute();
                    }
                }
                
                // chiudere la connessione al database
                $db = null;
                
                echo "<br>";
                echo "Somma dei numeri validi: " . count($validNumberSum) . "<br>";
                echo "Somma dei numeri aggiornati: " . count($updatedNumberSum) . "<br>";
                echo "Somma dei numeri non validi: " . count($invalidNumberSum) . "<br>";
            } else {
                echo "Il file deve essere un CSV valido.";
            }
        } else {
            echo "Si è verificato un errore durante il caricamento del file.";
        }
    } else {
        echo "Nessun file è stato caricato.";
    }
}
?>
