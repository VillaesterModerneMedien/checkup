<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
        $filename = $_POST['filename'];
        $content = file_get_contents($filename);

        if ($content !== false) {
            echo $content;
        } else {
            echo 'Fehler beim Lesen der Datei.';
        }
    } else {
        echo 'Ungültige Anforderung.';
    }
?>
