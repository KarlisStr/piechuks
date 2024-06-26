@php
use Illuminate\Support\Str;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Piecukslv</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-success fs-2 text" href="#">Piečuks.lv</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="#">Mani pieteikumi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="#">Mani pakalpojumi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('register') }}">Reģistrēties\Ienākt</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="text-center">
        <h4 class="text-success">Kad pat tavi draugi saka, ka Tev vajag profesionālu palīdzību!</h4>
    </header>
    <div class="container">
        <div class="row">
            <!-- Left Column for Table -->
            <div class="col-md-6">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><span class="sortable" data-sort="apraksts">Apraksts</span></th>
                            <th scope="col"><span class="sortable" data-sort="kategorijas_nosaukums">Kategorija</span></th>
                            <th scope="col"><span class="sortable" data-sort="lokacija">Adrese</span></th>
                            <th scope="col"><span class="sortable" data-sort="cena">Cena</span></th>
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
            </div>
            <!-- Right Column for Service Details -->
            <div class="col-md-6" id="serviceDetails">
                <!-- Details will be populated here based on selection -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

            const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
                v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
            )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

            document.querySelectorAll('span.sortable').forEach(span => span.addEventListener('click', function() {
                const table = span.closest('table');
                Array.from(table.querySelectorAll('tbody > tr'))
                    .sort(comparer(Array.from(span.parentNode.parentNode.children).indexOf(span.parentNode), this.asc = !this.asc))
                    .forEach(tr => table.querySelector('tbody').appendChild(tr));

                table.querySelectorAll('span.sortable').forEach(span => {
                    span.classList.remove('sorted-asc', 'sorted-desc');
                });

                span.classList.toggle('sorted-asc', this.asc);
                span.classList.toggle('sorted-desc', !this.asc);
            }));
        });
    </script>
    <script src="{{ asset('js/custom.js') }}?v={{ time() }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
