@php
use Illuminate\Support\Str;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klients Galvenā lapa</title>
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
                    <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('klients.klients_pieteikumi') }}">Mani pieteikumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success fs-5 text fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Mani pakalpojumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('profile.show') }}">{{ Auth::user()->name }} <img src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->image_path) : asset('images/default-profile.png') }}" class="rounded-circle" width="30" height="30" alt="Profile Image"></a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-success fs-5 text fw-bold">Logout</button>
                    </form>
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
    <h4 class="text-success">Kad pat tavi draugi saka, ka Tev vajag profesionālu palīdzību!</h1>
</header>
<div class="container">
    <div class="row">
        <!-- Left Column for Table -->
        <div class="col-md-6">
            <button type="button" class="btn btn-light mb-3" data-bs-toggle="modal" data-bs-target="#filterModal" id="filterButton">Filtrēt Meklēšanu</button>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Apraksts</th>
                        <th scope="col">Kategorija</th>
                        <th scope="col">Lokācija</th>
                        <th scope="col">Cena</th>
                    </tr>
                </thead>
                <tbody id="pakalpojumiTableBody">
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
        </div>

        <!-- Right Column for Service Details -->
        <div class="col-md-6" id="serviceDetails">
            <!-- Details will be populated here based on selection -->
        </div>
    </div>
</div>

<!-- Filter Modal -->
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
                    <div class="mb-3">
                        <label for="adrese" class="form-label">Adrese</label>
                        <input type="text" class="form-control" id="adrese" name="adrese" required>
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
</script>
<script src="{{ asset('js/klients.js') }}?v={{ time() }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
