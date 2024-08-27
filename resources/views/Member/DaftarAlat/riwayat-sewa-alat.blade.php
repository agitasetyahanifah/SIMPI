<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>
    SIMPI | Fishing Equipment Rental History
  </title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/nucleo/css/nucleo.css" rel="stylesheet">

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery dan Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('Member.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('member.daftar-alat.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Back</a>
      </div>
      <div class="mt-3 mb-4 d-flex justify-content-between align-items-center flex-wrap">
        <h2 class="font-weight-bolder mt-4 mb-3 text-center flex-grow-1">Fishing Equipment Rental History</h2>
      </div>   
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
      @endif
    
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>    
        </div>
      @endif

      <div class="card-body">
        @if($riwayatSewaAlat->isEmpty())
            <h6 class="text-muted text-center">No data has been added yet</h6>
        @else
            @foreach($riwayatSewaAlat as $index => $sewaAlat)
                <div class="card card-frame mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title"><strong>Rental Code:</strong> {{ $sewaAlat->kode_sewa }}</h5>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Fishing Equipment</strong></div>
                                    <div class="col-md-9">{{ $sewaAlat->alatPancing->nama_alat }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Rental Costs</strong></div>
                                    <div class="col-md-9">Rp {{ number_format($sewaAlat->biaya_sewa, 0, ',', '.') }} ,-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Payment Status</strong></div>
                                    <div class="col-md-9">
                                        @if($sewaAlat->status === 'dibatalkan')
                                            <span class="text-danger">Canceled</span>
                                        @elseif($sewaAlat->status === 'sudah dibayar')
                                            <span class="text-success">Already Paid</span>
                                        @elseif($sewaAlat->status === 'menunggu pembayaran')
                                            <span class="text-warning">Waiting for Payment</span>
                                        @else
                                            {{ $sewaAlat->status }}
                                        @endif
                                    </div>
                                </div>
                                @if($sewaAlat->status === 'menunggu pembayaran')
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Remaining Payment Time</strong></div>
                                    <div class="col-md-9 text-danger" id="countdown-payment-{{ $sewaAlat->id }}"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $sewaAlat->id }}">Cancel Rental</button>
                                        <a class="btn btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#paymentInstructionsModal{{ $sewaAlat->id }}">Payment Instructions</a>
                                        <a class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $sewaAlat->id }}">Details</a>
                                    </div>
                                </div>
                                @elseif($sewaAlat->status === 'sudah dibayar')
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Return Status</strong></div>
                                    <div class="col-md-9">
                                        @if($sewaAlat->status_pengembalian === 'terlambat kembali')
                                            <span class="text-danger">Late Return</span>
                                        @elseif($sewaAlat->status_pengembalian === 'sudah kembali')
                                            <span class="text-success">Already Return</span>
                                        @elseif($sewaAlat->status_pengembalian === 'proses')
                                            <span class="text-warning">Process</span>
                                        @else
                                            {{ $sewaAlat->status_pengembalian }}
                                        @endif
                                    </div>
                                </div>
                                @if($sewaAlat->status_pengembalian === 'proses' || $sewaAlat->status_pengembalian === 'terlambat kembali')
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Return Remaining Time</strong></div>
                                    <div class="col-md-9 text-danger" id="countdown-return-{{ $sewaAlat->id }}"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3"><strong>Late Fines</strong></div>
                                    <div class="col-md-9" id="denda-{{ $sewaAlat->id }}"></div>
                                </div>                                
                                @endif
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <a class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $sewaAlat->id }}">Details</a>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <a class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $sewaAlat->id }}">Details</a>
                                    </div>
                                </div>
                                @endif

                                <!-- Modal Konfirmasi Batal Sewa-->
                                <div class="modal fade" id="confirmModal{{ $sewaAlat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmation of Rental Cancellation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to cancel this fishing equipment rental?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <form id="cancelForm{{ $sewaAlat->id }}" action="{{ route('member.sewa-alat.cancel', $sewaAlat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Cancel Rental</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Petunjuk Pembayaran -->
                                <div class="modal fade" id="paymentInstructionsModal{{ $sewaAlat->id }}" tabindex="-1" aria-labelledby="paymentInstructionsModalLabel{{ $sewaAlat->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentInstructionsModalLabel{{ $sewaAlat->id }}">Payment Instructions</h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>                                            
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    <li>Ensure the payment time has not timed out.</li>
                                                    <li>Go to the fishing spot and meet the admin.</li>
                                                    <li>Show your <b>rental code</b>.</li>
                                                    <li>Pay <b>cash</b> to the admin.</li>
                                                    <li>Admin confirms the payment.</li>
                                                    <li>Ensure the payment status has changed to <b>"Already Paid"</b>.</li>
                                                    <li>Done.</li>
                                                </ul>
                                                <ul>
                                                    <b style="color: orange">Note: </b> <br>
                                                    <li>
                                                        <a>If you want to pay in another way, please contact the admin via the number below!</a> <br>
                                                        {{-- <a href="https://wa.me/6285647289934">0856-4728-9934 (Admin)</a> --}}
                                                        <a href="https://wa.me/6289522956203" style="color: orange">0859-5229-56203 (Admin)</a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            If you borrow equipment outside the PT LegendNet Indonesia fishing area, <b>you must leave your identity card</b>.
                                                        </a>
                                                    </li>
                                                </ul>  
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Detail Sewa -->
                                <div class="modal fade" id="detailModal{{ $sewaAlat->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $sewaAlat->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $sewaAlat->id }}">Fishing Equipment Rental Details</h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="me-3" style="font-size: 18pt"><b>Rental Code: {{ $sewaAlat->kode_sewa }}</b></p>
                                                        <table class="table">
                                                            <tr>
                                                                <th style="width: 40%">Customer Name</th>
                                                                <td>{{ $sewaAlat->member->nama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fishing Equipment</th>
                                                                <td>{{ $sewaAlat->alatPancing->nama_alat }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Amount</th>
                                                                <td>{{ $sewaAlat->jumlah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date of Borrow</th>
                                                                <td>{{ $sewaAlat->tgl_pinjam }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date of Return</th>
                                                                <td>{{ $sewaAlat->tgl_kembali }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Rental Costs</th>
                                                                <td>Rp {{ number_format($sewaAlat->biaya_sewa, 0, ',', '.') }} ,-</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Payment Status</th>
                                                                <td>
                                                                    @if($sewaAlat->status === 'dibatalkan')
                                                                        <span class="text-danger">Canceled</span>
                                                                    @elseif($sewaAlat->status === 'sudah dibayar')
                                                                        <span class="text-success">Already Paid</span>
                                                                    @elseif($sewaAlat->status === 'menunggu pembayaran')
                                                                        <span class="text-warning">Waiting for Payment</span>
                                                                    @else
                                                                        {{ $sewaAlat->status }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Return Status</th>
                                                                <td>
                                                                    @if($sewaAlat->status_pengembalian === 'terlambat kembali')
                                                                        <span class="text-danger">Late Return</span>
                                                                    @elseif($sewaAlat->status_pengembalian === 'sudah kembali')
                                                                        <span class="text-success">Already Return</span>
                                                                    @elseif($sewaAlat->status_pengembalian === 'proses')
                                                                        <span class="text-warning">Process</span>
                                                                    @else
                                                                        {{ $sewaAlat->status_pengembalian }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="mt-3">
                                                            <ul>
                                                                <b style="color: orange">Note: </b> <br>
                                                                <li>Please make payment directly to the admin at the fishing location.</li>
                                                                <li>
                                                                    <a>If you want to pay in another way, please contact the admin via the number below!</a> <br>
                                                                    {{-- <a href="https://wa.me/6285647289934">0856-4728-9934 (Admin)</a> --}}
                                                                    <a href="https://wa.me/6289522956203" style="color: orange">0859-5229-56203 (Admin)</a>
                                                                </li>
                                                                <li>
                                                                    <a>
                                                                        If you borrow equipment outside the PT LegendNet Indonesia fishing area, <b>you must leave your identity card</b>.
                                                                    </a>
                                                                </li>
                                                            </ul>  
                                                            <a style="color: coral">Late Returns will be subject to a fee <b>Rp 5.000,- /day</b></a>
                                                            {{-- <p>Untuk informasi lebih lanjut atau pertanyaan, bisa menghubungi admin melalui kontak berikut:</p>
                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <th style="width: 15%">WhatsApp</th>
                                                                    <td>0895-2295-6203</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Email</th>
                                                                    <td>adminlni@gmail.com</td>
                                                                </tr>
                                                            </table> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
      </div>
    </div>
    </div>

    <!-- Pagination -->
    <nav class="p-3" aria-label="Pagination">
        <ul class="pagination justify-content-center">
          <li class="page-item {{ $riwayatSewaAlat->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $riwayatSewaAlat->previousPageUrl() ?? '#' }}" tabindex="-1">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <!-- Tampilkan nomor halaman -->
            @for ($i = 1; $i <= $riwayatSewaAlat->lastPage(); $i++)
                <li class="page-item {{ $riwayatSewaAlat->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $riwayatSewaAlat->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $riwayatSewaAlat->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $riwayatSewaAlat->nextPageUrl() ?? '#' }}">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
      </nav>
      <!-- End Pagination -->

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

  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>

    <script>
        function submitForm(sewaId) {
            document.getElementById('cancelForm' + sewaId).submit();
        }
    </script>
    
    <!-- JavaScript Hitung Mundur dan hitung denda -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($riwayatSewaAlat as $sewaAlat)
                // Perhitungan untuk countdown pembayaran
                var createdAt{{ $sewaAlat->id }} = new Date("{{ $sewaAlat->created_at }}").getTime();
                var expireAt{{ $sewaAlat->id }} = createdAt{{ $sewaAlat->id }} + (24 * 60 * 60 * 1000);
                var countdownPaymentElement{{ $sewaAlat->id }} = document.getElementById("countdown-payment-{{ $sewaAlat->id }}");
    
                var countdownPaymentInterval{{ $sewaAlat->id }} = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = expireAt{{ $sewaAlat->id }} - now;
    
                    if (distance < 0) {
                        clearInterval(countdownPaymentInterval{{ $sewaAlat->id }});
                        countdownPaymentElement{{ $sewaAlat->id }}.innerHTML = "Payment Time Has Expired";
                        cancelOrderAutomatically({{ $sewaAlat->id }});
                    } else {
                        var hours = Math.floor((distance % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
                        var minutes = Math.floor((distance % (60 * 60 * 1000)) / (60 * 1000));
                        var seconds = Math.floor((distance % (60 * 1000)) / 1000);
    
                        countdownPaymentElement{{ $sewaAlat->id }}.innerHTML = hours + " hours " + minutes + " minutes " + seconds + " seconds ";
                    }
                }, 1000);
    
                // Perhitungan untuk countdown pengembalian
                var tglKembali{{ $sewaAlat->id }} = new Date("{{ $sewaAlat->tgl_kembali }}").getTime();
                var countdownReturnElement{{ $sewaAlat->id }} = document.getElementById("countdown-return-{{ $sewaAlat->id }}");
                var dendaElement{{ $sewaAlat->id }} = document.getElementById("denda-{{ $sewaAlat->id }}");

                var countdownReturnInterval{{ $sewaAlat->id }} = setInterval(function() {
                    var now = new Date().getTime();
                    var endOfDay = new Date("{{ $sewaAlat->tgl_kembali }}").setHours(23, 59, 59, 999);
                    var distance = endOfDay - now;

                    if (distance < 0) {
                        clearInterval(countdownReturnInterval{{ $sewaAlat->id }});
                        countdownReturnElement{{ $sewaAlat->id }}.innerHTML = "Return Time Has Expired";
                        dendaElement{{ $sewaAlat->id }}.classList.add("text-danger");

                        var terlambatHari = Math.ceil(Math.abs(distance) / (1000 * 60 * 60 * 24));
                        var denda = terlambatHari * 5000;
                        dendaElement{{ $sewaAlat->id }}.innerHTML = "Rp " + denda.toLocaleString() + " (" + terlambatHari + " Days Late)";
                    } else {
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
                        var minutes = Math.floor((distance % (60 * 60 * 1000)) / (60 * 1000));
                        var seconds = Math.floor((distance % (60 * 1000)) / 1000);

                        countdownReturnElement{{ $sewaAlat->id }}.innerHTML = days + " days " + hours + " hours " + minutes + " minutes " + seconds + " seconds ";
                        dendaElement{{ $sewaAlat->id }}.innerHTML = "There are no fines yet";
                        dendaElement{{ $sewaAlat->id }}.classList.remove("text-danger");
                    }
                }, 1000);
    
                function cancelOrderAutomatically(sewaId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "{{ route('member.sewa-alat.autoCancel', '') }}/" + sewaId, true);
                    xhr.setRequestHeader("Content-Type", "application/json");
                    xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
    
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            location.reload();
                        }
                    };
    
                    xhr.send();
                }
            @endforeach
        });
    </script>
    
    
    
</body>
</html>
