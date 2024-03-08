@extends('Admin.Layouts.main')

@section('title', 'Dashboard')

@section('content')

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

<div class="container-fluid py-4">
    {{-- Update Jumlah Pengunjung --}}
    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-4 mb-2">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Pengunjung Pemancingan</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ isset($visitors) ? $visitors->jumlah : 0 }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="numbers">
                                {{-- Update jumlah pengunjung --}}
                                <form method="post" action="/admin/dashboard/updatePengunjung">
                                    @csrf
                                    <div class="input-group p-1 col-8">
                                        <input name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Update Jumlah Pengunjung">
                                        <button class="btn btn-outline-primary mb-0" type="submit">Update</button>
                                    </div>
                                    @if(isset($visitors) && $visitors->updated_at)
                                    <div class="p-0">
                                        <a style="color: grey; font-size: 14px; margin-right: 4px" class="p-1">Tanggal terakhir kali diperbarui: {{ $visitors->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</a>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Jumlah Pengunjung --}}
    {{-- <div class="row mt-3">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column h-100">
                              {{-- Button Tambah Gambar --}}
                              {{-- <h5 class="font-weight-bolder p-2">Grafik Jumlah Pengunjung Pemancingan</h5>   --}}
                              {{--  kode chart --}}
                            {{-- </div>                            
                        </div>                                                
                      </div>
                    </div>                  
                </div>
            </div>
        </div>   
    </div>     --}} 
    
    {{-- Galeri --}}
    <div class="row mt-3">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column h-100">
                              {{-- Button Tambah Gambar --}}
                              <h5 class="font-weight-bolder">Galeri Pemancingan</h5>
                                <form action="/admin/dashboard/uploadGambar" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  <div class="col-12 text-end mb-3">
                                    <button class="btn btn-outline-primary mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Upload</button>
                                  </div>  
                                <!-- Modal Upload Gambar -->
                                <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload Gambar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form>
                                          <div class="form-group">
                                            <input type="file" class="form-control" value="Creative Tim" name="image" id="image">
                                          </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn bg-gradient-primary">Upload</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </form>                              
                                @if($images->isEmpty())
                                    <h6 class="text-muted text-center">Belum ada gambar yang ditambahkan</h6>
                                @endif                              
                            </div>
                        </div>
                        {{-- card gambar --}}
                        @foreach($images as $image)
                          <div class="col-lg-2 text-center mt-5 mt-lg-0">
                              <div class="border-radius-lg position-relative">
                                  <!-- Tambahkan tombol maximize dan hapus -->
                                  <div class="position-absolute top-0 end-0 p-2" style="z-index: 999;">
                                      <button class="btn btn-transparent maximize" data-image="{{ asset('images/' . $image->filename) }}">
                                          <i class="fa fa-expand"></i>
                                      </button>
                                      <button class="btn btn-transparent delete" data-imageId="{{ $image->id }}">
                                          <i class="fa fa-trash"></i>
                                      </button>
                                  </div>

                                  <div class="position-relative d-flex align-items-center justify-content-start h-100">
                                      @if($image->filename)
                                          <img class="w-100 position-relative z-index-2" src="{{ asset('images/' . $image->filename) }}" alt="{{ asset('images/' . $image->filename) }}">
                                      @endif
                                  </div>
                              </div>
                          </div>
                        @endforeach 
                        {{-- Modal Maximize --}}
                        <div class="modal fade" id="maximizeModal" tabindex="-1" aria-labelledby="maximizeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!-- Tombol close modal -->
                                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="maximizedImage" src="#" class="img-fluid" alt="Gambar Diperbesar" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>                    
                        {{-- Modal Delete --}}
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus gambar ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deleteForm" action="/admin/dashboard/hapusGambar/{id}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="image_id" id="deleteImageId"> <!-- Tambahkan input hidden untuk image_id -->
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
                                        </form>
                                    </div>                                    
                                </div>
                            </div>
                        </div>                         
                      </div>
                    </div>

                    {{-- Pagination --}}
                    <!-- Tampilkan pagination -->
                    <nav class="p-3" aria-label="Pagination">
                      <ul class="pagination">
                          <li class="page-item {{ $images->previousPageUrl() ? '' : 'disabled' }}">
                              <a class="page-link" href="{{ $images->previousPageUrl() ?? '#' }}" tabindex="-1">
                                  <i class="fa fa-angle-left"></i>
                                  <span class="sr-only">Previous</span>
                              </a>
                          </li>
                          <!-- Tampilkan nomor halaman -->
                          @for ($i = 1; $i <= $images->lastPage(); $i++)
                              <li class="page-item {{ $images->currentPage() == $i ? 'active' : '' }}">
                                  <a class="page-link" href="{{ $images->url($i) }}">{{ $i }}</a>
                              </li>
                          @endfor
                          <li class="page-item {{ $images->nextPageUrl() ? '' : 'disabled' }}">
                              <a class="page-link" href="{{ $images->nextPageUrl() ?? '#' }}">
                                  <i class="fa fa-angle-right"></i>
                                  <span class="sr-only">Next</span>
                              </a>
                          </li>
                      </ul>
                    </nav>
                    {{-- End Pagination --}}                 
            </div>
        </div>
    </div>

    {{-- Forum Pemancingan --}}
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex flex-column">
                        <h5 class="font-weight-bolder mb-0">Forum Pemancingan</h5>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
    {{-- Footer --}}
    <footer class="footer pt-3  ">
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
</div>

{{-- Javascript Menu Galeri --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Menangani klik tombol maximize
        $('.maximize').on('click', function() {
            const imageUrl = $(this).data('image');
            $('#maximizedImage').attr('src', imageUrl);
            $('#maximizeModal').modal('show');
        });

        // Menangani klik tombol delete
        $(document).on('click', '.delete', function() {
            const imageId = $(this).data('imageid');
            $('#deleteModal').modal('show');

            // Mengatur nilai image_id pada input hidden
            $('#deleteImageId').val(imageId);

            // Mengubah action form berdasarkan ID gambar yang dipilih
            $('#deleteForm').attr('action', '/admin/dashboard/hapusGambar/' + imageId);
        });
    });
</script>

{{-- Grafik Jumlah Pengunjung --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik (contoh data)
    var data = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [{
            label: "Jumlah Pengunjung",
            backgroundColor: "rgba(75,192,192,0.2)",
            borderColor: "rgba(75,192,192,1)",
            borderWidth: 1,
            data: [65, 59, 80, 81, 56, 55], // Contoh data jumlah pengunjung per bulan
        }]
    };

    // Konfigurasi grafik
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Inisialisasi grafik
    var ctx = document.getElementById('line-chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
</script> --}}

@endsection