<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/img/za_favicon.png" type="png">
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
                <table id="numberTable" class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Numero</th>
                        </tr>
                    </thead>

                    <!-- <tbody id="tbody"> -->
                    <tbody>
                        <!-- dovrebbe esser riempito dalla funzione js -->
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    
    
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!--  -->
    <script>
        // funzione per ottenere e mostrare i numeri in base al filtro selezionato
        function loadNumbers(filter) {
            axios.get('api.php', {
                params: {
                    tipo: filter
                }
            })
            .then(response => {
                const tableBody = document.querySelector("#numberTable tbody");
                tableBody.innerHTML = '';
                
                if (response.data.error) {
                    tableBody.innerHTML = `<tr><td colspan="2">${response.data.error}</td></tr>`;
                } else {
                    response.data.forEach((numero, index) => {
                        tableBody.innerHTML += `<tr><td>${index + 1}</td><td>${numero}</td></tr>`;
                    });
                }
            })
            .catch(error => console.error('Errore durante il caricamento dei numeri:', error));
        }
        
        document.getElementById("filterSelect").addEventListener("change", function () {
            const selectedFilter = this.value;
            loadNumbers(selectedFilter);
        });
        
        // carica tutti i numeri all'avvio
        loadNumbers("all");
        
    </script>
</body>
</html>
