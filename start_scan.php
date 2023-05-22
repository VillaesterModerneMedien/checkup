<?php

    // Stellt sicher, dass das Skript lange genug läuft, um den Scan zu starten
    set_time_limit(0);

    // Liest die Konfigurationseinstellungen aus der config.ini-Datei
    $config_file = "config.ini";
    $config = parse_ini_file($config_file);

    // Überprüft, ob die config.ini-Datei erfolgreich gelesen wurde
    if ($config === false) {
        http_response_code(500);
        echo "Fehler beim Lesen der Konfiguration.";
        exit();
    }

    // Löscht die error.log vor jedem neuen Scan
    if (file_exists('error.log')) {
        unlink('error.log');
    }

    $checkup_dir = $config['checkup_dir'];
    $absolute_path = $config['absolute_path'];
    $checkup_script_path = "./$checkup_dir/checkup";

    //$test = exec('echo $PATH;');
    $output = shell_exec("source checkup 2> error.log");
    $errorContent = file_get_contents('error.log');

    echo '<pre>';
    var_dump($output);
    echo '</pre>';

    echo '<pre>';
    var_dump($errorContent);
    echo '</pre>';

    if ($output === null) {
        http_response_code(500);
        echo "Fehler beim Ausführen des Skripts.\n";

        if ($errorContent !== false) {
            echo "Fehlerdetails: \n" . $errorContent;
        }
    } else {
        echo "Skript erfolgreich gestartet.";
    }
?>
