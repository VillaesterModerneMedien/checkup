document.addEventListener('DOMContentLoaded', function() {
    var startScanBtn = document.getElementById('startScanBtn');
    startScanBtn.addEventListener('click', function() {
        startScanBtn.disabled = true;
        startScanBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Scan läuft';

        var backdrop = document.getElementById('backdrop');
        backdrop.classList.add('show');
        backdrop.classList.remove('hide');

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'start_scan.php', true);
        xhr.onload = function() {
            if (xhr.status !== 200) {
                alert('Fehler beim Starten des Scans: ' + xhr.statusText);
            }

            startScanBtn.disabled = false;
            startScanBtn.innerHTML = 'Neuen Scan starten';

            backdrop.classList.remove('show');
            backdrop.classList.add('hide');
            window.location.reload();
        };
        xhr.onerror = function() {
            alert('Fehler beim Starten des Scans');

            startScanBtn.disabled = false;
            startScanBtn.innerHTML = 'Neuen Scan starten';

            backdrop.classList.remove('show');
            backdrop.classList.add('hide');
        };
        xhr.send();
    });

    var viewButtons = document.getElementsByClassName('viewBtn');
    for (var i = 0; i < viewButtons.length; i++) {
        addViewButtonClickEvent(viewButtons[i]);
    }
});

function addViewButtonClickEvent(viewButton) {
    viewButton.addEventListener('click', function() {
        var filename = this.dataset.filename;

        var backdrop = document.getElementById('backdrop');
        backdrop.classList.add('show');
        backdrop.classList.remove('hide');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_scan_file_content.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var resultContentRows = document.querySelectorAll('tr .resultContent');
                resultContentRows.forEach(function(row) {
                    row.parentNode.removeChild(row);
                });

                var tableRow = document.createElement('tr');
                var tableData = document.createElement('td');
                tableData.setAttribute('colspan', '2');
                tableData.classList.add('resultContent');

                tableData.innerHTML = xhr.response;
                console.log(xhr.response)

                tableRow.appendChild(tableData);

                var buttonRow = viewButton.parentNode.parentNode;
                var parentTable = buttonRow.parentNode;
                parentTable.insertBefore(tableRow, buttonRow.nextSibling);
            } else {
                alert('Fehler beim Abrufen des Dateiinhalts: ' + xhr.statusText);
            }

            backdrop.classList.remove('show');
            backdrop.classList.add('hide');
        };
        xhr.onerror = function() {
            alert('Fehler beim Abrufen des Dateiinhalts');

            backdrop.classList.remove('show');
            backdrop.classList.add('hide');
        };
        xhr.send('filename=' + encodeURIComponent(filename));
    });
}
