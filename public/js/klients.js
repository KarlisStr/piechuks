document.addEventListener('DOMContentLoaded', function() {
    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
        (!isNaN(parseFloat(v1)) && !isNaN(parseFloat(v2)) ? v1 - v2 : v1.toString().localeCompare(v2))
    )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    let lastSortedColumn = null;

    document.querySelectorAll('.sortable').forEach(span => {
        span.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const idx = Array.from(this.parentNode.parentNode.children).indexOf(this.parentNode);
            const isAsc = this.classList.toggle('sorted-asc');
            const isDesc = this.classList.toggle('sorted-desc', !isAsc);

            Array.from(tbody.querySelectorAll('tr'))
                .sort(comparer(idx, isAsc))
                .forEach(tr => tbody.appendChild(tr));

            if (lastSortedColumn && lastSortedColumn !== this) {
                lastSortedColumn.classList.remove('sorted-asc', 'sorted-desc');
            }
            lastSortedColumn = this;
            if (tbody.querySelectorAll('tr').length > 0) {
                tbody.querySelector('tr').click();
            }
            
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.table tbody tr');

    function selectRow(row) {
        // Remove the selected class from all rows
        rows.forEach(r => r.classList.remove('selected-row'));
        // Add the selected class to the clicked row
        row.classList.add('selected-row');
    }

    rows.forEach(row => {
        row.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Row clicked, fetching service details...');
            const pakalpojumaId = this.dataset.pakalpojumaId;
            selectRow(this); // Mark the row as selected
            fetchServiceDetails(pakalpojumaId);
        });
    });

    if (rows.length > 0) {
        rows[0].click(); // Automatically click the first row to load its details
    }
});

function fetchServiceDetails(pakalpojumaId) {
    fetch(`/service-details/${pakalpojumaId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Service details fetched:', data);
            document.getElementById('serviceDetails').innerHTML = renderServiceDetails(data);
        })
        .catch(error => console.error('Error fetching service details:', error));
}

function renderServiceDetails(data) {
    const images = data.images.map((image, index) => `
        <div class="carousel-item ${index === 0 ? 'active' : ''}">
            <img class="d-block w-100" src="${image.url}" alt="Service Image">
        </div>`
    ).join('');
 
    return `
        <div class="service-details">
                    <div class="profesionali-details">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="${data.professional.profileImage}" alt="Profile Image" class="profile-image" style="width: 50px; height: 50px;">
                    </div>
                    <div class="col">
                        <p>${data.professional.name}</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="padding-top:20px; width: 300px; height: 200px; overflow: hidden;">
                            <div class="carousel-inner">
                                ${images}
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <p style="padding-top: 10px; font-weight: bold;"> ${data.title}</p>
                         <p style="padding-top: 10px; font-weight: bold;">Kategorija: ${data.category}</p>
                        <p style="padding-top: 10px; font-weight: bold;">Lokācija: ${data.address}</p>
                        <p style="padding-top: 10px; font-weight: bold;">Cena: ${data.price} €</p>
                    </div>
                </div>
            </div>
            <p style="padding-top: 10px; font-weight: bold;">Par pakalpojumu:</p>
            <p>${data.description}</p>
            <div class="action-buttons">
                <button type="button" class="btn btn-success">Pieteikties</button>
                <button type="button" class="btn btn-secondary">Saglabāt</button>
            </div>
        </div>
    `;
}
