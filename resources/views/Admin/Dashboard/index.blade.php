@extends('Admin.Layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}

{{-- Update jumlah pengunjung --}}
<form method="post" action="/admin/dashboard/updatePengunjung">
  @csrf
  <h6 class="update-title">Jumlah Pengunjung</h6>
  <div class="input-group mb-2">
    <span class="input-group-text custom-box">{{ isset($visitors) ? $visitors->jumlah : 0 }}</span>
    <input name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Update Jumlah Pengunjung">
    <button class="btn btn-primary" type="submit">Update</button>
  </div>
  @if(isset($visitors) && $visitors->updated_at)
  <div class="mb-4">
    <p style="color: gray;">Tanggal terakhir kali diperbarui: {{ $visitors->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</p>
  </div>
  @endif
</form>
<hr>

{{-- Menu Galeri --}}
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="update-title">Galeri Pemancingan</h6>
            <form action="/admin/dashboard/uploadGambar" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-success p-1 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <span data-feather="plus-circle"></span> Tambah
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Upload Gambar</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="input-group mb-3">
                        <input type="file" name="image" id="image" class="form-control">
                      </div>                    
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                  </div>
                </div>
              </div>
          </form>
        </div>
      </div>    
    </div>
  <div class="container">
  </div>
    <div class="row">
      <div class="col-md-12">
        <div class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                @foreach($images as $image)
                  <div class="col-md-2 mb-2 position-relative">
                      <div class="card">
                          <img src="{{ asset('images/' . $image->filename) }}" class="card-img-top" alt="...">
                          <div class="position-absolute top-0 end-0">
                              <!-- Tambahkan class 'expand-btn' dan 'delete-btn' -->
                              <button class="btn btn-light btn-sm p-0 expand-btn" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize" data-image="{{ asset('images/' . $image->filename) }}"></button>
                              <button class="btn btn-light btn-sm p-0 delete-btn" type="button" data-toggle="tooltip" title="Delete" data-feather="trash" data-image-id="{{ $image->id }}"></button>
                          </div>
                      </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          {{-- <a class="carousel-control-prev" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" role="button" data-slide="next">
            <span class="sr-only">Next</span>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </a> --}}
        </div>
      </div>
    </div>

@endsection

    {{-- Menu Galeri --}}
    <script>
      $(document).ready(function() {
          // Fungsi untuk menangani tombol expand
          $('.expand-btn').click(function() {
              var imageUrl = $(this).data('image');
              // Tampilkan gambar dalam modal
              $('#imageModal').find('.modal-body img').attr('src', imageUrl);
              $('#imageModal').modal('show');
          });
    
          // Fungsi untuk menangani tombol delete dengan konfirmasi
          $('.delete-btn').click(function() {
              var imageId = $(this).data('image-id');
              // Tampilkan konfirmasi penghapusan
              if (confirm("Apakah Anda yakin ingin menghapus gambar ini?")) {
                  // Lakukan penghapusan gambar dengan AJAX request
                  $.ajax({
                      url: '/delete-image/' + imageId,
                      method: 'DELETE',
                      success: function(response) {
                          // Refresh halaman atau hapus gambar dari tampilan
                          location.reload(); // Contoh: refresh halaman setelah penghapusan
                      },
                      error: function(xhr, status, error) {
                          console.error(xhr.responseText);
                          // Tampilkan pesan kesalahan jika diperlukan
                      }
                  });
              }
          });
      });
    </script> 

