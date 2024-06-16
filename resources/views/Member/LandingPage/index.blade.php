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

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">

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

    .weather-container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .current-weather {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 20px;
    }

    .weather-header {
        display: flex;
        align-items: center;
    }

    .weather-icon {
        font-size: 64px;
        margin-right: 20px;
    }

    .weather-info {
        display: flex;
        flex-direction: column;
    }

    .temp {
        font-size: 48px;
        font-weight: bold;
    }

    .details span {
        display: block;
    }

    .location-info {
        text-align: right;
    }

    .location {
        font-size: 24px;
    }

    .day, .condition {
        font-size: 16px;
        color: #666;
    }

    .weather-details {
        margin-top: 20px;
    }

    .tabs {
        display: flex;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
    }

    .tab.active {
        border-bottom: 2px solid #ffcc00;
        color: #ffcc00;
    }

    .chart {
        text-align: center;
        height: 150px;
    }

    .chart canvas {
        max-width: 100%;
        height: 100%;
    }

    .weekly-forecast {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .day-forecast {
        text-align: center;
        width: 11%;
    }

    .day-forecast .day {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .day-forecast .icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .day-forecast .temp {
        font-size: 14px;
        color: #666;
    }

  </style>
    
</head>

<body class="g-sidenav-show  bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  
    @include('Member.Layouts.navbar')

    {{-- Content --}}
    <div class="container-fluid py-2">

      {{-- Informasi Cuaca --}}
      <div class="col-md-12 mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                  <div class="current-weather">
                      <div class="weather-header">
                          <div class="weather-icon">
                              <i class="wi wi-day-sunny"></i>
                          </div>
                          <div class="weather-info">
                              <div class="temp">32°C</div>
                              <div class="details">
                                  <span>Presipitasi: 0%</span>
                                  <span>Kelembapan: 77%</span>
                                  <span>Angin: 16 km/h</span>
                              </div>
                          </div>
                      </div>
                      <div class="location-info">
                          <div class="location">Cuaca</div>
                          <div class="day">Minggu</div>
                          <div class="condition">Sebagian besar cerah</div>
                      </div>
                  </div>
                  <div class="weather-details">
                      <div class="chart">
                          <canvas id="weatherChart"></canvas>
                      </div>
                  </div>
                  <div class="weekly-forecast">
                      <div class="day-forecast">
                          <div class="day">Min</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Sen</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">33° 23°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Sel</div>
                          <div class="icon"><i class="wi wi-rain"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Rab</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Kam</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Jum</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Sab</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
                      </div>
                      <div class="day-forecast">
                          <div class="day">Min</div>
                          <div class="icon"><i class="wi wi-day-cloudy"></i></div>
                          <div class="temp">32° 22°</div>
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
            <a href="{{ route('member.galeri.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
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
                      <p class="card-text">{{ Str::words(strip_tags($blog->body), 12, '...') }} <a href="{{ route('member.blog.detail-blog', $blog->id) }}" style="color: aqua;">Selengkapnya</a></p>
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
            <a href="{{ route('member.blog.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
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
                   {{-- <img src="https://source.unsplash.com/random/450x450?fishing" class="card-img-top fixed-image" alt="Fishing Image"> --}}
                   <img src="{{ asset('../images/logo.png') }}" class="card-img-top fixed-image" alt="Default Image">
                @endif
                <div class="card-body2">
                    <h5 class="card-title2">{{ $alat->nama_alat }}</h5>
                    <p class="card-text2" style="color: orangered;">Rp {{ number_format($alat->harga, 0, ',', '.') }}/hari</p>
                    <div class="text-center">
                      <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}">Detail</button>
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
            <a href="{{ route('member.daftar-alat.index') }}" class="btn btn-primary btn-sm rounded-pill">Lainnya <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div>   
        <!-- Modal Detail Alat Pancing -->
        @foreach($alatPancing as $alat)
        <div class="modal fade" id="detailModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $alat->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $alat->id }}">Detail Alat Pancing</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                              @if($alat->foto && file_exists(public_path('images/'.$alat->foto)))
                                <img src="{{ asset('images/'.$alat->foto) }}" class="img-fluid" alt="{{ $alat->nama_alat }}">
                              @else
                                {{-- <img src="https://source.unsplash.com/random/450x450?fishing" class="img-fluid" alt="Fishing Image"> --}}
                                <img src="{{ asset('../images/logo.png') }}" class="img-fluid" alt="Default Image">
                              @endif                        
                            </div>
                            <div class="col-md-6">
                                <h5>{{ $alat->nama_alat }}</h5>
                                <p>Harga: {{ number_format($alat->harga, 0, ',', '.') }} /hari</p>
                                <p>Jumlah: {{ $alat->jumlah }}</p>
                                <p>Status: <span class="badge {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span></p>
                                <p>Spesifikasi: </p><p style="text-align: justify;">{!! nl2br(e($alat->spesifikasi)) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  {{-- Maxime gambar --}}
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

  {{-- <script>
    $(document).ready(function() {
        // Ganti dengan API key OpenWeatherMap Anda
        const apiKey = '8f6451a388d8d187d4edddbb1a50ca3a';
        // Ganti dengan nama kota yang ingin Anda tampilkan cuacanya
        const city = 'Malangjiwan';

        // URL API OpenWeatherMap
        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=id`;

        // Ambil data cuaca dari API
        $.getJSON(apiUrl, function(data) {
            const weatherInfo = `
                <h6>Cuaca di ${city} saat ini:</h6>
                <p>Suhu: ${data.main.temp}°C</p>
                <p>Deskripsi: ${data.weather[0].description}</p>
            `;
            $('#weather-info').html(weatherInfo);
        }).fail(function() {
            $('#weather-info').html('<p>Informasi cuaca tidak tersedia.</p>');
        });
    });
  </script> --}}


    <!-- Script untuk menampilkan informasi cuaca -->
    {{-- <script>
      $(document).ready(function () {
        // Ganti dengan API key OpenWeatherMap Anda
        const apiKey = '8f6451a388d8d187d4edddbb1a50ca3a';
        // Ganti dengan nama kota yang ingin Anda tampilkan cuacanya
        const city = 'Malangjiwan';

        // URL API OpenWeatherMap
        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=id`;

        // Ambil data cuaca dari API
        $.getJSON(apiUrl, function (data) {
          const weatherInfo = `
            <p>Suhu: ${data.main.temp}°C</p>
            <p>Deskripsi: ${data.weather[0].description}</p>
          `;
          $('#weather-info').html(weatherInfo);

          // Menggambar grafik cuaca menggunakan Chart.js
          const ctx = document.getElementById('weather-chart').getContext('2d');
          const weatherChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Suhu', 'Kelembaban', 'Kecepatan Angin'],
              datasets: [{
                label: 'Data Cuaca',
                data: [data.main.temp, data.main.humidity, data.wind.speed],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        }).fail(function () {
          $('#weather-info').html('<p>Informasi cuaca tidak tersedia.</p>');
        });
      });
    </script> --}}

  {{-- Javascrip Chart Cuaca --}}
  <script>
    const ctx = document.getElementById('weatherChart').getContext('2d');
    const weatherChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['14:00', '17:00', '20:00', '23:00', '02:00', '05:00', '08:00', '11:00'],
            datasets: [{
                label: 'Suhu (°C)',
                data: [32, 29, 26, 24, 23, 24, 24, 30],
                backgroundColor: 'rgba(255, 204, 0, 0.2)',
                borderColor: 'rgba(255, 204, 0, 1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
  </script>

  <!-- Script JavaScript untuk mendapatkan data cuaca dari OpenWeatherMap -->
  <script>
    // Fungsi untuk mengambil data cuaca dari OpenWeatherMap
    function getWeatherData() {
        const apiKey = '8f6451a388d8d187d4edddbb1a50ca3a'; // Ganti dengan API key OpenWeatherMap Anda
        const cityId = '1621158'; // Ganti dengan ID kota Malangjiwan
        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?id=${cityId}&units=metric&appid=${apiKey}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                updateWeatherUI(data);
            })
            .catch(error => console.error('Error fetching weather data:', error));
    }

    // Fungsi untuk memperbarui tampilan HTML dengan data cuaca
    function updateWeatherUI(data) {
        const weatherIcon = document.getElementById('weatherIcon');
        const temperature = document.getElementById('temperature');
        const description = document.getElementById('description');
        const updatedInfo = document.getElementById('updatedInfo');

        weatherIcon.innerHTML = `<img src="https://openweathermap.org/img/wn/${data.weather[0].icon}.png" alt="Weather Icon">`;
        temperature.textContent = `${data.main.temp}°C`;
        description.textContent = data.weather[0].description;
        updatedInfo.textContent = `Data diperbarui: ${new Date().toLocaleTimeString('id-ID')}`;
    }

    getWeatherData();
    setInterval(getWeatherData, 600000); // Perbarui data setiap 10 menit
  </script>

</body>

</html>