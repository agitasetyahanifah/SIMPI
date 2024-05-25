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
      SIMPI | Sewa Spot Pemancingan
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
    
    <!-- BS Stepper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/css/bs-stepper.min.css" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    @include('Member.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('member.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Kembali</a>
      </div>

      <div class="container mt-2">
        <div class="card">
            <div class="bs-stepper wizard-modern" id="stepper1">
                <div class="row mt-0">
                    <div class="col">
                        <!-- Wizard Steps -->
                        <div class="card-body bs-stepper-header">
                            <div class="step" data-target="#step-one">
                                <button type="button" class="step-trigger"><span class="bs-stepper-circle">1</span>Select Method</button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-two">
                                <button type="button" class="step-trigger"><span class="bs-stepper-circle">2</span>Pay</button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#step-three">
                                <button type="button" class="step-trigger"><span class="bs-stepper-circle">3</span>Finish</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wizard Content --}}
                <div class="bs-stepper-content">

                    {{-- Step 1 --}}
                    <div id="step-one" class="content">
                      <div class="row">
                          <div class="col">
                            <form action="">
                                <h5>Step 1: Sewa Spot Pemancingan</h5>
                                <div class="mb-3">
                                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                                </div>
                                <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                </div>
                                <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                </div>
                                <div class="mb-3">
                                <label for="jumlah_sewa" class="form-label">Jumlah Sewa</label>
                                <input type="number" class="form-control" id="jumlah_sewa" name="jumlah_sewa" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Next</button>
                            </form>
                          </div>
                      </div>
                    </div>

                    {{-- Step 2 --}}
                    <div id="step-two" class="content">
                        <div class="row">
                            <div class="col">
                              <form action="">
                                  <h5>Step 1: Sewa Spot Pemancingan</h5>
                                  <div class="mb-3">
                                  <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                  <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                                  </div>
                                  <div class="mb-3">
                                  <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                  <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                  </div>
                                  <div class="mb-3">
                                  <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                  <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                  </div>
                                  <div class="mb-3">
                                  <label for="jumlah_sewa" class="form-label">Jumlah Sewa</label>
                                  <input type="number" class="form-control" id="jumlah_sewa" name="jumlah_sewa" required>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Next</button>
                              </form>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer py-4">
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
    </div>


    <!-- JavaScript for Wizard -->
    <script>
      let currentStep = 1;

      function nextStep() {
        if (validateForm()) {
          currentStep++;
          showStep();
        }
      }

      function prevStep() {
        currentStep--;
        showStep();
      }

      function showStep() {
        document.querySelectorAll('.step').forEach((step, index) => {
          step.style.display = (index + 1 === currentStep) ? 'block' : 'none';
        });

        if (currentStep === 3) {
          summarize();
        }
      }

      function validateForm() {
        let isValid = true;
        document.querySelectorAll(`#step${currentStep} [required]`).forEach(input => {
          if (!input.value) {
            input.classList.add('is-invalid');
            isValid = false;
          } else {
            input.classList.remove('is-invalid');
          }
        });
        return isValid;
      }

      function summarize() {
        const summary = document.getElementById('summary');
        summary.innerHTML = `
          <li>Nama: ${document.getElementById('name').value}</li>
          <li>Email: ${document.getElementById('email').value}</li>
          <li>Spot: ${document.getElementById('spot').value}</li>
          <li>Metode Pembayaran: ${document.getElementById('payment').value}</li>
        `;
      }

      document.getElementById('sewaForm').addEventListener('submit', function(event) {
        if (!validateForm()) {
          event.preventDefault();
        }
      });
    </script>

    {{-- Script Wizard --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var stepper = new Stepper(document.querySelector('.bs-stepper'), {
                linear: false,
                animation: true
            });
    
            // Contoh untuk tombol "Next" pada setiap langkah
            document.querySelectorAll('.btn-next').forEach(function (element) {
                element.addEventListener('click', function () {
                stepper.next();
                });
            });
    
            // Contoh untuk tombol "Previous" pada setiap langkah
            document.querySelectorAll('.btn-prev').forEach(function (element) {
                element.addEventListener('click', function () {
                stepper.previous();
                });
            });
    
            // Contoh untuk tombol "Submit" pada langkah terakhir
            document.querySelector('.btn-submit').addEventListener('click', function () {
                alert('Form submitted!');
            });
            });
    </script>

    <!-- Bootstrap JS and Other Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- BS Stepper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/js/bs-stepper.min.js"></script>
  </main>
</body>

</html>
