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
</head>

<body class="g-sidenav-show  bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <img src="../images/logo.png" class="navbar-brand-img h-100" alt="main_logo" style="width: 35px">
          <a class="navbar-brand ms-2" href="#" style="font-size: 18pt"><b>SIMPI</b></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
              <a class="nav-link" href="#">Features</a>
              <a class="nav-link" href="#">Pricing</a>
              <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </div>
          </div>
        </div>
    </nav>
    <!-- End Navbar -->

    {{-- Content --}}
    <div class="container-fluid py-2">
      <div class="row row-cols-md-2">
        <div class="col mt-2">
          <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5 class="font-weight-bolder">Ketersediaan Spot Pemancingan</h5>
                            <small class="text-muted">Terakhir diperbarui pada: {{ $waktuTerbaru }}</small>
                        </div>
                        <div class="col-12 col-md-6 text-md-end text-center mt-3 mt-md-0">
                            <a class="btn btn-outline-primary" style="font-size: 25pt">{{ $terakhirDiperbaruiKetersediaan }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col mt-2">
          <div class="col-12">
              <div class="card shadow-sm border-0">
                  <div class="card-body">
                      <div class="row">
                          <h5 class="font-weight-bolder">Informasi Cuaca</h5>
                      </div>
                      <div class="row mt-3">
                          <div class="col">
                              <div id="weather-info"></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      </div>
    </div>


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
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>

  <script>
    const API_KEY = 'YOUR_WEATHERCOM_API_KEY';
    const LOCATION_ID = 'YOUR_LOCATION_ID';

    const API_URL = `https://api.weather.com/data/2.5/weather?id=${LOCATION_ID}&appid=${API_KEY}&units=metric`;

    const getWeatherInfo = () => {
        fetch(API_URL)
            .then(response => response.json())
            .then(data => {
                const weatherInfo = document.getElementById('weather-info');
                weatherInfo.innerHTML = `
                    <p>Kota: ${data.name}</p>
                    <p>Suhu: ${data.main.temp}°C</p>
                    <p>Kondisi Cuaca: ${data.weather[0].description}</p>
                    <p>Kelembaban: ${data.main.humidity}%</p>
                    <p>Kecepatan Angin: ${data.wind.speed} km/h</p>
                `;
            })
            .catch(error => console.log('Error:', error));
    };

    window.onload = () => {
        getWeatherInfo();
    };
  </script>
</body>

</html>