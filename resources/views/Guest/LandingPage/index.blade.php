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
        margin-bottom: 2px;
    }

    .card-text2 {
        margin-bottom: 5px;
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
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 20px;
        /* max-width: 800px; */
        margin: 0 auto;
    }

    .weather-header {
        display: flex;
        align-items: center;
    }

    .weather-info {
        display: flex;
        flex-direction: column;
    }
    
    .weather-icon {
        font-size: 64px;
        margin-right: 20px;
        color: #ffcc00;
    }

    .weekly-forecast {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .temp {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .details span {
        display: block;
        font-size: 14px;
        color: #666;
        margin-bottom: 3px;
    }

    .location-info {
        text-align: right;
        margin-top: 10px;
    }

    .location {
        font-size: 20px; 
        color: #333;
        margin-bottom: 3px;
        text-align: right;
        margin-right: 5px;
    }

    .weather-details {
        margin-top: 20px;
    }

    .day {
      font-size: 16px;
      color: #666;
      text-align: right;
      margin-right: 5px;
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

    @media (max-width: 600px) {
        .weather-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .location-info {
            margin-top: 50px;
        }
    }

    .chart {
        text-align: center;
        height: 150px;
    }

    .chart canvas {
        max-width: 100%;
        height: 100%;
    }

  </style>
    
</head>

<body class="g-sidenav-show  bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  
    @include('Guest.Layouts.navbar')

    {{-- Content --}}
    <div class="container-fluid py-2">

      <!-- Informasi Cuaca -->
      <div class="col-md-12 mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="current-weather">
                        <div class="weather-header">
                            <div class="weather-icon" id="weatherIcon">
                                <!-- Weather icon will be updated dynamically -->
                            </div>
                            <div class="weather-info">
                                <div class="temp" id="temperature">
                                    <!-- Temperature will be updated dynamically -->
                                </div>
                                <div class="details">
                                    <span id="description"></span>
                                    <span id="humidity"></span>
                                    <span id="wind"></span>
                                </div>
                            </div>
                        </div>
                        <div class="location-info">
                            <div class="location" id="city"></div>
                            <div class="day" id="day"></div>
                        </div>
                    </div>
                    <div class="weather-details">
                        <div class="chart">
                            <canvas id="weatherChart"></canvas>
                        </div>
                    </div>
                    <div class="weekly-forecast" id="weekly-forecast">
                        <!-- Weekly forecast will be updated dynamically -->
                    </div>
                </div>
            </div>
        </div>
      </div>

      {{-- Card Body --}}
      <div class="card-body">
        {{-- Start Galeri Pemancingan --}}
        <h3 class="text-center mt-4 mb-3">Fishing Gallery</h3>
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
                  <img id="maximizedImage" src="#" class="img-fluid" alt="Gambar Diperbesar" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- Cek ada data atau kosong --}}
        @if($images->isEmpty())
          <h6 class="text-muted text-center">No data has been added yet</h6>
        @endif
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.galeri.index') }}" class="btn btn-primary btn-sm rounded-pill">More <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div>
        {{-- End Galeri Pemancingan --}}

        {{-- Start Blog Pemancingan --}}
        @php
          use Illuminate\Support\Str;
        @endphp
        {{-- Konten Blog --}}
        <div class="row">
          <h3 class="text-center mt-4 mb-4">Fishing Blogs</h3>
          <div class="col-12 d-flex flex-wrap mb-2">
            <div class="row g-2">
              @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-1">
                  <div class="card h-100">
                    @if($blog->image && file_exists(public_path('images/'.$blog->image)))
                      <img src="{{ asset('images/'.$blog->image) }}" class="card-img-top fixed-image" alt="{{ $blog->judul }}">
                    @else
                      <img src="{{ asset('../images/ex-blog.png') }}" class="card-img-top fixed-image" alt="Fishing Image">
                    @endif
                    <div class="card-body">
                      <h5 class="card-title">{{ $blog->judul }}</h5>
                      <p class="card-text">{{ Str::words(strip_tags($blog->body), 12, '...') }} <a href="{{ route('guest.blog.detail-blog', $blog->id) }}" style="color: aqua;">More</a></p>
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
          <h6 class="text-muted text-center">No data has been added yet</h6>
        @endif
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.blog.index') }}" class="btn btn-primary btn-sm rounded-pill">More <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div> 
        {{-- End Blog Pemancingan --}}

        {{-- Start Daftar Alat Pancing --}}
        <h3 class="text-center mt-4 mb-3">List of Fishing Equipment</h3>
        {{-- Daftar Alat Pancing --}}
        <div class="row gx-2 mb-4">
          @foreach($alatPancing as $alat)
          <div class="col-lg-2 col-md-3 col-sm-4 col-4 g-1 mb-1">
            <div class="card h-100">
              <div class="card">
                @if($alat->foto && file_exists(public_path('images/'.$alat->foto)))
                  <img src="{{ asset('images/'.$alat->foto) }}" class="card-img-top fixed-image" alt="{{ $alat->nama_alat }}">
                @else
                   <img src="{{ asset('../images/ex-alat.png') }}" class="card-img-top fixed-image" alt="Fishing Image">
                @endif
                <div class="card-body2">
                    <h5 class="card-title2">{{ $alat->nama_alat }}</h5>
                    <p class="card-text2" style="color: orangered;">Rp {{ number_format($alat->harga, 0, ',', '.') }},- /day</p>
                    <div class="text-center">
                      <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}">Details</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        {{-- Cek ada data atau kosong --}}
        @if($alatPancing->isEmpty())
          <h6 class="text-muted text-center">No data has been added yet</h6>
        @endif
        {{-- Button Lainnya --}}
        <div class="row mt-3">
          <div class="text-center">
            <a href="{{ route('guest.daftar-alat.index') }}" class="btn btn-primary btn-sm rounded-pill">More <i class="ms-2 fas fa-chevron-right" style="font-size: 10pt"></i></a>
          </div>
        </div>   
        <!-- Modal Detail Alat Pancing -->
        @foreach($alatPancing as $alat)
        <div class="modal fade" id="detailModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $alat->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $alat->id }}">Fishing Equipment Details</h5>
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
                                <img src="{{ asset('../images/ex-alat.png') }}" class="img-fluid" alt="Fishing Image">
                              @endif                        
                            </div>
                            <div class="col-md-6">
                                <h5>{{ $alat->nama_alat }}</h5>
                                <p>Price: Rp {{ number_format($alat->harga, 0, ',', '.') }},- /day</p>
                                <p>Available Quantity: {{ $alat->jumlah }}</p>
                                <p>Status: <span class="badge {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span></p>
                                <p>Specifications: </p><p style="text-align: justify;">{!! nl2br(e($alat->spesifikasi)) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
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
                  <h5 class="card-title mb-3"><b>Location</b></h5>
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
                <h5 class="card-title mt-4  "><b>Social Media</b></h5>
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

    {{-- Javascrip Chart Cuaca --}}
    {{-- <script>
      const ctx = document.getElementById('weatherChart').getContext('2d');
      const weatherChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: [], // Labels akan diisi dengan jam/jam tertentu dari data OpenWeatherMap
              datasets: [{
                  label: 'Temperature (°C)',
                  data: [], // Data akan diisi dengan suhu pada jam tertentu dari data OpenWeatherMap
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
  
      async function fetchWeatherDataForChart() {
          try {
              const apiKey = "8f6451a388d8d187d4edddbb1a50ca3a";
              const city = "malangjiwan";
              const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric`;
  
              const response = await fetch(apiUrl);
              const data = await response.json();
              console.log(data);
  
              const chartLabels = data.list.map(item => {
                  const date = new Date(item.dt * 1000);
                  return `${date.getHours()}:00`;
              });
  
              const chartData = data.list.map(item => item.main.temp);
  
              weatherChart.data.labels = chartLabels;
              weatherChart.data.datasets[0].data = chartData;
              weatherChart.update();
          } catch (error) {
              console.error('Failed to fetch weather data for chart:', error);
          }
      }
  
      fetchWeatherDataForChart();
    </script> --}}

    <script>
      const ctx = document.getElementById('weatherChart').getContext('2d');
      const weatherChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: [], // Labels akan diisi dengan jam dari data OpenWeatherMap
              datasets: [{
                  label: 'Temperature (°C)',
                  data: [], // Data akan diisi dengan suhu pada jam tertentu dari data OpenWeatherMap
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
                  x: {
                      title: {
                          display: true,
                          text: 'Time (Hours)'
                      },
                      ticks: {
                          callback: function(value, index, values) {
                              const date = new Date(weatherChart.data.labels[index]);
                              return `${date.getHours()}:00`;
                          }
                      }
                  },
                  y: {
                      title: {
                          display: true,
                          text: 'Temperature (°C)'
                      },
                      beginAtZero: false
                  }
              },
              plugins: {
                  tooltip: {
                      callbacks: {
                          title: function(tooltipItems) {
                              const date = new Date(tooltipItems[0].label);
                              return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()} ${date.getHours()}:00`;
                          },
                          label: function(tooltipItem) {
                              return `Temperature: ${tooltipItem.raw}°C`;
                          }
                      }
                  }
              }
          }
      });
    
      async function fetchWeatherDataForChart() {
          try {
              const apiKey = "8f6451a388d8d187d4edddbb1a50ca3a";
              const city = "malangjiwan";
              const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric`;
    
              const response = await fetch(apiUrl);
              const data = await response.json();
              console.log(data);
    
              // Filter data untuk hanya mengambil entri dengan jam dari 01:00 hingga 23:00
              const filteredData = data.list.filter(item => {
                  const date = new Date(item.dt * 1000);
                  return date.getHours() >= 1 && date.getHours() <= 23;
              });
    
              // Kelompokkan data berdasarkan tanggal untuk memastikan mulai dari jam 01:00 setiap hari
              const groupedData = {};
              filteredData.forEach(item => {
                  const date = new Date(item.dt * 1000);
                  const key = date.toISOString().split('T')[0]; // Bagian tanggal saja
                  if (!groupedData[key]) {
                      groupedData[key] = [];
                  }
                  groupedData[key].push(item);
              });
    
              // Rata-rata data sambil menjaga urutan dan memastikan dimulai dari jam 01:00
              const chartLabels = [];
              const chartData = [];
              for (const date in groupedData) {
                  // Pastikan mulai dari jam 01:00 dan sertakan semua data per jam
                  groupedData[date].sort((a, b) => a.dt - b.dt); // Urutkan data berdasarkan timestamp
                  groupedData[date].forEach(item => {
                      const dateObj = new Date(item.dt * 1000);
                      if (dateObj.getHours() >= 1 && dateObj.getHours() <= 23) { // Pastikan berada dalam rentang waktu
                          chartLabels.push(dateObj.toISOString()); // Simpan tanggal lengkap untuk tooltip
                          chartData.push(item.main.temp);
                      }
                  });
              }
    
              weatherChart.data.labels = chartLabels;
              weatherChart.data.datasets[0].data = chartData;
              weatherChart.update();
          } catch (error) {
              console.error('Gagal mengambil data cuaca untuk grafik:', error);
          }
      }
    
      fetchWeatherDataForChart();
    </script>
       

    <!-- Script JavaScript untuk mendapatkan data cuaca dari OpenWeatherMap -->
    <script>
      const apiKey = "8f6451a388d8d187d4edddbb1a50ca3a";
      const apiUrl = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=malangjiwan";
  
      const iconMapping = {
          "01d": "wi-day-sunny",
          "01n": "wi-night-clear",
          "02d": "wi-day-cloudy",
          "02n": "wi-night-alt-cloudy",
          "03d": "wi-cloud",
          "03n": "wi-cloud",
          "04d": "wi-cloudy",
          "04n": "wi-cloudy",
          "09d": "wi-showers",
          "09n": "wi-showers",
          "10d": "wi-day-rain",
          "10n": "wi-night-alt-rain",
          "11d": "wi-thunderstorm",
          "11n": "wi-thunderstorm",
          "13d": "wi-snow",
          "13n": "wi-snow",
          "50d": "wi-fog",
          "50n": "wi-fog"
      };
  
      // const descriptionMapping = {
      //     "clear sky": "Langit Cerah",
      //     "few clouds": "Sedikit Berawan",
      //     "scattered clouds": "Berawan Tersebar",
      //     "broken clouds": "Berawan Sebagian",
      //     "shower rain": "Hujan Gerimis",
      //     "rain": "Hujan",
      //     "thunderstorm": "Badai Petir",
      //     "snow": "Salju",
      //     "mist": "Kabut"
      // };

      const descriptionMapping = {
          "clear sky": "Clear Sky",
          "few clouds": "Few Clouds",
          "scattered clouds": "Scattered Clouds",
          "broken clouds": "Broken Clouds",
          "shower rain": "Shower Rain",
          "rain": "Rain",
          "thunderstorm": "Thunderstorm",
          "snow": "Snow",
          "mist": "Mist"
      };
  
      function capitalizeWords(str) {
          return str.replace(/\b\w/g, char => char.toUpperCase());
      }
  
      async function checkWeather() {
          const response = await fetch(apiUrl + `&appid=${apiKey}`);
          const data = await response.json();
  
          console.log(data);
  
          const iconClass = iconMapping[data.weather[0].icon];
          document.getElementById("weatherIcon").innerHTML = `<i class="wi ${iconClass}"></i>`;
          document.getElementById("temperature").innerHTML = `${data.main.temp}°C`;
  
          const description = descriptionMapping[data.weather[0].description.toLowerCase()] || data.weather[0].description;
          document.getElementById("description").innerHTML = capitalizeWords(description);
  
          // const dayName = new Date(data.dt * 1000).toLocaleDateString('id-ID', { weekday: 'long' });
          const dayName = new Date(data.dt * 1000).toLocaleDateString('en-US', { weekday: 'long' });
          document.getElementById("day").innerHTML = dayName;
  
          document.getElementById("humidity").innerHTML = `Humidity: ${data.main.humidity}%`;
          document.getElementById("wind").innerHTML = `Wind: ${data.wind.speed} km/h`;
          document.getElementById("city").innerHTML = data.name;
          
        }
  
        checkWeather();
    </script>

</body>

</html>