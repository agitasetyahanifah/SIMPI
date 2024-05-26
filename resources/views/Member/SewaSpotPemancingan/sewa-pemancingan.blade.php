<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
    <title>SIMPI | Sewa Spot Pemancingan</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />

    <!-- Nepcha Analytics -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/css/bs-stepper.min.css" rel="stylesheet">

    <style>
        .bs-stepper-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: nowrap;
            padding: 1rem;
            overflow-x: auto; /* Tambahkan ini untuk mengaktifkan scroll horizontal */
        }
        .bs-stepper-header .step {
            flex: 1;
            text-align: center;
            min-width: 120px; /* Pastikan setiap step memiliki lebar minimum */
        }
        .bs-stepper-header .line {
            flex: 0;
            width: 2px;
            height: auto;
            background-color: #ddd;
        }
        .bs-stepper-header .line:not(:last-child) {
            margin: 0 0.5rem;
        }
        .bs-stepper .content {
            padding: 1rem;
        }

        @media (max-width: 576px) {
            .bs-stepper-header {
                padding: 0.5rem;
            }
            .bs-stepper-header .step {
                min-width: 100px;
            }
            .bs-stepper-header .line:not(:last-child) {
                margin: 0 0.25rem;
            }
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @include('Member.Layouts.navbar')

        <div class="container-fluid py-2">
            <div class="mt-3 mb-2">
                <a href="{{ route('member.landingpage.index') }}">
                    <i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Kembali
                </a>
            </div>
            <div id="stepper1" class="bs-stepper">
              <div class="card">
                <div class="card-body">
                  <div class="bs-stepper-header" role="tablist">
                      <div class="step" data-target="#step-one">
                          <button type="button" class="step-trigger" role="tab" id="step-one-trigger" aria-controls="step-one">
                              <span class="bs-stepper-circle">1</span>
                              <span class="bs-stepper-label">Form Sewa Pemancingan</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#step-two">
                          <button type="button" class="step-trigger" role="tab" id="step-two-trigger" aria-controls="step-two">
                              <span class="bs-stepper-circle">2</span>
                              <span class="bs-stepper-label">Detail Sewa Pemancingan</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#step-three">
                          <button type="button" class="step-trigger" role="tab" id="step-three-trigger" aria-controls="step-three">
                              <span class="bs-stepper-circle">3</span>
                              <span class="bs-stepper-label">Selesai</span>
                          </button>
                      </div>
                  </div>
                  <div class="bs-stepper-content">
                      <form id="sewaForm">
                          <!-- Step 1 -->
                          <div id="step-one" class="content" role="tabpanel" aria-labelledby="step-one-trigger">
                              <h5>Step 1: Sewa Spot Pemancingan</h5>
                              <div class="mb-3">
                                  <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                  <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                      <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                      <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label for="jumlah_sewa" class="form-label">Jumlah Sewa</label>
                                  <input type="number" class="form-control" id="jumlah_sewa" name="jumlah_sewa" required>
                              </div>
                              <button type="button" class="btn btn-primary btn-next">Next</button>
                          </div>

                          <!-- Step 2 -->
                          <div id="step-two" class="content" role="tabpanel" aria-labelledby="step-two-trigger">
                              <h5>Step 2: Pembayaran</h5>
                              <div class="mb-3">
                                  <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                  <select class="form-control" id="payment_method" name="payment_method" required>
                                      <option value="">Pilih Metode Pembayaran</option>
                                      <option value="credit_card">Kartu Kredit</option>
                                      <option value="bank_transfer">Transfer Bank</option>
                                      <option value="paypal">PayPal</option>
                                  </select>
                              </div>
                              <button type="button" class="btn btn-secondary btn-prev">Previous</button>
                              <button type="button" class="btn btn-primary btn-next">Next</button>
                          </div>

                          <!-- Step 3 -->
                          <div id="step-three" class="content" role="tabpanel" aria-labelledby="step-three-trigger">
                              <h5>Step 3: Selesai</h5>
                              <p>Terima kasih telah melakukan reservasi. Berikut adalah detail pesanan Anda:</p>
                              <ul id="summary">
                                  <!-- Summary will be generated here -->
                              </ul>
                              <button type="button" class="btn btn-secondary btn-prev">Previous</button>
                              <button type="submit" class="btn btn-success btn-submit">Submit</button>
                          </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <!-- JavaScript for Wizard -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var stepper = new Stepper(document.querySelector('.bs-stepper'), {
                    linear: false,
                    animation: true
                });

                // Handle next buttons
                document.querySelectorAll('.btn-next').forEach(function (button) {
                    button.addEventListener('click', function () {
                        if (validateForm()) {
                            stepper.next();
                        }
                    });
                });

                // Handle previous buttons
                document.querySelectorAll('.btn-prev').forEach(function (button) {
                    button.addEventListener('click', function () {
                        stepper.previous();
                    });
                });

                // Form submit handling
                document.querySelector('#sewaForm').addEventListener('submit', function (event) {
                    if (!validateForm()) {
                        event.preventDefault();
                    } else {
                        alert('Form submitted!');
                    }
                });

                function validateForm() {
                    let currentStep = document.querySelector('.bs-stepper-content .content.active');
                    let inputs = currentStep.querySelectorAll('[required]');
                    let isValid = true;

                    inputs.forEach(function (input) {
                        if (!input.value) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (currentStep.id === 'step-two' && isValid) {
                        summarize();
                    }

                    return isValid;
                }

                function summarize() {
                    const summary = document.getElementById('summary');
                    summary.innerHTML = `
                        <li>Tanggal Sewa: ${document.getElementById('tanggal_sewa').value}</li>
                        <li>Jam Mulai: ${document.getElementById('jam_mulai').value}</li>
                        <li>Jam Selesai: ${document.getElementById('jam_selesai').value}</li>
                        <li>Jumlah Sewa: ${document.getElementById('jumlah_sewa').value}</li>
                        <li>Metode Pembayaran: ${document.getElementById('payment_method').value}</li>
                    `;
                }
            });
        </script>

        <!-- Bootstrap JS and Other Dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/js/bs-stepper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    </main>
</body>

</html>
