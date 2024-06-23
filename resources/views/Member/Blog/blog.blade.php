<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
  <title>
    SIMPI | Fishing Blogs
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
        <a href="{{ route('member.landingpage.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Back</a>
      </div>
      <div class="mt-3 mb-4">
        <h2 class="font-weight-bolder mt-4 mb-3 text-center"><b>Fishing Blogs</b></h2>
      </div>
      <div class="row gx-2">
        @foreach($blogs as $blog)
        <div class="col-lg-3 col-md-4 col-sm-12 col-6 mb-1 g-1">
          <div class="card h-100">
            @if($blog->image && file_exists(public_path('images/'.$blog->image)))
              <img src="{{ asset('images/'.$blog->image) }}" class="card-img-top fixed-image" alt="{{ $blog->judul }}">
            @else
              <img src="{{ asset('../images/ex-blog.png') }}" class="card-img-top fixed-image" alt="Fishing Image">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $blog->judul }}</h5>
              <p class="card-text">{{ Str::words(strip_tags($blog->body), 12, '...') }} <a href="{{ route('member.blog.detail-blog', $blog->id) }}" style="color: aqua;">More</a></p>
              <small class="text-muted mt-2">Last updated {{ $blog->updated_at->diffForHumans() }}</small>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      {{-- Cek ada data atau kosong --}}
      @if($blogs->isEmpty())
        <h6 class="text-muted text-center">No data has been added yet</h6>
      @endif
    </div>
    <!-- Pagination -->
    <nav class="p-3" aria-label="Pagination">
      <ul class="pagination justify-content-center">
        <li class="page-item {{ $blogs->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $blogs->previousPageUrl() ?? '#' }}" tabindex="-1">
                  <i class="fa fa-angle-left"></i>
                  <span class="sr-only">Previous</span>
              </a>
          </li>
          <!-- Tampilkan nomor halaman -->
          @for ($i = 1; $i <= $blogs->lastPage(); $i++)
              <li class="page-item {{ $blogs->currentPage() == $i ? 'active' : '' }}">
                  <a class="page-link" href="{{ $blogs->url($i) }}">{{ $i }}</a>
              </li>
          @endfor
          <li class="page-item {{ $blogs->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $blogs->nextPageUrl() ?? '#' }}">
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

  <div class="modal fade" id="maximizeModal" tabindex="-1" role="dialog" aria-labelledby="maximizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img id="maximizedImage" src="" class="img-fluid" alt="Maximized Image">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
