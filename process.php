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

                foreach ($csvRows as $row) {
                    $row = trim($row);

                    $pattern = '/^(\+27\d{9})$/';
                    if (preg_match($pattern, $row)) {
                        echo "Numero valido: $row<br>";
                    } else {
                        echo "Numero non valido: $row<br>";
                    }
                }
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
