<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <title>
    SIMPI | Blog Pemancingan
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
    .fixed-image {
      width: 100%;
      height: 450px;
      object-fit: cover;
      object-position: center;
    }
    .latest-blog-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>

  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('Guest.Layouts.navbar')

    <div class="container-fluid py-2">
      <div class="mt-3 mb-2">
        <a href="{{ route('guest.blog.index') }}"><i class="fa fa-arrow-left mt-3 mb-3 mx-2" style="font-size: 12pt;"></i>Kembali</a>
      </div>
      <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12 mb-4">
            <div class="card">
              @if($blog->image && file_exists(public_path('images/'.$blog->image)))
                <img src="{{ asset('images/'.$blog->image) }}" class="card-img-top fixed-image" alt="{{ $blog->judul }}">
              @else
                <img src="https://source.unsplash.com/random/450x300?fishing" class="card-img-top fixed-image" alt="Fishing Image">
              @endif
              <div class="card-body">
                <h2 class="card-title mb-3">{{ $blog->judul }}</h2>
                <a style="color: orange"><i class="fa fa-list ms-2" style="margin-right: 2pt"></i> {{ $blog->kategoriBlog->kategori_blog }}</a>
                <a class="text-muted ms-3"><i class="fa fa-clock ms-2" style="margin-right: 2pt"></i> Last updated {{ $blog->updated_at->diffForHumans() }}</a>
                <div class="mt-3" style="text-align: justify;">
                  {!! $blog->body !!}
                </div>
              </div>
            </div>
        </div>          
        <div class="col-lg-4 col-md-6 col-sm-12">
          <h4>Latest Blogs</h4>
          @foreach($latestBlogs as $latestBlog)
            <div class="card mb-3" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  @if($latestBlog->image && file_exists(public_path('images/'.$latestBlog->image)))
                    <img src="{{ asset('images/'.$latestBlog->image) }}" class="img-fluid rounded-start latest-blog-image" alt="{{ $latestBlog->judul }}">
                  @else
                    <img src="https://source.unsplash.com/random/450x300?fishing" class="img-fluid rounded-start latest-blog-image" alt="Fishing Image">
                  @endif
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">{{ $latestBlog->judul }}</h5>
                    <p class="card-text">{{ Str::words(strip_tags($latestBlog->body), 12, '...') }} <a href="{{ route('guest.blog.detail-blog', $latestBlog->id) }}" style="color: aqua;">Selengkapnya</a></p>
                    <p class="card-text"><small class="text-body-secondary">Last updated {{ $latestBlog->updated_at->diffForHumans() }}</small></p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
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
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>
</body>
</html>
