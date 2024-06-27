@php
use Illuminate\Support\Str;
use Carbon\Carbon;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mani Pieteikumi</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-success fs-2 text" href="{{ auth()->user()->is_professional ? route('profesionalis.index') : route('klients.index') }}">Piečuks.lv</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('klients.pieteikumi') }}">Mani pieteikumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success fs-5 text fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Mani pakalpojumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('profile.show') }}">
                        {{ Auth::user()->name }}
                        <img src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->image_path) : asset('images/default-profile.png') }}" class="rounded-circle" width="30" height="30" alt="Profile Image">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uzmanību!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Jūs neēsat reģistrējies kā profesionālis.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvērt</button>
            </div>
        </div>
    </div>
</div>

<header class="text-center">
    <h4 class="text-success">Mani Pieteikumi</h4>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col"><span class="sortable">Pakalpojums</span></th>
                    <th scope="col"><span class="sortable">Laiks</span></th>
                    <th scope="col"><span class="sortable">Statuss</span></th>
                </tr>
                </thead>
                <tbody>
                @foreach($pieteikumi as $pieteikums)
                    <tr data-pieteikuma-id="{{ $pieteikums->pieteikums_id }}">
                    <td>{{ Str::limit($pieteikums->pakalpojums->nosaukums, 50) }}</td>
                        <td>{{ Carbon::parse($pieteikums->laiks)->format('H:i m-d') }}</td>
                        <td class="{{ $pieteikums->statuss == 0 ? 'status-neapstiprinats' : ($pieteikums->statuss == 1 ? 'status-apstiprinats' : 'status-noraidits') }}">
                            {{ $pieteikums->statuss == 0 ? 'Neapstiprināts' : ($pieteikums->statuss == 1 ? 'Apstiprināts' : 'Noraidīts') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $pieteikumi->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
        <div class="col-md-6" id="serviceDetails">
            <!-- Details will be populated here based on selection -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.table tbody tr');
    let selectedRow = null;

    rows.forEach(row => {
        row.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Row clicked, fetching service details...');
            const pieteikumaId = this.dataset.pieteikumaId;

            // Remove the 'selected-row' class from the previously selected row
            if (selectedRow) {
                selectedRow.classList.remove('selected-row');
            }

            // Add the 'selected-row' class to the clicked row
            this.classList.add('selected-row');
            selectedRow = this;

            fetchServiceDetails(pieteikumaId);
        });
    });

    if (rows.length > 0) {
        // Automatically click the first row to load its details
        rows[0].click();
    }

        document.getElementById('serviceDetails').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-danger')) {
                const pieteikumaId = this.dataset.pieteikumaId;
                handleDelete(pieteikumaId);
            } else if (event.target.classList.contains('btn-success')) {
                const pieteikumaId = this.dataset.pieteikumaId;
                handleEdit(pieteikumaId);
            }
        });
    });

    function fetchServiceDetails(pieteikumaId) {
        fetch(`/pieteikums-details/${pieteikumaId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Service details fetched:', data);
                document.getElementById('serviceDetails').innerHTML = renderServiceDetails(data);
                document.getElementById('serviceDetails').dataset.pieteikumaId = pieteikumaId; // Store the ID for future reference
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
                        <img src="${data.professional.profileImage}" alt="Profile Image" class="profile-image rounded-circle" style="width: 50px; height: 50px;">
                    </div>
                    <div class="col">
                        <p>${data.professional.name}</p>
                        <p>${data.professional.phone}</p>
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
                        <p style="padding-top: 10px; font-weight: bold;">${data.title}</p>
                        <p style="padding-top: 10px; font-weight: bold;">Cena: ${data.price} €</p>
                        <p style="padding-top: 10px; font-weight: bold;">Laiks: ${formatDateTime(data.laiks)}</p>
                        <p style="padding-top: 10px; font-weight: bold;">Statuss: ${data.statuss == 0 ? 'Neapstiprināts' : 'Apstiprināts'}</p>
                    </div>
                </div>
            </div>
            <p style="padding-top: 10px; font-weight: bold;">Pieteikuma teksts:</p>
            <p>${data.description}</p>
            <div class="action-buttons">
                <button type="button" class="btn btn-danger">Dzēst</button>
                <button type="button" class="btn btn-success">Rediģēt</button>
            </div>
        </div>
    `;
}
function formatDateTime(dateTimeString) {
    const dateTime = new Date(dateTimeString);
    const year = dateTime.getFullYear();
    const month = String(dateTime.getMonth() + 1).padStart(2, '0');
    const day = String(dateTime.getDate()).padStart(2, '0');
    const hours = String(dateTime.getHours()).padStart(2, '0');
    const minutes = String(dateTime.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}  ${month}-${day}`;
}

    function handleDelete(pieteikumaId) {
        if (confirm('Vai tiešām vēlaties dzēst šo pieteikumu?')) {
            fetch(`/delete-pieteikums/${pieteikumaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    console.log('Pieteikums deleted:', pieteikumaId);
                    window.location.reload(); // Reload the page to reflect the changes
                } else {
                    console.error('Failed to delete pieteikums:', pieteikumaId);
                }
            })
            .catch(error => console.error('Error deleting pieteikums:', error));
        }
    }

    function handleEdit(pieteikumaId) {
        window.location
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
