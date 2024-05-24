<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
  <title>
    SIMPI | Galeri Pemancingan
  </title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery dan Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

  <style>
    .fixed-image {
      width: 100%;
      height: 150px;
      object-fit: cover;
      object-position: center;
    }

    .fixed-image2 {
      width: 100%;
      height: 200px;
      object-fit: cover;
      object-position: center;
    }

    .card-body2 {
      padding-left: 10px;
      padding-top: 5px;
    }

    .card-title2 {
      margin-bottom: 2px;
    }

    .card-text2 {
      margin-bottom: 5px;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('Guest.Layouts.navbar')

    <div class="container-fluid py-2">
        <div class="mt-3 mb-2">
            <a href="3"><i class="fa fa-arrow-left mt-3" style="font-size: 14pt;"></i></a>
            <a class="font-weight-bolder mt-4 mb-3 ms-3" style="font-size: 20pt"><b>Galeri Pemancingan</b></a>
        </div>
    <div class="row mb-4 gx-2">
          @foreach($images as $image)
          <div class="col-lg-4 col-md-4 col-sm-12 col-4 g-2">
            @if($image->filename)
            <div class="card text-bg-light">
              <!-- Tambahkan tombol maximize -->
              <div class="position-absolute top-0 end-0 p-1" style="z-index: 999;">
                <button class="btn btn-transparent maximize" data-image="{{ asset('images/' . $image->filename) }}">
                  <i class="fa fa-expand" style="color: black"></i>
                </button>
              </div>
              <img class="card-img" src="{{ asset('images/' . $image->filename) }}" alt="{{ asset('images/' . $image->filename) }}" style="max-height: 250px;">
            </div>
            @endif
          </div>
          @endforeach
        </div>
        <!-- Modal Maximize -->
        <div>
          <div class="modal fade" id="maximizeModal" tabindex="-1" aria-labelledby="maximizeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <!-- Tombol close modal -->
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                  <img id="maximizedImage" src="#" class="img-fluid" alt="Gambar Diperbesar"
                    style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- Cek ada data atau kosong --}}
        @if($images->isEmpty())
          <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
        @endif
    </div>

    <footer class="footer pl-0 pb-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              SIMPI | Sistem Manajemen Pemancingan Ikan
            </div>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <div class="modal fade" id="maximizeModal" tabindex="-1" role="dialog" aria-labelledby="maximizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img id="maximizedImage" src="" class="img-fluid" alt="Maximized Image">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('.maximize').on('click', function() {
        const imageUrl = $(this).data('image');
        $('#maximizedImage').attr('src', imageUrl);
        $('#maximizeModal').modal('show');
      });
    });
  </script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>
</html>
