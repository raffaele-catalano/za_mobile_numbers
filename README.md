South Africa Mobile Numbers
===
## Technologie: 
- `PHP`
- `Javascript`
- `CSS`
- `HTML`

## Requisiti:
- Server web locale per eseguire l'applicazione;
- PHP 8.0 o versioni successive installate sul server.

## Installazione: 
1. Scaricare la cartella;
2. Estrarre il contenuto dell'archivio `ZIP` nella *directory* principale del server web locale (es. `htdocs` in MAMP o `www` in XAMPP);
3. Assicurarsi che il server web locale sia in esecuzione;
4. Aprire il browser web alla pagina: <a href="http://localhost/za_mobile_numbers-main">http://localhost/za_mobile_numbers-main</a>.

## Struttura del Progetto:
| File | Descrizione |
| ---     | ---   |
| `index.html` | Pagina iniziale dell'applicazione che visualizza un form di *upload* di un file che sia necessariamente `.csv` |
| `database.php` | Stabilisce la creazione, tramite protocollo `PDO`, di un nuovo database `SQLite` |
| `process.php` | Processa i dati del file `.csv` e permette la genesi del database SQLite (`za_numbers.db`) e lo *storage* dei dati al suo interno. Inoltre effettua la correzione dei numeri cosiddetti *'updated'*, i quali vengono convertiti in *'valid'* |
| `view.php` | Pagina finale dell'applicazione che visualizza l'elenco dei numeri e offre opzioni di filtro |
| `api.php` | Gestisce le richieste API per ottenere i numeri in base al filtro selezionato |
| `loadnumbers.js` | Contiene la funzione che gestisce la chiamata API per i numeri e la paginazione della tabella in cui questi vengono stampati |
| `za_numbers.db` | Il database SQLite che viene generato in seguito all'upload del file `.csv`.<br>Consta di due tabelle, una principale `numeri` ed una secondaria `registro`. Le due tabelle hanno una relazione `one to many` |
| `assets/` | Directory contenente foglio di stile CSS, immagini e altri asset tra cui il file `.csv` utilizzato |