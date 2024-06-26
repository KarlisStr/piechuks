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
                            <td>{{ optional($pakalpojums->lokacija)->adrese }}</td>
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
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="filterForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtrēt Meklēšanu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="savedServices" name="savedServices">
                        <label class="form-check-label" for="savedServices">Saglabātie Pakalpojumi</label>
                    </div>
                    <div class="mb-3">
                        <label for="priceMin" class="form-label">Cena</label>
                        <div class="d-flex">
                            <input type="number" class="form-control" id="priceMin" name="priceMin" placeholder="Min">
                            <input type="number" class="form-control ms-2" id="priceMax" name="priceMax" placeholder="Max">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategorija</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Visas</option>
                            @foreach($kategorijas as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Pilsēta</label>
                        <select class="form-select" id="city" name="city">
                            <option value="">Visas</option>
                            <!-- Populate cities here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Meklēt pēc atslēgvārda</label>
                        <input type="text" class="form-control" id="keyword" name="keyword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvērt</button>
                    <button type="button" class="btn btn-success" id="applyFilters">Meklēt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/klients.js') }}?v={{ time() }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
