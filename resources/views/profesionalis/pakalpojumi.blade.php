@php
use Illuminate\Support\Str;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profesionalis Pakalpojumi</title>
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
                    <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('profesionalis.pieteikumi') }}">Mani pieteikumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-success fs-5 text fw-bold" href="{{ route('profesionalis.pakalpojumi') }}">Mani pakalpojumi</a>
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
<header class="text-center">
    <h4 class="text-success">Mani Pakalpojumi</h4>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Apraksts</th>
                    <th scope="col">Kategorija</th>
                    <th scope="col">Lokācija</th>
                    <th scope="col">Cena</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pakalpojumi as $pakalpojums)
                    <tr data-pakalpojuma-id="{{ $pakalpojums->pakalpojuma_id }}">
                        <td>{{ Str::limit($pakalpojums->apraksts, 50) }}</td>
                        <td>{{ $pakalpojums->kategorijas_nosaukums }}</td>
                        <td>{{ $pakalpojums->adrese }}</td>
                        <td class="text-end">{{ $pakalpojums->cena }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPakalpojumsModal">Pievienot jaunu pakalpojumu</button>
            </div>
        </div>
        <div class="col-md-6" id="serviceDetails">
            <!-- Details will be populated here based on selection -->
        </div>
    </div>
</div>

<!-- Add Pakalpojums Modal -->
<div class="modal fade" id="addPakalpojumsModal" tabindex="-1" aria-labelledby="addPakalpojumsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profesionalis.pakalpojumi.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addPakalpojumsModalLabel">Pievienot jaunu pakalpojumu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nosaukums" class="form-label">Nosaukums</label>
                        <input type="text" class="form-control" id="nosaukums" name="nosaukums" required>
                    </div>
                    <div class="mb-3">
                        <label for="apraksts" class="form-label">Apraksts</label>
                        <input type="text" class="form-control" id="apraksts" name="apraksts" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategorijas_nosaukums" class="form-label">Kategorija</label>
                        <select class="form-select" id="kategorijas_nosaukums" name="kategorijas_nosaukums" required>
                            <option value="Mājas Pakalpojumi">Mājas Pakalpojumi</option>
                            <option value="IT Pakalpojumi">IT Pakalpojumi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cena" class="form-label">Cena</label>
                        <input type="number" step="0.01" class="form-control" id="cena" name="cena" required>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="me-2 flex-grow-1">
                            <label for="iela_majasnr" class="form-label">Adrese</label>
                            <input type="text" class="form-control" id="iela_majasnr" name="iela_majasnr" placeholder="Upes iela 1" required>
                        </div>
                        <div class="flex-grow-1">
                            <label for="iela_majasnr" class="form-label">Pilsēta</label>
                            <input type="text" class="form-control" id="pilseta" placeholder="Rīga" name="pilseta" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Attēli</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const pakalpojumaId = this.dataset.pakalpojumaId;
                console.log('Clicked row with pakalpojumaId:', pakalpojumaId);
                fetchServiceDetails(pakalpojumaId);
            });
        });

        if (rows.length > 0) {
            rows[0].click(); // Automatically click the first row to load its details
        }

        document.getElementById('serviceDetails').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-danger')) {
                const pakalpojumaId = this.dataset.pakalpojumaId;
                handleDelete(pakalpojumaId);
            } else if (event.target.classList.contains('btn-success')) {
                const pakalpojumaId = this.dataset.pakalpojumaId;
                handleEdit(pakalpojumaId);
            }
        });
    });

    function fetchServiceDetails(pakalpojumaId) {
        fetch(`/service-details/${pakalpojumaId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Service details fetched:', data);
                document.getElementById('serviceDetails').innerHTML = renderServiceDetails(data);
                document.getElementById('serviceDetails').dataset.pakalpojumaId = pakalpojumaId; // Store the ID for future reference
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
                    <button type="button" class="btn btn-danger">Dzēst</button>
                    <button type="button" class="btn btn-success">Rediģēt</button>
                </div>
            </div>
        `;
    }

    function handleDelete(pakalpojumaId) {
        if (confirm('Vai tiešām vēlaties dzēst šo pakalpojumu?')) {
            fetch(`/delete-service/${pakalpojumaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    console.log('Service deleted:', pakalpojumaId);
                    window.location.reload(); // Reload the page to reflect the changes
                } else {
                    console.error('Failed to delete service:', pakalpojumaId);
                }
            })
            .catch(error => console.error('Error deleting service:', error));
        }
    }

    function handleEdit(pakalpojumaId) {
        window.location.href = `/edit-service/${pakalpojumaId}`;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
