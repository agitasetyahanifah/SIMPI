<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <title>
    SIMPI | Fishing Spot Reservation History
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
        <a href="{{ route('member.spots.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Back</a>
      </div>
      <div class="mt-3 mb-4 d-flex justify-content-between align-items-center flex-wrap">
        <h2 class="font-weight-bolder mt-4 mb-3 text-center flex-grow-1">Fishing Spot Reservation History</h2>
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
        @if($riwayatSewa->isEmpty())
            <h6 class="text-muted text-center">No data has been added yet</h6>
        @else
            @foreach($riwayatSewa as $index => $sewa)
                <div class="card card-frame mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title"><strong>Booking Code:</strong> {{ $sewa->kode_booking }}</h5>
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Booking Date</strong></div>
                                    <div class="col-md-10">{{ $sewa->tanggal_sewa }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Spot Number</strong></div>
                                    <div class="col-md-10">{{ $sewa->spot ? $sewa->spot->nomor_spot : 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Session</strong></div>
                                    <div class="col-md-10">{{ $sewa->updateSesiSewaSpot->waktu_sesi }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Payment Status</strong></div>
                                    <div class="col-md-10">
                                        @if($sewa->status === 'dibatalkan')
                                            <span class="text-danger">Canceled</span>
                                        @elseif($sewa->status === 'sudah dibayar')
                                            <span class="text-success">Already Paid</span>
                                        @elseif($sewa->status === 'menunggu pembayaran')
                                            <span class="text-warning">Waiting for Payment</span>
                                        @else
                                            {{ $sewa->status }}
                                        @endif
                                    </div>
                                </div>
                                @if($sewa->status === 'menunggu pembayaran')
                                <div class="row mb-2">
                                    <div class="col-md-2"><strong>Remaining Payment Time</strong></div>
                                    <div class="col-md-10 text-danger" id="countdown-{{ $sewa->id }}"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $sewa->id }}">Cancel Booking</button>
                                        <a class="btn btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#paymentInstructionsModal{{ $sewa->id }}">Payment Instructions</a>
                                        <a class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $sewa->id }}">Details</a>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <a class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $sewa->id }}">Details</a>
                                    </div>
                                </div>
                                @endif

                                <!-- Modal Konfirmasi Batal Sewa-->
                                <div class="modal fade" id="confirmModal{{ $sewa->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmation of Booking Cancellation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to cancel this fishing spot?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <form id="cancelForm{{ $sewa->id }}" action="{{ route('member.spots.cancel', $sewa->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Cancel Booking</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Petunjuk Pembayaran -->
                                <div class="modal fade" id="paymentInstructionsModal{{ $sewa->id }}" tabindex="-1" aria-labelledby="paymentInstructionsModalLabel{{ $sewa->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentInstructionsModalLabel{{ $sewa->id }}">Payment Instructions</h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>                                            
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    <li>Ensure the payment time has not timed out.</li>
                                                    <li>Go to the fishing spot and meet the admin.</li>
                                                    <li>Show your <b>booking code</b>.</li>
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
                                                </ul> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Detail Sewa -->
                                <div class="modal fade" id="detailModal{{ $sewa->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $sewa->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $sewa->id }}">Fishing Spot Reservation Details</h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="me-3" style="font-size: 18pt"><b>Booking Code: {{ $sewa->kode_booking }}</b></p>
                                                        <table class="table">
                                                            <tr>
                                                                <th style="width: 35%">Customer Name</th>
                                                                <td>{{ $sewa->member->nama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Booking Date</th>
                                                                <td>{{ $sewa->tanggal_sewa }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Spot Number</th>
                                                                <td>{{ $sewa->spot ? $sewa->spot->nomor_spot : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Session</th>
                                                                <td>{{ $sewa->updateSesiSewaSpot->waktu_sesi }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Reservation Fee</th>
                                                                <td>Rp {{ number_format($sewa->updateHargaSewaSpot->harga ?? 0, 0, ',', '.') }} ,-</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Payment Status</th>
                                                                <td>
                                                                    @if($sewa->status === 'dibatalkan')
                                                                        <span class="text-danger">Canceled</span>
                                                                    @elseif($sewa->status === 'sudah dibayar')
                                                                        <span class="text-success">Already Paid</span>
                                                                    @elseif($sewa->status === 'menunggu pembayaran')
                                                                        <span class="text-warning">Waiting for Payment</span>
                                                                    @else
                                                                        {{ $sewa->status }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="mt-3">
                                                            <p><strong>Note: </strong>Please make payment directly to the admin at the fishing location.</p>
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
          <li class="page-item {{ $riwayatSewa->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $riwayatSewa->previousPageUrl() ?? '#' }}" tabindex="-1">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <!-- Tampilkan nomor halaman -->
            @for ($i = 1; $i <= $riwayatSewa->lastPage(); $i++)
                <li class="page-item {{ $riwayatSewa->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $riwayatSewa->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $riwayatSewa->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $riwayatSewa->nextPageUrl() ?? '#' }}">
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
    
    <!-- JavaScript Hitung Mundur -->
    <script>  
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($riwayatSewa as $sewa)
                var createdAt{{ $sewa->id }} = new Date("{{ $sewa->created_at }}").getTime();
                var expireAt{{ $sewa->id }} = createdAt{{ $sewa->id }} + (24 * 60 * 60 * 1000);
                var countdownElement{{ $sewa->id }} = document.getElementById("countdown-{{ $sewa->id }}");
        
                var countdownInterval{{ $sewa->id }} = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = expireAt{{ $sewa->id }} - now;
        
                    if (distance < 0) {
                        clearInterval(countdownInterval{{ $sewa->id }});
                        countdownElement{{ $sewa->id }}.innerHTML = "Payment Time Has Expired";
                        cancelOrderAutomatically({{ $sewa->id }});
                    } else {
                        var hours = Math.floor((distance % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
                        var minutes = Math.floor((distance % (60 * 60 * 1000)) / (60 * 1000));
                        var seconds = Math.floor((distance % (60 * 1000)) / 1000);
        
                        countdownElement{{ $sewa->id }}.innerHTML = hours + " hours " + minutes + " minutes " + seconds + " seconds ";
                    }
                }, 1000);
        
                function cancelOrderAutomatically(sewaId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "{{ route('member.spots.autoCancel', '') }}/" + sewaId, true);
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
