<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Piecukslv</title><link rel="stylesheet" href="{{ asset('css/custom_pieteikties.css') }}?v={{ time() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold text-success fs-2 text" href="{{ route('home') }}">Piečuks.lv</a>
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
              <a class="nav-link text-success fs-5 text fw-bold" href="#">Reģistrēties</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <header class="text-center">
        <h4 class="text-success">Pieteikties!</h1>
    </header>
    
    <div id="sludinajumu_sekcija" class="container">
      <div class="row">
          <div class="col border">
                <div id="main_logs" href="#" class="content-container">
                    <div id="main_logs_user"class = "container">
                      <a href="#"><img src="images/boy.png" alt="user_image" class="rounded-circle"></a>

                      <a href="#"><p>Dins Gerke</p></a>
                    </div>
                    <div class="container">
                      <div class="row">
                        <div class="col">
                          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                              <div class="carousel-item active">
                                <img class="d-block w-100" src="images/OIP.jpeg" alt="First slide">
                              </div>
                              <div class="carousel-item">
                                <img class="d-block w-100" src="images/boy.png" alt="Second slide">
                              </div>
                              <div class="carousel-item">
                                <img class="d-block w-100" src="images/OIP.jpeg" alt="Third slide">
                              </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                          </div>
                        </div>
                        <div class="col">
                          <h2>Title</h2>
                          <h4>Lokācija</h4>
                          <h4>Cena</h4>
                        </div>
                        <div class="container">
                          <h2>Par pakalpojumu</h2>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                    </div>
              </div>
          </div>
        </div>
        <div class="col">
          <div id="input_virsraksts" class="list-group">
            <input class="form-control form-control-lg" type="text" placeholder="Ievadiet virsrakstu">
          </div>
          <div class="form-group">
            <textarea class="form-control form-control-lg" id="largeTextarea" rows="10" placeholder="Ievadiet tekstu"></textarea>
          </div> 
          <div id = "pieteikties" class="d-flex flex-row-reverse">
            <form action="{{ route('pieteikties') }}" method="GET">
              <button type="submit" class="btn btn-success">Pieteikties</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
