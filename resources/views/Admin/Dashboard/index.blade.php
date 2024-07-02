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

    <div class="card p-3">
        <div class="row">
            <div class="col-md-3">
                <img src="../images/hai.jpg" alt="hai.jpd" style="width: 300px; height:auto">
            </div>
            <div class="col-md-9 d-flex align-items-center">
                <h2>
                    Welcome, <a style="color: #FF9940">{{ Auth::user()->nama }}</a> ! 
                </h2>
            </div>
        </div>
    </div>
    
    {{-- Galeri --}}
    <div class="row mt-3">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column h-100">
                              {{-- Button Tambah Gambar --}}
                              <h5 class="font-weight-bolder">Fishing Gallery</h5>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
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
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </form>                              
                                @if($images->isEmpty())
                                    <h6 class="text-muted text-center">No images have been added yet</h6>
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
                        <div>
                            <div class="modal fade" id="maximizeModal" tabindex="-1" aria-labelledby="maximizeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <!-- Tombol close modal -->
                                            <button type="button" class="btn-close btn-close-white position-absolute top-2 end-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex align-items-center justify-content-center">
                                            <img id="maximizedImage" src="#" class="img-fluid" alt="Gambar Diperbesar" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                        {{-- Modal Delete --}}
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure want to delete this image?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deleteForm" action="/admin/dashboard/{id}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="image_id" id="deleteImageId">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
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

</div>
</div>

{{-- Javascript Menu Galeri --}}
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
            $('#deleteForm').attr('action', '/admin/dashboard/' + imageId);
        });
    });
</script>

@endsection