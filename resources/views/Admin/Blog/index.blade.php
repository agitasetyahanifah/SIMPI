@extends('Admin.Layouts.main')

@section('title', 'Blog')

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

{{-- Tambah Kategori Blog --}}
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="font-weight-bolder mb-0">Kategori Blog</h4>
            {{-- Button Tambah --}}
            <form action="/admin/blog/tambahKategori" method="post">
                @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
                </div>
          </div>

          {{-- Modal Tambah Kategori Blog --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Blog</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori_blog" class="col-form-label">Kategori Blog</label>
                            <input type="text" class="form-control" id="kategori_blog" name="kategori_blog" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                    </div>
                </div>
                </div>
            </div>
            </form>

          <div class="card-body ">
            <div class="table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th>Kategori Blog</th>
                        <th style="width: 10%;" class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        @php
                            $currentNumber = $lastItem2 - $kategoriBlog->count() + 1;
                        @endphp
                        @foreach ($kategoriBlog as $key => $kategori)
                        <tr>
                            <td style="width: 5%;" class="text-center">{{ $currentNumber++ }}</td>
                            <td>{{ $kategori->kategori_blog }}</td>
                            <td class="text-center" style="width: 10]%;">
                                <button class="btn btn-danger delete2" data-kategoriid="{{ $kategori->id }}"><i class="fas fa-trash"></i></button>                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>                
            </div>
            
            {{-- Cek ada data atau kosong --}}
            @if($kategoriBlog->isEmpty())
                <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
            @endif 

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal2" tabindex="-1" aria-labelledby="deleteModalLabel2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus transaksi ini?
                        </div>
                        <div class="modal-footer">
                            <form id="deleteForm2" action="/admin/blog/hapusKategori/{id}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
                            </form>
                        </div>                                    
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="p-3" aria-label="Pagination">
                <ul class="pagination">
                    <li class="page-item {{ $kategoriBlog->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $kategoriBlog->previousPageUrl() ?? '#' }}" tabindex="-1">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!-- Tampilkan nomor halaman -->
                    @for ($i = 1; $i <= $kategoriBlog->lastPage(); $i++)
                        <li class="page-item {{ $kategoriBlog->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $kategoriBlog->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $kategoriBlog->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $kategoriBlog->nextPageUrl() ?? '#' }}">
                            <i class="fa fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Pagination -->
          </div>

        </div>
      </div>
    </div>
</div>

{{-- Manajemen Blog --}}
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="font-weight-bolder mb-0">Blog/Artikel Pemancingan</h4>
            {{-- Button Tambah --}}
            <form action="/admin/blog" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                </div>
          </div>
          
          <!-- Modal Tambah Blog -->
          <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Blog/Artikel Pemancingan</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul" class="col-form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="col-form-label">slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_blog" class="col-form-label">Kategori</label>
                        <select class="form-select" id="kategori_blog" name="kategori_blog" required>
                            @foreach($kategoriOpt->sortBy('kategori_blog') as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->kategori_blog }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image" required accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="body" class="col-form-label">Body</label>
                        <input type="hidden" class="form-control" id="body" name="body" required>
                        <trix-editor input="body"></trix-editor>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Tambah</button>
                </div>
            </form>
            </div>
            </div>
          </div>

          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $currentNumber = $lastItem - $blogs->count() + 1;
                    @endphp
                    @foreach ($blogs as $key => $blog)
                    <tr>
                        <td class="text-center">{{ $currentNumber++ }}</td>
                        <td>{{ $blog->judul }}</td>
                        <td>{{ $blog->kategoriBlog->kategori_blog }}</td>
                        <td class="text-align-end">
                            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $blog->id }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger delete" data-blogid="{{ $blog->id }}"><i class="fas fa-trash"></i></button>                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            
            {{-- Cek ada data atau kosong --}}
            @if($blogs->isEmpty())
                <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
            @endif 

            <!-- Modal Edit Blog -->
            @foreach ($blogs as $blog)
            <div class="modal fade" id="editModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $blog->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalTitle">Edit Blog/Artikel Pemancingan</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/blog/{{ $blog->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="edit_judul" class="col-form-label">Judul</label>
                                    <input type="text" class="form-control" id="edit_judul" name="judul" value="{{ $blog->judul }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_slug" class="col-form-label">Slug</label>
                                    <input type="text" class="form-control" id="edit_slug" name="slug" value="{{ $blog->slug }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_kategori_blog" class="col-form-label">Kategori</label>
                                    <select class="form-select" id="edit_kategori_blog" name="kategori_blog" required>
                                        @foreach($kategoriOpt->sortBy('kategori_blog') as $kategori)
                                            <option value="{{ $kategori->id }}" @if($kategori->id == $blog->kategori_id) selected @endif>{{ $kategori->kategori_blog }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_image" class="col-form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label for="edit_body" class="col-form-label">Body</label>
                                    <input type="hidden" id="edit_body" name="body" value="{{ $blog->body }}">
                                    <trix-editor input="edit_body"></trix-editor>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>            
            @endforeach   
            
            {{-- Modal Detail Blog --}}
            @foreach ($blogs as $blog)
              <div class="modal fade" id="detailModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $blog->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Detail Blog/Artikel Pemancingan</h5>
                      <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>                    
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <h3>{{ $blog->judul }}</h3>
                                <a style="color: black"><b>Slug:</b> {{ $blog->slug }}    |<b>   Kategori:</b> {{ $blog->kategoriBlog->kategori_blog }}</a>
                                <img src="{{ asset('images/'.$blog->image) }}" alt="" class="img-fluid p-3">
                                {!! $blog->body !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus transaksi ini?
                        </div>
                        <div class="modal-footer">
                            <form id="deleteForm" action="/admin/keuangan/{id}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
                            </form>
                        </div>                                    
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="p-3" aria-label="Pagination">
                <ul class="pagination">
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
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Javascript Button Delete -->
<script>
    $(document).ready(function() {
        // Menangani button delete
        $(document).on('click', '.delete', function() {
            const blogId = $(this).data('blogid');
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID blog yang dipilih
            $('#deleteForm').attr('action', '/admin/blog/' + blogId);
        });

        // Menangani button delete kategori
        $(document).on('click', '.delete2', function() {
            const kategoriid = $(this).data('kategoriid');
            $('#deleteModal2').modal('show');

            // Make sure the URL is correctly formed with the category ID
            $('#deleteForm2').attr('action', '/admin/blog/hapusKategori/' + kategoriid); // Use correct URL format
        });

    });

</script>


<!-- Javascript untuk Mengisi Slug Otomatis -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const judul = document.querySelector('#judul');
        const slug = document.querySelector('#slug');

        judul.addEventListener('input', function() {
            const judulValue = judul.value.trim(); // Menghapus spasi di awal dan akhir judul
            const slugValue = slugify(judulValue); // Mengubah judul menjadi slug

            slug.value = slugValue; // Mengisi nilai slug input dengan slug yang dihasilkan
        });

        // Fungsi untuk mengubah teks menjadi slug
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Ganti spasi dengan -
                .replace(/[^\w\-]+/g, '')       // Hapus karakter selain huruf, angka, dan -
                .replace(/\-\-+/g, '-')         // Ganti beberapa - berurutan dengan satu -
                .replace(/^-+/, '')             // Hapus - di awal teks
                .replace(/-+$/, '');            // Hapus - di akhir teks
        }
    });
</script>

@endsection


