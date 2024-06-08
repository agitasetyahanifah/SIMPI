<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <title>
    SIMPI | Sewa Spot Pemancingan
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

  <style>
    .kolam {
      position: relative;
      width: 1200px;
      height: 400px;
      background-color: #4eb5ff;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 20px;
      text-align: center;
      /* overflow: hidden; */
      margin: auto;
    }

    .spot-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-areas:
        "top-top-top-top-top-top-top-top-top-top-top-top-top-top-top"
        "left . . . . . . . . . . . . . right"
        "left . . . . . . . . . . . . . right"
        "left . . . . . . . . . . . . . right"
        "left . . . . . . . . . . . . . right"
        "left . . . . . . . . . . . . . right"
        "bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom-bottom";
      gap: 1px;
      /* overflow: hidden; */
      margin: auto;
    }

    .spot {
      display: flex;
      align-items: center;
      justify-content: center;
      background: green;
      color: white;
      border: 1px solid green;
      width: 50px;
      height: 50px;
      position: absolute;
      border-radius: 5px;
      cursor: pointer;
    }

    .spot.selected {
      background-color: lightgray !important;
      border-color: lightgray !important;
    }

    .top {
      position: absolute;
      top: -60px;
    }

    .bottom {
      position: absolute;
      bottom: -60px;
    }

    .left {
      position: absolute;
      left: -60px;
    }

    .right {
      position: absolute;
      right: -60px;
    }

    .spot.disabled {
      background-color: lightgray !important;
      border-color: lightgray !important;
      cursor: not-allowed;
    }

    .sesi-button.disabled {
      background-color: lightgray !important;
      border-color: lightgray !important;
      color: gray !important;
    }

  </style>

</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('Member.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('member.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Kembali</a>
      </div>
      <div class="mt-3 mb-4">
        <h2 class="font-weight-bolder mt-4 mb-3 text-center"><b>Sewa Spot Pemancingan</b></h2>
      </div>
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <div class="card-body p-7">
          <div class="kolam">
            <h1 style="color: white;">Kolam</h1>
            <div class="spot-container">

            <!-- Bagian atas (1-15) dari kiri ke kanan -->
            @foreach ($spots->whereBetween('nomor_spot', ['01', '15']) as $spot)
                @php
                    $selectedDate = date('Y-m-d');
                    $availableSesi = ['08.00-12.00', '13.00-17.00'];
                    $spotBooked = $sewaSpots->has($spot->id) && $sewaSpots[$spot->id]->contains('tanggal_sewa', $selectedDate);
                    $spotBookedSesi = $spotBooked ? $sewaSpots[$spot->id]->where('tanggal_sewa', $selectedDate)->pluck('sesi')->toArray() : [];
                    $availableSesiCount = count(array_diff($availableSesi, $spotBookedSesi));
                    $isSpotAvailable = $availableSesiCount > 0;
                @endphp
                <div id="spot-{{ $spot->id }}" class="spot top{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                    data-bs-toggle="modal" data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                    style="left: calc(({{ ltrim($spot->nomor_spot, '0') }} - 1) * 80px);">
                    {{ $spot->nomor_spot }}
                </div>
            @endforeach

            <!-- Bagian kanan (16-20) dari atas ke bawah -->
            @foreach ($spots->whereBetween('nomor_spot', ['16', '20']) as $spot)
                @php
                    $availableSesi = ['08.00-12.00', '13.00-17.00'];
                    $spotBooked = $sewaSpots->has($spot->id) && $sewaSpots[$spot->id]->contains('tanggal_sewa', $selectedDate);
                    $spotBookedSesi = $spotBooked ? $sewaSpots[$spot->id]->where('tanggal_sewa', $selectedDate)->pluck('sesi')->toArray() : [];
                    $availableSesiCount = count(array_diff($availableSesi, $spotBookedSesi));
                    $isSpotAvailable = $availableSesiCount > 0;
                @endphp
                <div id="spot-{{ $spot->id }}" class="spot right{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                    data-bs-toggle="modal" data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                    style="top: calc(({{ ltrim($spot->nomor_spot, '0') }} - 16) * 80px);">
                    {{ $spot->nomor_spot }}
                </div>
            @endforeach

            <!-- Bagian bawah (21-35) dari kanan ke kiri -->
            @foreach ($spots->whereBetween('nomor_spot', ['21', '35']) as $spot)
                @php
                    $availableSesi = ['08.00-12.00', '13.00-17.00'];
                    $spotBooked = $sewaSpots->has($spot->id) && $sewaSpots[$spot->id]->contains('tanggal_sewa', $selectedDate);
                    $spotBookedSesi = $spotBooked ? $sewaSpots[$spot->id]->where('tanggal_sewa', $selectedDate)->pluck('sesi')->toArray() : [];
                    $availableSesiCount = count(array_diff($availableSesi, $spotBookedSesi));
                    $isSpotAvailable = $availableSesiCount > 0;
                @endphp
                <div id="spot-{{ $spot->id }}" class="spot bottom{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                    data-bs-toggle="modal" data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                    style="left: calc((35 - {{ ltrim($spot->nomor_spot, '0') }}) * 80px);">
                    {{ $spot->nomor_spot }}
                </div>
            @endforeach

            <!-- Bagian kiri (36-40) dari bawah ke atas -->
            @foreach ($spots->whereBetween('nomor_spot', ['36', '40']) as $spot)
                @php
                    $availableSesi = ['08.00-12.00', '13.00-17.00'];
                    $spotBooked = $sewaSpots->has($spot->id) && $sewaSpots[$spot->id]->contains('tanggal_sewa', $selectedDate);
                    $spotBookedSesi = $spotBooked ? $sewaSpots[$spot->id]->where('tanggal_sewa', $selectedDate)->pluck('sesi')->toArray() : [];
                    $availableSesiCount = count(array_diff($availableSesi, $spotBookedSesi));
                    $isSpotAvailable = $availableSesiCount > 0;
                @endphp
                <div id="spot-{{ $spot->id }}" class="spot left{{ !$isSpotAvailable ? ' disabled' : '' }}"
                    data-bs-toggle="modal" data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                    style="top: calc((40 - {{ ltrim($spot->nomor_spot, '0') }}) * 80px);">
                    {{ $spot->nomor_spot }}
                </div>
            @endforeach

            </div>          
          </div>        
      </div>
    </div>

    <!-- Tambahkan modal untuk pemesanan -->
    <div class="modal fade" id="spotModal" tabindex="-1" role="dialog" aria-labelledby="spotModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="spotModalLabel">Sewa Spot Pemancingan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="pesanForm" action="{{ route('member.spots.pesan-spot') }}" method="POST">
                  @csrf
                  <input type="hidden" id="spot_id" name="spot_id">
                  <div class="form-group">
                      <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                      <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ auth()->user()->nama }}" disabled>
                  </div>                
                  <div class="form-group">
                      <label for="tanggal_sewa" class="col-form-label">Tanggal Sewa</label>
                      <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="{{ date('Y-m-d') }}" required>
                    </div>
                  <div class="form-group">
                    @php
                        use App\Models\SewaSpot;
                    
                        $spot_id = request('spot_id');
                        $tanggal_sewa = request('tanggal_sewa');
                    
                        $spotBookedMorning = SewaSpot::where('spot_id', $spot_id)
                            ->where('tanggal_sewa', $tanggal_sewa)
                            ->where('sesi', '08.00-12.00')
                            ->exists();
                    
                        $spotBookedAfternoon = SewaSpot::where('spot_id', $spot_id)
                            ->where('tanggal_sewa', $tanggal_sewa)
                            ->where('sesi', '13.00-17.00')
                            ->exists();
                    @endphp                           
                    <label for="pilih_sesi" class="col-form-label">Pilih Sesi</label>
                    <div class="col form-group d-flex ms-2 justify-content-start">
                      <button type="button" class="btn btn-outline-primary sesi-button me-2 {{ $spotBookedMorning ? 'disabled' : '' }}" data-sesi="08.00-12.00">08:00 - 12:00</button>
                      <button type="button" class="btn btn-outline-primary sesi-button {{ $spotBookedAfternoon ? 'disabled' : '' }}" data-sesi="13.00-17.00">13:00 - 17:00</button>
                    </div>
                  </div>
                
                  <input type="hidden" id="sesi" name="sesi" required>                
                
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" form="pesanForm">Sewa</button>
          </div>
        </div>
      </div>
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

  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>

  <script>
    $(document).ready(function() {
      // Data pemesanan dari server
      const sewaSpots = @json($sewaSpots);

      // Variabel untuk menyimpan sesi yang dipilih
      let selectedSesi = '';

      // Fungsi untuk mengecek ketersediaan spot setelah perubahan tanggal atau sesi
      function checkSpotAvailability() {
        var selectedDate = $('#tanggal_sewa').val();

        // Cek ketersediaan spot pada tanggal dan sesi yang dipilih
        if (selectedDate && selectedSesi) {
          $('.spot').each(function() {
            var spotId = $(this).attr('id').split('-')[1];
            if (checkAvailability(selectedDate, selectedSesi, spotId)) {
              $(this).addClass('btn-secondary disabled').removeClass('btn-primary').prop('disabled', true).css('cursor', 'not-allowed');
            } else {
              $(this).removeClass('btn-secondary disabled selected').addClass('btn-primary').prop('disabled', false).css('cursor', 'pointer');
            }
          });
          $('.sesi-button').each(function() {
          var sesi = $(this).data('sesi');
          var spotBooked = checkAvailability(selectedDate, sesi);
          if (spotBooked) {
            $(this).addClass('disabled').prop('disabled', true);
          } else {
            $(this).removeClass('disabled').prop('disabled', false);
          }
        });
        }
      }

      // Mengatur event handler untuk button sesi
      $('.sesi-button').on('click', function() {
        selectedSesi = $(this).data('sesi');
        $('#sesi').val(selectedSesi);

        // Mengubah warna tombol yang dipilih
        $('.sesi-button').removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');

        // Periksa ketersediaan spot setelah perubahan sesi
        checkSpotAvailability();
      });

      // Mengatur event handler untuk spot
      $('.spot').on('click', function() {
        var spotId = $(this).attr('id').split('-')[1];
        $('#spot_id').val(spotId);

        var selectedDate = $('#tanggal_sewa').val();

        // Cek ketersediaan spot pada tanggal dan sesi yang dipilih
        if (selectedDate && selectedSesi) {
          if (checkAvailability(selectedDate, selectedSesi, spotId)) {
            // Jika spot sudah dipesan, tampilkan pesan dan kembalikan
            alert('Spot pada tanggal dan sesi tersebut sudah dipesan.');
            return;
          }

          // Jika spot belum dipesan, atur tampilan spot yang bisa dipesan
          $(this).addClass('selected');
          $(this).removeClass('btn-primary').addClass('btn-secondary').prop('disabled', true).css('cursor', 'not-allowed');
        }
      });

      // Setelah halaman dimuat, cek ketersediaan spot yang sudah dipesan dan nonaktifkan mereka
      checkSpotAvailability();

      // Event handler untuk perubahan tanggal sewa atau sesi yang dipilih
      $('#tanggal_sewa, #sesi').on('change', function() {
        // Reset pilihan spot
        $('.spot').removeClass('btn-secondary disabled selected').addClass('btn-primary').prop('disabled', false).css('cursor', 'pointer');

        // Periksa ketersediaan spot setelah perubahan tanggal atau sesi
        checkSpotAvailability();
      });

      // Mengatur ketersediaan button sesi berdasarkan spot yang tersedia
      function updateSesiButtonsAvailability(spotId) {
        $('.sesi-button').each(function() {
          var sesi = $(this).data('sesi');
          var spotBooked = checkAvailability(selectedDate, sesi, spotId);
          if (spotBooked) {
            $(this).addClass('disabled').prop('disabled', true);
          } else {
            $(this).removeClass('disabled').prop('disabled', false);
          }
        });
      }

      // Event handler untuk perubahan spot pada modal
      $('#spot_id').on('input', function() {
        var spotId = $(this).val();
        updateSesiButtonsAvailability(spotId);
      });


    });
  </script>


</body>
</html>
