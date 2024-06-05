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
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
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
      <div class="card-body p-7">
          <div class="kolam">
            <h1 style="color: white;">Kolam</h1>
            <div class="spot-container">
              <!-- Bagian atas (1-15) dari kiri ke kanan -->
              @for ($i = 1; $i <= 15; $i++)
              <div class="spot top" data-id="{{ $i }}" data-bs-toggle="modal" data-bs-target="#spotModal" style="left: calc(({{ $i }} - 1) * 80px);">{{ $i }}</div>
              @endfor

              <!-- Bagian kanan (16-20) dari atas ke bawah -->
              @for ($i = 16; $i <= 20; $i++)
              <div class="spot right" data-id="{{ $i }}" data-bs-toggle="modal" data-bs-target="#spotModal" style="top: calc(({{ $i }} - 16) * 80px);">{{ $i }}</div>
              @endfor

              <!-- Bagian bawah (21-35) dari kanan ke kiri -->
              @for ($i = 35; $i >= 21; $i--)
              <div class="spot bottom" data-id="{{ $i }}" data-bs-toggle="modal" data-bs-target="#spotModal" style="left: calc((35 - {{ $i }}) * 80px);">{{ $i }}</div>
              @endfor

              <!-- Bagian kiri (36-40) dari bawah ke atas -->
              @for ($i = 40; $i >= 36; $i--)
              <div class="spot left" data-id="{{ $i }}" data-bs-toggle="modal" data-bs-target="#spotModal" style="top: calc((40 - {{ $i }}) * 80px);">{{ $i }}</div>
              @endfor
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
            <form id="pesanForm">
                <div class="form-group">
                    <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ auth()->user()->nama }}" disabled>
                </div>                
                <div class="form-group">
                    <label for="tanggal_sewa" class="col-form-label">Tanggal Sewa</label>
                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                </div>
                <div class="row row-cols-2">
                    <div class="col form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                    </div>
                    <div class="col form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" id="pesanButton">Sewa</button>
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

  <!-- Tambahkan script untuk mengatur perilaku spot -->
  <script>
      $(document).ready(function() {
        // Fungsi untuk mengubah warna spot yang sudah dipesan menjadi abu
        function updateSpotColor() {
          $(".spot").each(function() {
            if ($(this).hasClass("submitted")) {
              $(this).css("background-color", "gray");
              $(this).css("border-color", "gray");
              $(this).removeAttr("data-bs-toggle data-bs-target");
            } else {
              $(this).css("background-color", "green"); // Warna hijau untuk spot yang belum dipilih
              $(this).css("border-color", "green");
            }
          });
        }
    
        // Panggil fungsi saat halaman dimuat
        updateSpotColor();
    
        $(".spot").click(function() {
          // Jika spot belum dipilih dan belum dipesan
          if (!$(this).hasClass("selected") && !$(this).hasClass("submitted")) {
            $(this).addClass("selected"); // Tambahkan kelas selected
            $(this).css("background-color", "lightgray"); // Ubah warna background menjadi abu
            $(this).css("border-color", "lightgray"); // Ubah warna border menjadi abu
            $(this).removeAttr("data-bs-toggle data-bs-target"); // Hapus atribut data-bs-toggle dan data-bs-target
          }
        });
    
        // Fungsi untuk mengirim pesanan
        $("#pesanButton").click(function() {
          // Validasi form sebelum mengirim pesanan
          if ($("#pesanForm")[0].checkValidity()) {
            // Kirim data pesanan ke backend (simulasi)
            $.ajax({
              url: 'url_backend_anda', // Ganti dengan URL endpoint backend Anda
              type: 'POST',
              data: $("#pesanForm").serialize(), // Menggunakan data form yang di-serialize
              success: function(response) {
                // Spot yang dipilih berubah warna menjadi abu gelap
                $(".spot.selected").addClass("submitted");
                $(".spot.submitted").css("background-color", "gray");
                $(".spot.submitted").css("border-color", "gray");
                $(".spot.submitted").removeClass("selected");
    
                // Panggil fungsi untuk mengupdate warna spot setelah mengirim pesanan
                updateSpotColor();
    
                alert("Pesanan berhasil dikirim!");
                $("#spotModal").modal("hide"); // Sembunyikan modal setelah pesanan berhasil dikirim
              },
              error: function(xhr, status, error) {
                console.error(error); // Log error jika terjadi kesalahan saat mengirim data
                alert("Terjadi kesalahan saat mengirim pesanan.");
              }
            });
          } else {
            // Tampilkan pesan error jika form tidak valid
            alert("Mohon lengkapi semua kolom form.");
          }
        });
      });
  </script>
  

</body>
</html>
