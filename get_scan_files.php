<?php
    $scan_dir = '.';
    $files = scandir($scan_dir, SCANDIR_SORT_DESCENDING);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $timestamp = str_replace(['Checkup-', '.html'], '', $file);
            $formatted_timestamp = DateTime::createFromFormat('YmdHis', $timestamp)->format('d.M.Y H:i:s');
            echo "<tr>
                <td>Checkup - $formatted_timestamp</td>
                <td><a href=\"$file\" target=\"_blank\">Ansehen22</a></td>
              </tr>";
        }
    }
