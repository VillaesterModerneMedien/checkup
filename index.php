<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkup</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
<div class="container">
    <h1>Checkup</h1>
    <button id="startScanBtn" class="btn btn-primary">Neuen Scan starten</button>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Datei</th>
            <th>Aktion</th>
        </tr>
        </thead>
        <tbody id="resultsRender">
        <?php
            $files = glob('results/*.html');
            rsort($files);
            foreach ($files as $file) {
                $filename = basename($file);
                $timestamp = str_replace(['.html'], '', $filename);
                $formatted_timestamp = DateTime::createFromFormat('YmdHis', $timestamp)->format('d.m.Y H:i:s');
                echo '<tr>';
                echo '<td>Checkup vom ' . $formatted_timestamp . '</td>';
                echo '<td><button class="viewBtn btn btn-primary" data-filename="' . $file . '">
                        Ansehen <span class="bi bi-eye"></span>
                      </button></td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.js"></script>
    <script src="assets/js/checkupGUIFunctions.js"></script>
</div>

<div id="backdrop" class="hide">
    <div class="loading-text">
        Checkup Ergebnis wird geladen.<br>
        Einen Moment Geduld bitte.
    </div>
    <div class="spinner"></div>
</div>
</body>
</html>
