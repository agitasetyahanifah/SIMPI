<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
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
        <a href="{{ route('member.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Back</a>
      </div>
      <div class="mt-3 mb-4 d-flex justify-content-between align-items-center">
        <h2 class="font-weight-bolder mt-4 mb-3 mx-auto">Fishing Spot</h2>
        <a href="{{ route('member.spots.riwayat-sewa') }}" class="btn btn-primary mb-3 mb-sm-0">Reservation History</a>
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
      <div class="card-body p-6 mb-4">
          <div class="kolam">
            <h1 style="color: white;">Pool</h1>
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

    <!-- Modal Sewa Spot Pemancingan -->
    <div class="modal fade" id="spotModal" tabindex="-1" aria-labelledby="spotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="spotModalLabel">Fishing Spot Reservation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="sewaSpotForm" action="{{ route('member.spots.pesan-spot') }}" method="POST">
                      @csrf
                      <input type="hidden" name="spot_id" id="selectedSpotId" value="">

                      <div class="text-center">
                        <a class="btn btn-outline-primary" style="font-size: 18pt"><span id="selectedSpotNumber"></span></a>
                      </div>

                      <div class="form-group">
                        <label for="nama_pelanggan" class="col-form-label">Customer Name</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ auth()->user()->nama }}" disabled>
                      </div>                
                      <div class="form-group">
                        <label for="tanggal_sewa" class="col-form-label">Booking Date</label>
                        <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                      </div>
                      <div class="mb-3">
                          <label for="sesi" class="form-label">Select Session:</label>
                          <div id="sesiButtons">
                              <button type="button" class="btn btn-outline-primary sesi-button"
                                  data-sesi="08.00-12.00">08.00-12.00</button>
                              <button type="button" class="btn btn-outline-primary sesi-button"
                                  data-sesi="13.00-17.00">13.00-17.00</button>
                          </div>

                          <input type="hidden" id="sesi" name="sesi" required>
                      </div>
                      <div class="mb-3">
                        <a><strong>Note: </strong>Fishing Spot Rental Fee for Each Session Rp. 10,000,-</a>
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Book</button>
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
        var selectedSpotId;
    
        function updateSesiButtons(spotId, tanggalSewa) {
            var sesiButtons = document.querySelectorAll('.sesi-button');
    
            // Reset tombol sesi
            sesiButtons.forEach(function(button) {
                button.classList.remove('disabled');
                button.disabled = false;
                button.classList.remove('btn-primary');
                button.classList.add('btn-outline-primary');
            });
    
            // AJAX request untuk mengecek ketersediaan sesi
            $.ajax({
                url: '/cek-ketersediaan',
                type: 'GET',
                data: {
                    tanggal_sewa: tanggalSewa,
                    spot_id: spotId
                },
                success: function(data) {
                    var bookedSesi = data.sesi_terpesan;
                    sesiButtons.forEach(function(button) {
                        var sesi = button.getAttribute('data-sesi');
                        if (bookedSesi.includes(sesi)) {
                            button.classList.add('disabled');
                            button.disabled = true;
                            button.classList.remove('btn-outline-primary');
                            button.classList.add('btn-primary');
                        } else {
                            button.classList.remove('disabled');
                            button.disabled = false;
                        }
                    });
                }
            });
        }
    
        document.querySelectorAll('.spot').forEach(function(spot) {
            spot.addEventListener('click', function() {
                if (spot.classList.contains('disabled')) {
                    return;
                }
                selectedSpotId = spot.getAttribute('id').split('-')[1];
                document.getElementById('selectedSpotId').value = selectedSpotId;
                var selectedDate = document.getElementById('tanggal_sewa').value;
                updateSesiButtons(selectedSpotId, selectedDate);
            });
        });
    
        document.querySelectorAll('.sesi-button').forEach(function(button) {
            button.addEventListener('click', function() {
                if (button.classList.contains('disabled')) {
                    return;
                }
                var sesi = button.getAttribute('data-sesi');
                document.querySelector('input[name="sesi"]').value = sesi;
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');
            });
        });
    
        document.getElementById('tanggal_sewa').addEventListener('change', function() {
            var selectedDate = this.value;
            if (selectedSpotId) {
                updateSesiButtons(selectedSpotId, selectedDate);
            }
        });
    
        document.getElementById('spotModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('sewaSpotForm').reset();
            selectedSpotId = null;
            document.getElementById('selectedSpotId').value = '';
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
  
</body>
</html>
