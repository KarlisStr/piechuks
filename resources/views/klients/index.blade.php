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
                        <th scope="col"><span class="sortable">Apraksts</span></th>
                        <th scope="col"><span class="sortable">Kategorija</span></th>
                        <th scope="col"><span class="sortable">Lokācija</span></th>
                        <th scope="col"><span class="sortable">Cena</span></th>
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

<script src="{{ asset('js/klients.js') }}?v={{ time() }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
