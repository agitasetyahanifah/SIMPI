<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>
    SIMPI | Fishing Spot
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

    .btn.disabled {
        background-color: lightgray !important;
        border-color: lightgray !important;
        color: gray !important;
        cursor: not-allowed;
        }

  </style>

</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('Guest.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('guest.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Back</a>
      </div>
      <div class="mt-3 mb-4 d-flex justify-content-between align-items-center">
        <h2 class="font-weight-bolder mt-4 mb-3 mx-auto">Fishing Spot</h2>
        {{-- <a href="{{ route('member.spots.riwayat-sewa') }}" class="btn btn-primary mb-3 mb-sm-0">Reservation History</a> --}}
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
      
      <div class="card-body p-6 mb-4">
          <div class="kolam">
            <h1 style="color: white;">Pool</h1>
            <div class="spot-container">

            <!-- Bagian atas (1-15) dari kiri ke kanan -->
            @foreach ($spots->whereBetween('nomor_spot', ['01', '15']) as $spot)
            @php
                $selectedDate = date('Y-m-d');
                $spotSesi = $sewaSpots->where('spot_id', $spot->id)->where('tanggal_sewa', $selectedDate);
                $spotBookedSesi = $spotSesi->pluck('sesi_id')->toArray();
                $statusPembayaran = $spotSesi->pluck('status', 'sesi_id')->toArray();
                
                // Ambil semua sesi yang mungkin ada
                $allSesi = \App\Models\UpdateSesiSewaSpot::pluck('id', 'waktu_sesi')->toArray();
                $availableSesiIds = array_diff(array_keys($allSesi), $spotBookedSesi);

                // Tampilkan spot jika ada sesi yang tersedia
                $isSpotAvailable = count($availableSesiIds) > 0;
            @endphp
            <div id="spot-{{ $spot->id }}" class="spot top{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                data-bs-toggle="{{ !$isSpotAvailable ? '' : 'modal' }}" 
                data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                data-spot-id="{{ $spot->id }}" 
                data-status-pembayaran="{{ json_encode($statusPembayaran) }}"
                data-available="{{ $isSpotAvailable ? 'true' : 'false' }}"
                style="left: calc(({{ ltrim($spot->nomor_spot, '0') }} - 1) * 80px);">
                {{ $spot->nomor_spot }}
            </div>
            @endforeach

            <!-- Bagian kanan (16-20) dari atas ke bawah -->
            @foreach ($spots->whereBetween('nomor_spot', ['16', '20']) as $spot)
            @php
                $selectedDate = date('Y-m-d');
                $spotSesi = $sewaSpots->where('spot_id', $spot->id)->where('tanggal_sewa', $selectedDate);
                $spotBookedSesi = $spotSesi->pluck('sesi_id')->toArray();
                $statusPembayaran = $spotSesi->pluck('status', 'sesi_id')->toArray();
                
                // Ambil semua sesi yang mungkin ada
                $allSesi = \App\Models\UpdateSesiSewaSpot::pluck('id', 'waktu_sesi')->toArray();
                $availableSesiIds = array_diff(array_keys($allSesi), $spotBookedSesi);

                // Tampilkan spot jika ada sesi yang tersedia
                $isSpotAvailable = count($availableSesiIds) > 0;
            @endphp
            <div id="spot-{{ $spot->id }}" class="spot right{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                data-bs-toggle="{{ !$isSpotAvailable ? '' : 'modal' }}" 
                data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                data-spot-id="{{ $spot->id }}" 
                data-status-pembayaran="{{ json_encode($statusPembayaran) }}"
                data-available="{{ $isSpotAvailable ? 'true' : 'false' }}"
                style="top: calc(({{ ltrim($spot->nomor_spot, '0') }} - 16) * 80px);">
                {{ $spot->nomor_spot }}
            </div>
            @endforeach

            <!-- Bagian bawah (21-35) dari kanan ke kiri -->
            @foreach ($spots->whereBetween('nomor_spot', ['21', '35']) as $spot)
            @php
                $selectedDate = date('Y-m-d');
                $spotSesi = $sewaSpots->where('spot_id', $spot->id)->where('tanggal_sewa', $selectedDate);
                $spotBookedSesi = $spotSesi->pluck('sesi_id')->toArray();
                $statusPembayaran = $spotSesi->pluck('status', 'sesi_id')->toArray();
                
                // Ambil semua sesi yang mungkin ada
                $allSesi = \App\Models\UpdateSesiSewaSpot::pluck('id', 'waktu_sesi')->toArray();
                $availableSesiIds = array_diff(array_keys($allSesi), $spotBookedSesi);

                // Tampilkan spot jika ada sesi yang tersedia
                $isSpotAvailable = count($availableSesiIds) > 0;
            @endphp
            <div id="spot-{{ $spot->id }}" class="spot bottom{{ !$isSpotAvailable ? ' disabled' : '' }}" 
                data-bs-toggle="{{ !$isSpotAvailable ? '' : 'modal' }}" 
                data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                data-spot-id="{{ $spot->id }}" 
                data-status-pembayaran="{{ json_encode($statusPembayaran) }}"
                data-available="{{ $isSpotAvailable ? 'true' : 'false' }}"
                style="left: calc((35 - {{ ltrim($spot->nomor_spot, '0') }}) * 80px);">
                {{ $spot->nomor_spot }}
            </div>
            @endforeach

            <!-- Bagian kiri (36-40) dari bawah ke atas -->
            @foreach ($spots->whereBetween('nomor_spot', ['36', '40']) as $spot)
            @php
                $selectedDate = date('Y-m-d');
                $spotSesi = $sewaSpots->where('spot_id', $spot->id)->where('tanggal_sewa', $selectedDate);
                $spotBookedSesi = $spotSesi->pluck('sesi_id')->toArray();
                $statusPembayaran = $spotSesi->pluck('status', 'sesi_id')->toArray();
                
                // Ambil semua sesi yang mungkin ada
                $allSesi = \App\Models\UpdateSesiSewaSpot::pluck('id', 'waktu_sesi')->toArray();
                $availableSesiIds = array_diff(array_keys($allSesi), $spotBookedSesi);

                // Tampilkan spot jika ada sesi yang tersedia
                $isSpotAvailable = count($availableSesiIds) > 0;
            @endphp
            <div id="spot-{{ $spot->id }}" class="spot left{{ !$isSpotAvailable ? ' disabled' : '' }}"
                data-bs-toggle="{{ !$isSpotAvailable ? '' : 'modal' }}" 
                data-bs-target="{{ !$isSpotAvailable ? '' : '#spotModal' }}" 
                data-spot-id="{{ $spot->id }}" 
                data-status-pembayaran="{{ json_encode($statusPembayaran) }}"
                data-available="{{ $isSpotAvailable ? 'true' : 'false' }}"
                style="top: calc((40 - {{ ltrim($spot->nomor_spot, '0') }}) * 80px);">
                {{ $spot->nomor_spot }}
            </div>
            @endforeach

            </div>          
          </div>        
      </div>

    </div>

    <!-- Modal Sewa Spot Pemancingan -->
    <div class="modal fade" id="spotModal" tabindex="-1" aria-labelledby="spotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="spotModalLabel">Fishing Spot Reservation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="sewaSpotForm">
                      @csrf

                      <div class="text-center">
                          <a class="btn btn-outline-primary" style="font-size: 18pt"><span id="selectedSpotNumber"></span></a>
                      </div>

                      <div class="form-group">
                          <label for="nama_pelanggan" class="col-form-label">Customer Name</label>
                          <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" disabled>
                      </div>                
                      <div class="form-group">
                          <label for="tanggal_sewa" class="col-form-label">Booking Date</label>
                          <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                      </div>
                      <div class="form-group mb-0">
                          <label for="sesi" class="col-form-label">Select Session:</label>
                          <div id="sesiButtons">
                            @foreach ($sessions as $session)
                                <button type="button" class="btn btn-outline-primary sesi-button" data-sesi-id="{{ $session->id }}">
                                    {{ $session->waktu_sesi }}
                                </button>
                            @endforeach
                        </div>                        
                      </div>                                    
                      <div class="mb-3">
                        <label for="harga_id_display" class="col-form-label">Price:</label>
                        <input type="text" class="form-control" id="harga_id_display" name="harga_id_display" value="Rp {{ number_format($nonMemberPrice, 0, ',', '.') }},-" disabled>
                        {{-- <input type="hidden" name="harga_id" id="harga_id" value="{{ $harga_id }}"> --}}
                      </div>

                      <input type="hidden" name="spot_id" id="selectedSpotId" value="">
                      <input type="hidden" name="sesi_id" id="sesi_id" value="" required>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <a href="{{ route('login') }}" type="submit" class="btn btn-primary">Book</a>
                      </div>
                  </form>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


  <script>
    $(document).ready(function() {
      $('.spot').click(function() {
        var selectedSpot = $(this).text();
        $('#selectedSpotNumber').text(selectedSpot);
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var editTanggalSewaInputs = document.querySelectorAll('.edit_tanggal_sewa');

      editTanggalSewaInputs.forEach(function(input) {
          input.addEventListener('change', function() {
              var date = this.value;
              var pemancinganId = this.dataset.pemancinganId;

              var xhr = new XMLHttpRequest();
              xhr.open('GET', '/api/available-spots?date=' + date + '&pemancingan_id=' + pemancinganId);
              xhr.onload = function() {
                  if (xhr.status === 200) {
                      var response = JSON.parse(xhr.responseText);
                      var spotSelect = document.querySelector('#edit_spot_id_' + pemancinganId);
                      spotSelect.innerHTML = '';

                      if (response.length > 0) {
                          response.forEach(function(spot) {
                              var option = document.createElement('option');
                              option.value = spot.id;
                              option.textContent = spot.nomor_spot;
                              spotSelect.appendChild(option);
                          });
                      } else {
                          var option = document.createElement('option');
                          option.value = '';
                          option.textContent = 'No spots available';
                          spotSelect.appendChild(option);
                      }
                  } else {
                      console.error('Request failed. Status: ' + xhr.status);
                  }
              };
              xhr.send();
          });
      });

      document.addEventListener('change', function(event) {
          if (event.target.classList.contains('edit_spot_id')) {
              var spotId = event.target.value;
              var date = document.querySelector('#edit_tanggal_sewa_' + event.target.dataset.pemancinganId).value;
              var pemancinganId = event.target.dataset.pemancinganId;

              var xhr = new XMLHttpRequest();
              xhr.open('GET', '/api/available-sessions?date=' + date + '&spot_id=' + spotId + '&pemancingan_id=' + pemancinganId);
              xhr.onload = function() {
                  if (xhr.status === 200) {
                      var response = JSON.parse(xhr.responseText);
                      var sessionSelect = document.querySelector('#edit_sesi_' + pemancinganId);
                      sessionSelect.innerHTML = '';

                      if (response.length > 0) {
                          response.forEach(function(session) {
                              var option = document.createElement('option');
                              option.value = session;
                              option.textContent = session;
                              sessionSelect.appendChild(option);
                          });
                      } else {
                          var option = document.createElement('option');
                          option.value = '';
                          option.textContent = 'No sessions available';
                          sessionSelect.appendChild(option);
                      }
                  } else {
                      console.error('Request failed. Status: ' + xhr.status);
                  }
              };
              xhr.send();
          }
      });
    });
  </script>  

  {{-- Javascript ambil spot id dan sesi id --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sesiButtons = document.querySelectorAll('#sesiButtons .btn');
        const spotButtons = document.querySelectorAll('.spot:not(.disabled)'); // Select only enabled spot buttons
        const sesiIdInput = document.getElementById('sesi_id');
        const spotIdInput = document.getElementById('selectedSpotId');
        const selectedSpotNumberElement = document.getElementById('selectedSpotNumber');
  
        // Handle sesi button click
        sesiButtons.forEach(button => {
            button.addEventListener('click', function() {
                sesiButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const selectedSesiId = this.getAttribute('data-sesi-id');
                sesiIdInput.value = selectedSesiId;
            });
        });
  
        // Handle spot button click
        spotButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedSpotId = this.getAttribute('data-spot-id');
                spotIdInput.value = selectedSpotId;
                selectedSpotNumberElement.textContent = this.textContent.trim();
            });
        });
  
        // Before submitting the form, ensure both sesi_id and spot_id are set
        document.getElementById('sewaSpotForm').addEventListener('submit', function(event) {
            if (!sesiIdInput.value || !spotIdInput.value) {
                event.preventDefault();
                alert('Please select both a session and a spot.');
                return false;
            }
        });
    });
  </script>

  {{-- Javascript menangani sesi id dan spot id yang sudah dipesan menjadi disabled --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedSpotId = null;
    
        function updateSesiButtons(spotId, tanggalSewa) {
            const sesiButtons = document.querySelectorAll('.sesi-button');
    
            // Reset tombol sesi
            sesiButtons.forEach(button => {
                button.classList.remove('disabled');
                button.disabled = false;
                button.classList.remove('btn-primary');
                button.classList.add('btn-outline-primary');
            });
    
            // AJAX request untuk mengecek ketersediaan sesi
            $.ajax({
                url: '/guest/cek-ketersediaan',
                type: 'GET',
                data: {
                    tanggal_sewa: tanggalSewa,
                    spot_id: spotId
                },
                success: function(data) {
                    const { disabled_sesi, available_spots } = data;
    
                    // Menandai tombol sesi yang tidak tersedia
                    sesiButtons.forEach(button => {
                        const sesiId = $(button).data('sesi-id');
                        if (disabled_sesi.includes(sesiId)) {
                            button.classList.add('disabled');
                            button.disabled = true;
                            button.classList.remove('btn-outline-primary');
                            button.classList.add('btn-primary');
                        } else {
                            button.classList.remove('disabled');
                            button.disabled = false;
                        }
                    });
    
                    // Menandai spot yang tidak memiliki sesi yang tersedia
                    document.querySelectorAll('.spot').forEach(spot => {
                        const spotId = spot.getAttribute('data-spot-id');
                        if (!available_spots.includes(parseInt(spotId, 10))) {
                            spot.classList.add('disabled');
                            spot.style.cursor = 'not-allowed';
                            // Hapus event listener klik pada spot yang dinonaktifkan
                            spot.removeEventListener('click', handleSpotClick);
                        } else {
                            spot.classList.remove('disabled');
                            spot.style.cursor = 'pointer';
                            // Tambahkan event listener klik kembali jika diperlukan
                            spot.addEventListener('click', handleSpotClick);
                        }
                    });
                }
            });
        }
    
        function handleSpotClick() {
            if (this.classList.contains('disabled')) {
                return;
            }
            selectedSpotId = this.getAttribute('data-spot-id');
            document.getElementById('selectedSpotId').value = selectedSpotId;
            const selectedDate = document.getElementById('tanggal_sewa').value;
            updateSesiButtons(selectedSpotId, selectedDate);
        }
    
        document.querySelectorAll('.spot').forEach(spot => {
            // Nonaktifkan spot berdasarkan data-available saat halaman dimuat
            if (spot.getAttribute('data-available') === 'false') {
                spot.classList.add('disabled');
                spot.style.cursor = 'not-allowed';
                spot.removeEventListener('click', handleSpotClick);
            } else {
                spot.style.cursor = 'pointer';
                spot.addEventListener('click', handleSpotClick);
            }
        });
    
        document.querySelectorAll('.sesi-button').forEach(button => {
            button.addEventListener('click', function() {
                if (button.classList.contains('disabled')) {
                    return;
                }
    
                // Reset semua tombol sesi yang dipilih
                document.querySelectorAll('.sesi-button').forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                });
    
                // Pilih tombol sesi yang diklik
                const sesi = button.getAttribute('data-sesi-id');
                document.querySelector('input[name="sesi_id"]').value = sesi;
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');
            });
        });
    
        document.getElementById('tanggal_sewa').addEventListener('change', function() {
            const selectedDate = this.value;
            if (selectedSpotId) {
                updateSesiButtons(selectedSpotId, selectedDate);
            }
        });
    
        document.getElementById('spotModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('sewaSpotForm').reset();
            selectedSpotId = null;
            document.getElementById('selectedSpotId').value = '';
        });
    
        // Trigger the initial update to disable unavailable spots
        const initialSpotId = document.querySelector('.spot:not(.disabled)')?.getAttribute('data-spot-id');
        const initialDate = document.getElementById('tanggal_sewa')?.value || date('Y-m-d');
        if (initialSpotId) {
            updateSesiButtons(initialSpotId, initialDate);
        }
    });
  </script>    
 
</body>
</html>
