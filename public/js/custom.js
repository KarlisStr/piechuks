document.addEventListener('DOMContentLoaded', function() {
    console.log("Document is ready. Setting up event listeners...");
    const rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            const pakalpojumaId = this.dataset.pakalpojumaId;
            fetchServiceDetails(pakalpojumaId);
        });
    });

    // Automatically select the first service in the table
    if (rows.length > 0) {
        rows[0].click();
    }
});

function fetchServiceDetails(pakalpojumaId) {
    fetch(`/service-details/${pakalpojumaId}`)
        .then(response => response.json())
        .then(data => {
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
                        <img src="${data.professional ? data.professional.profileImage : 'images/default-profile.png'}" alt="Profile Image" class="profile-image rounded-circle" style="width: 50px; height: 50px;">
                    </div>
                    <div class="col">
                        <p>${data.professional ? data.professional.name : 'No professional assigned'}</p>
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
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal2" >Pieteikties</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2" >Saglabāt</button>
            </div>
        </div>
    `;
}

