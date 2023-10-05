<?php
$sum = 0;

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
                foreach ($csvRows as $row) {
                    $row = trim($row);

                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }

                    $fields = explode(",", $row);
                    $phoneNumber = trim($fields[1]);

                    $pattern = '/^(\+27\d{9})$/';
                    if (preg_match($pattern, $phoneNumber)) {
                        $validNumber = (int) $phoneNumber;
                        $sum += $validNumber;
                        echo "Numero valido: $phoneNumber<br>";
                    } else {
                        echo "Numero non valido: $phoneNumber<br>";
                    }
                }
                echo "Somma dei numeri validi: $sum";
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
