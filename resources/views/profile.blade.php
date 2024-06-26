<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-success fs-2 text" href="{{ auth()->user()->is_professional ? route('profesionalis.index') : route('klients.index') }}">
                Piečuks.lv
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(auth()->user()->is_professional)
                        <li class="nav-item">
                            <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('profesionalis.pieteikumi') }}">Mani pieteikumi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('profesionalis.pakalpojumi') }}">Mani pakalpojumi</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-success fs-5 text fw-bold" href="#">Mani pakalpojumi</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="#">{{ Auth::user()->name }} <img src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->image_path) : asset('images/default-profile.png') }}" class="rounded-circle" width="30" height="30" alt="Profile Image"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="text-center">
        <h4 class="text-success">Kad pat tavi draugi saka, ka Tev vajag profesionālu palīdzību!</h1>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Profile</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled>
                    </div>
                    @if($user->is_professional)
                        <div class="mb-3">
                            <label for="telefons" class="form-label">Telefons</label>
                            <input type="text" class="form-control" id="telefons" name="telefons" value="{{ $profileData->telefons }}">
                        </div>
                        <div class="mb-3">
                            <label for="bankas_konts" class="form-label">Bankas Konts</label>
                            <input type="text" class="form-control" id="bankas_konts" name="bankas_konts" value="{{ $profileData->bankas_konts }}">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                        @if($user->profileImage)
                        <img src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->image_path) : asset('images/default-profile.png') }}" class="mt-2" width="100" height="100" alt="Profile Image">
                        @else
                            <img src="images/default-profile.png" class="mt-2" width="100" height="100" alt="Default Profile Image">
                        @endif
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </form>
                <div class="mt-3">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
