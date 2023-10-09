<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/img/za_favicon.png" type="png">
    <!-- fontawesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==' crossorigin='anonymous'/>
    <!-- style -->
    <link rel="stylesheet" href="./assets/styles/style.css">
    <!--  -->
    <title>Za Mobile Numbers</title>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <h3>Seleziona un filtro</h3>
                <div class="input-group mb-3">
                    <select id="filterSelect" class="form-select">
                        <option value="all">Nessun filtro</option>
                        <option value="valid">Numeri validi</option>
                        <option value="invalid">Numeri non validi</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>Numeri</h3>
                <table id="numberTable" class="table table-dark table-striped w-50">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Numero</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <!-- qui vengono inseriti i dati tramite JavaScript -->
                    </tbody>
                </table>
                <!-- pagination -->
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item" id="prevPage">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="fa-solid fa-backward"></i></span>
                            </a>
                        </li>
                        <!-- Le pagine verranno create dinamicamente qui -->
                        <li class="page-item" id="nextPage">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true"><i class="fa-solid fa-forward"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!--  -->
            </div>
        </div>
    </div>
    
    
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!--  -->
    <script>
        const itemsPerPage = 15;
        let currentPage = 1;
        let dataToDisplay = [];

        // funzione per ottenere e mostrare i numeri in base al filtro selezionato
        function loadNumbers(filter) {
            axios.get('api.php', {
                params: {
                    tipo: filter
                }
            })
            .then(response => {
                dataToDisplay = response.data;
                currentPage = 1;
                renderData();
            })
            .catch(error => console.error('Errore durante il caricamento dei numeri:', error));
        }

        // cambio di filtro
        document.getElementById("filterSelect").addEventListener("change", function () {
            const selectedFilter = this.value;
            loadNumbers(selectedFilter);
        });

        // Listener per il click sulla paginazione precedente
        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                renderData();
            }
        });

        // click sulla paginazione successiva
        document.getElementById("nextPage").addEventListener("click", () => {
            const totalPages = Math.ceil(dataToDisplay.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderData();
            }
        });

        // rendering dei dati in base alla pagina corrente
        function renderData() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const slicedData = dataToDisplay.slice(start, end);

            const tableBody = document.querySelector("#tbody");
            tableBody.innerHTML = '';

            slicedData.forEach((numero, index) => {
                const rowNumber = start + index + 1;
                tableBody.innerHTML += `<tr><td>${rowNumber}</td><td>${numero}</td></tr>`;
            });

            // calcola il numero totale di pagine
            const totalPages = Math.ceil(dataToDisplay.length / itemsPerPage);

            // abilitazione/disabilitazione dei pulsanti Prev e Next
            const prevPageButton = document.getElementById("prevPage");
            const nextPageButton = document.getElementById("nextPage");
            if (currentPage === 1) {
                prevPageButton.classList.add("disabled");
            } else {
                prevPageButton.classList.remove("disabled");
            }
            if (currentPage === totalPages) {
                nextPageButton.classList.add("disabled");
            } else {
                nextPageButton.classList.remove("disabled");
            }
        }

        // Carica tutti i numeri all'avvio con filtro "all"
        loadNumbers("all");

    </script>
</body>
</html>
