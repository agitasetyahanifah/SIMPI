<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  {{-- <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png"> --}}
  <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
  <title>
    SIMPI | Landing Page
  </title>
  <!--     Fonts and icons     -->
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
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- jQuery dan Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

  <style>
    .fixed-image {
      width: 100%;
      height: 150px; /* Tinggi tetap */
      object-fit: cover; /* Agar gambar sesuai dengan ukuran tanpa merusak proporsi */
      object-position: center; /* Pusatkan gambar */
    }

    .fixed-image2 {
      width: 100%;
      height: 200px; /* Tinggi tetap */
      object-fit: cover; /* Agar gambar sesuai dengan ukuran tanpa merusak proporsi */
      object-position: center; /* Pusatkan gambar */
    }

    .card-body2 {
      padding-left: 10px;
      padding-top: 5px;
    }

    .card-title2 {
        margin-bottom: 2px; /* Kurangi margin bawah */
    }

    .card-text2 {
        margin-bottom: 5px; /* Kurangi margin bawah */
    }

  </style>
    
</head>

<body class="g-sidenav-show  bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  
    @include('Member.Layouts.navbar')

    {{-- Content --}}
    <div class="container-fluid py-2">

      {{-- Ketersediaan Spot Pemancingan dan Informasi Cuaca --}}
      <div class="row row-cols-md-2">
        {{-- Ketersediaan Spot Pemancingan --}}
        <div class="col-md-4 mt-2">
          <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-6 mb-md-0">
                        <h5 class="font-weight-bolder">Ketersediaan Spot Pemancingan</h5>
                        <small class="text-muted">Terakhir diperbarui pada: {{ $waktuTerbaru }}</small>
                      </div>
                      <div class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-2">
                        <a class="btn btn-outline-primary" style="font-size: 25pt">{{ $terakhirDiperbaruiKetersediaan }}</a>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        {{-- Informasi Cuaca --}}
        <div class="col-md-8 mt-2">
          <div class="col-12">
              <div class="card shadow-sm border-0">
                  <div class="card-body">
                      <div class="row">
                          <h5 class="font-weight-bolder">Informasi Cuaca</h5>
                      </div>
                      <div class="row mt-3">
                          <div class="col">

                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>

      {{-- Card Body --}}
      <div class="card-body">
        {{-- Start Galeri Pemancingan --}}
        <h3 class="text-center mt-4 mb-3">Galeri Pemancingan</h3>
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
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.galeri.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div>
        {{-- End Galeri Pemancingan --}}

        {{-- Start Blog Pemancingan --}}
        @php
          use Illuminate\Support\Str;
        @endphp
        {{-- Konten Blog --}}
        <div class="row">
          <h3 class="text-center mt-4 mb-4">Blog Pemancingan</h3>
          <div class="col-12 d-flex flex-wrap mb-2">
            <div class="row g-2">
              @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                  <div class="card h-100">
                    @if($blog->image && file_exists(public_path('images/'.$blog->image)))
                      <img src="{{ asset('images/'.$blog->image) }}" class="card-img-top fixed-image" alt="{{ $blog->judul }}">
                    @else
                      <img src="https://source.unsplash.com/random/450x150?fishing" class="card-img-top fixed-image" alt="Fishing Image">
                    @endif
                    <div class="card-body">
                      <h5 class="card-title">{{ $blog->judul }}</h5>
                      <p class="card-text">{{ Str::words(strip_tags($blog->body), 12, '...') }} <a href="#" style="color: aqua;">Selengkapnya</a></p>
                      <small class="text-muted mt-2">Last updated {{ $blog->updated_at->diffForHumans() }}</small>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        {{-- Cek ada data atau kosong --}}
        @if($blogs->isEmpty())
          <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
        @endif
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.blog.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div> 
        {{-- End Blog Pemancingan --}}

        {{-- Start Daftar Alat Pancing --}}
        <h3 class="text-center mt-4 mb-3">Daftar Alat Pancing yang Disewakan</h3>
        {{-- Daftar Alat Pancing --}}
        <div class="row gx-2 mb-4">
          @foreach($alatPancing as $alat)
          <div class="col-lg-2 col-md-3 col-sm-4 col-4 g-1 mb-1">
            <div class="card h-100">
              <div class="card">
                @if($alat->foto && file_exists(public_path('images/'.$alat->foto)))
                  <img src="{{ asset('images/'.$alat->foto) }}" class="card-img-top fixed-image" alt="{{ $alat->nama_alat }}">
                @else
                   <img src="https://source.unsplash.com/random/450x450?fishing" class="card-img-top fixed-image" alt="Fishing Image">
                @endif
                <div class="card-body2">
                    <h5 class="card-title2">{{ $alat->nama_alat }}</h5>
                    <p class="card-text2" style="color: orangered;">Rp {{ number_format($alat->harga, 0, ',', '.') }}/hari</p>
                    <div class="text-center">
                      <a href="#" class="btn btn-primary mt-2">Detail</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        {{-- Cek ada data atau kosong --}}
        @if($alatPancing->isEmpty())
          <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
        @endif
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.daftar-alat.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div>   
        {{-- End Daftar Alat Pancing --}}
      </div> {{-- End Card Body --}}

      {{-- Lokasi Pemancingan --}}
      <div class="col mt-4">
        <div class="col-12">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <div class="row">
     
                <!-- Lokasi -->
                  <h5 class="card-title mb-3"><b>Lokasi Pemancingan</b></h5>
                  <div class="card-img">
                    <div id="map-container" style="height: 300px;">
                      <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.3856887394672!2d110.74229609999999!3d-7.532844599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a149ddf20b1c5%3A0xb967e9b36ae5bd62!2sPT.%20LegendNET%20Indonesia!5e0!3m2!1sid!2sid!4v1716319883143!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                      </iframe>
                    </div>
                  </div>

                <!-- Sosial Media -->
                <h5 class="card-title mt-4  "><b>Sosial Media</b></h5>
                <ul class="list-unstyled d-flex flex-wrap">
                  <li class="me-2 mb-2">
                    <a href="#" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                      <i class="fa fa-facebook me-2" style="font-size: 15px"></i> Facebook
                    </a>
                  </li>
                  <li class="me-2 mb-2">
                    <a href="#" class="btn btn-outline-info btn-sm d-flex align-items-center">
                      <i class="fa fa-twitter me-2" style="font-size: 15px"></i> Twitter
                    </a>
                  </li>
                  <li class="me-2 mb-2">
                    <a href="#" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                      <i class="fa fa-instagram me-2" style="font-size: 15px"></i> Instagram
                    </a>
                  </li>
                  <li class="me-2 mb-2">
                    <a href="#" class="btn btn-outline-warning btn-sm d-flex align-items-center">
                      <i class="fa fa-linkedin me-2" style="font-size: 15px"></i> LinkedIn
                    </a>
                  </li>
                </ul>

              </div>
            </div>
          </div>
        </div>
      </div>
    
    </div> {{-- End Container --}}

    {{-- Footer --}}
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
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#fff",
          data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              display: false
            },
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#FF9940",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
    $(document).ready(function() {
        // Menangani klik tombol maximize
        $('.maximize').on('click', function() {
            const imageUrl = $(this).data('image');
            $('#maximizedImage').attr('src', imageUrl);
            $('#maximizeModal').modal('show');
        });
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>

</body>

</html>