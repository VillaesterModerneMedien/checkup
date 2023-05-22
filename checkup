#!/bin/bash

# Liest die Konfigurationseinstellungen aus der config.ini-Datei
config_file="config.ini"
absolute_path=$(awk -F "=" '/absolute_path/ && !/^;/ {print $2}' "$config_file")
checkup_dir=$(awk -F "=" '/checkup_dir/ && !/^;/ {print $2}' "$config_file")
exclude_dir=$(awk -F "=" '/exclude_dir/ && !/^;/ {print $2}' "$config_file")
singledir_scan=$(awk -F "=" '/singledir_scan/ && !/^;/ {print $2}' "$config_file")

# Echo der dir-Variablen
echo "absolute_path: $absolute_path"
echo "checkup_dir: $checkup_dir"
echo "exclude_dir: $exclude_dir"
echo "singledir_scan: $singledir_scan"
echo "singledir_scan: $absolute_path/$singledir_scan"

# Erstellt eine temporäre Datei und fügt die erste Zeile mit dem aktuellen Datum und der Uhrzeit ein
tmpfile=$(mktemp)
echo "<table class='resultsTable'>" > "$tmpfile"
#echo "<thead><tr><th>Datei</th><th>Aktion</th></tr></thead><tbody>" >> "$tmpfile"

# Funktion zum Durchsuchen von Dateien
function search_files() {
    local directory="$1"
    local pattern="$2"

    find "$directory" -type f -print0 | while IFS= read -rd '' file; do
        if egrep -iq "$pattern" "$file"; then
            echo "<tr><td class='resultHeadline'>Potenzieller Exploit gefunden in <a href=\"file://$file\">$file</a></td>" >> "$tmpfile"
            echo "<td><button class='btn-primary btnCodeview'><i class='bi bi-eye'></i> Code anzeigen</button></td></tr>" >> "$tmpfile"
        fi
    done
}

# Durchsucht die Dateien basierend auf den Konfigurationseinstellungen
if [ "$singledir_scan" != "" ]; then
    # Scan nur in einem einzigen Verzeichnis
    search_files "$absolute_path/$singledir_scan" "$sploitpattern"
else
    # Scan in allen Verzeichnissen außer den ausgeschlossenen Verzeichnissen
    exclude_dirs=""
    IFS=',' read -ra exclude_arr <<< "$exclude_dir"
    for dir in "${exclude_arr[@]}"; do
        exclude_dirs+="! -path \"$absolute_path/$dir\" "
    done

    search_files "$absolute_path/$checkup_dir" "$sploitpattern" $exclude_dirs
fi

# Schließt die Tabelle und verschiebt die temporäre Datei in den Checkup-Ordner im results-Unterordner mit der aktuellen Zeit als Dateiname
echo "</tbody></table>" >> "$tmpfile"
mv "$tmpfile" "$absolute_path/$checkup_dir/results/$(date +'%Y%m%d%H%M%S').html"

exit 0
