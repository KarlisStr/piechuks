document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Row clicked, fetching service details...');
            const pakalpojumaId = this.dataset.pakalpojumaId;
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
    const images = data.images.map(image => `<div class="carousel-item"><img class="d-block w-100" src="${image.url}" alt="Service Image"></div>`).join('');
    return `
        <div class="service-details">
            <h2>${data.title}</h2>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="${data.images.length ? data.images[0].url : 'images/default-profile.png'}" alt="Service Image">
                    </div>
                    ${images}
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
            <p>${data.description}</p>
            <div class="profesionali-details">
                <img src="${data.professional.profileImage}" alt="Profile Image" class="profile-image" width="100" height="100">
                <p>${data.professional.name}</p>
            </div>
            <div class="action-buttons">
                <button type="button" class="btn btn-success">Pieteikties</button>
                <button type="button" class="btn btn-secondary">Saglabāt</button>
            </div>
        </div>
    `;
}
