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