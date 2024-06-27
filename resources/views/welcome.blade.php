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
                        <a class="nav-link text-success fs-5 text fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">Mani pieteikumi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Mani pakalpojumi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success fs-5 text fw-bold" href="{{ route('register') }}">Reģistrēties\Ienākt</a>
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
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Uzmanību!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Jūs neēsat reģistrējies kā klients.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aizvērt</button>
                </div>
            </div>
        </div>
    </div>

    <header class="text-center">
        <h4 class="text-success">Kad pat tavi draugi saka, ka Tev vajag profesionālu palīdzību!</h4>
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
                <div class="d-flex justify-content-center">
                {{ $pakalpojumi->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </div>
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
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal2">Pieteikties</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">Saglabāt</button>
                    </div>
                </div>
            `;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
