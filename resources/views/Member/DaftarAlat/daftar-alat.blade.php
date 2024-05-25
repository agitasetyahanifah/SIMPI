<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
  <title>
    SIMPI | Alat Pancing
  </title>
  <!-- Fonts and icons -->
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
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery dan Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

  <style>
    .fixed-image {
      width: 100%;
      height: 150px;
      object-fit: cover;
      object-position: center;
    }

    .fixed-image2 {
      width: 100%;
      height: 200px;
      object-fit: cover;
      object-position: center;
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

    hr {
      margin: 1rem 0;
      color: inherit; /* mewarisi warna teks dari elemen induknya */
      border: 0;
      border-top: 1px solid grey; /* tambahkan warna border */
      opacity: 0.75; /* tingkatkan opacity agar lebih terlihat */
  } 
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('Member.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('member.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Kembali</a>
      </div>
      <div class="mt-3 mb-4">
        <h2 class="font-weight-bolder mt-4 mb-3 text-center"><b>Daftar Alat Pancing yang Disewakan</b></h2>
      </div>
      <div class="row gx-2">
        @foreach($alatPancing as $alat)
        <div class="col-lg-2 col-md-3 col-sm-4 col-4 g-1 mb-1">
          <div class="card h-100">
            <div class="card">
              @if($alat->foto && file_exists(public_path('images/'.$alat->foto)))
                <img src="{{ asset('images/'.$alat->foto) }}" class="card-img-top fixed-image" alt="{{ $alat->nama_alat }}">
              @else
                 <img src="https://source.unsplash.com/random/450x450?fishing" class="card-img-top fixed-image" alt="Fishing Image">
              @endif
              <div class="card-body2">
                  <h5 class="card-title2">{{ $alat->nama_alat }}</h5>
                  <p class="card-text2" style="color: orangered;">Rp {{ number_format($alat->harga, 0, ',', '.') }}/hari</p>
                  <div class="text-center">
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}">Detail</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      {{-- Cek ada data atau kosong --}}
      @if($alatPancing->isEmpty())
        <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
      @endif
    </div>
    <!-- Pagination -->
    <nav class="p-3" aria-label="Pagination">
      <ul class="pagination justify-content-center">
        <li class="page-item {{ $alatPancing->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $alatPancing->previousPageUrl() ?? '#' }}" tabindex="-1">
                  <i class="fa fa-angle-left"></i>
                  <span class="sr-only">Previous</span>
              </a>
          </li>
          <!-- Tampilkan nomor halaman -->
          @for ($i = 1; $i <= $alatPancing->lastPage(); $i++)
              <li class="page-item {{ $alatPancing->currentPage() == $i ? 'active' : '' }}">
                  <a class="page-link" href="{{ $alatPancing->url($i) }}">{{ $i }}</a>
              </li>
          @endfor
          <li class="page-item {{ $alatPancing->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $alatPancing->nextPageUrl() ?? '#' }}">
                  <i class="fa fa-angle-right"></i>
                  <span class="sr-only">Next</span>
              </a>
          </li>
      </ul>
    </nav>
    <!-- End Pagination -->
    <!-- Modal Detail Alat Pancing -->
    @foreach($alatPancing as $alat)
    <div class="modal fade" id="detailModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $alat->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $alat->id }}">Detail Alat Pancing</h5>
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
                            <img src="https://source.unsplash.com/random/450x450?fishing" class="img-fluid" alt="Fishing Image">
                          @endif                        </div>
                        <div class="col-md-6">
                            <h5>{{ $alat->nama_alat }}</h5>
                            <p>Harga: {{ number_format($alat->harga, 0, ',', '.') }} /hari</p>
                            <p>Jumlah: {{ $alat->jumlah }}</p>
                            <p>Status: <span class="badge {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span></p>
                            <p>Spesifikasi: </p><p style="text-align: justify;">{!! nl2br(e($alat->spesifikasi)) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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

  <div class="modal fade" id="maximizeModal" tabindex="-1" role="dialog" aria-labelledby="maximizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img id="maximizedImage" src="" class="img-fluid" alt="Maximized Image">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('.maximize').on('click', function() {
        const imageUrl = $(this).data('image');
        $('#maximizedImage').attr('src', imageUrl);
        $('#maximizeModal').modal('show');
      });
    });
  </script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>
</html>
