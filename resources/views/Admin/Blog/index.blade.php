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
          <!-- Modal Tambah Transaksi -->
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
                        <label for="kategori" class="col-form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Pemancingan">Pemancingan</option>
                            <option value="Tips & Trik">Tips & Trik</option>
                            <option value="Jenis-Jenis Ikan">Jenis-Jenis Ikan</option>
                            <option value="Alat Pancing">Alat Pancing</option>
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
                        <td>{{ $blog->kategori }}</td>
                        <td class="text-align-end">
                            <a class="btn btn-info"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger delete" data-transaksiid="{{ $blog->id }}"><i class="fas fa-trash"></i></button>                            
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

            <!-- Modal Edit Transaksi -->
            {{-- @foreach ($keuangans as $keuangan)
            <div class="modal fade" id="editModal{{ $keuangan->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $keuangan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $keuangan->id }}">Edit Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/keuangan/update/{{ $keuangan->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_tanggal_transaksi">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="edit_tanggal_transaksi" name="edit_tanggal_transaksi" value="{{ $keuangan->tanggal_transaksi }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" value="{{ $keuangan->jumlah }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_jenis_transaksi">Jenis Transaksi</label>
                                    <select class="form-select" id="edit_jenis_transaksi" name="edit_jenis_transaksi" required>
                                        <option value="pemasukan" {{ $keuangan->jenis_transaksi == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                        <option value="pengeluaran" {{ $keuangan->jenis_transaksi == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_keterangan">Keterangan</label>
                                    <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" rows="3">{{ $keuangan->keterangan }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach         --}}

            <!-- Modal Delete -->
            {{-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
            </div> --}}

            <!-- Pagination -->
            {{-- <nav class="p-3" aria-label="Pagination">
                <ul class="pagination">
                    <li class="page-item {{ $keuangans->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $keuangans->previousPageUrl() ?? '#' }}" tabindex="-1">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!-- Tampilkan nomor halaman -->
                    @for ($i = 1; $i <= $keuangans->lastPage(); $i++)
                        <li class="page-item {{ $keuangans->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $keuangans->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $keuangans->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $keuangans->nextPageUrl() ?? '#' }}">
                            <i class="fa fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav> --}}
            <!-- End Pagination -->
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<!-- Javascript Button Delete -->
{{-- <script>
    $(document).ready(function() {
        // Menangani button delete
        $(document).on('click', '.delete', function() {
            const transaksiId = $(this).data('transaksiid'); // Perhatikan penggunaan snake_case di sini
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID transaksi yang dipilih
            $('#deleteForm').attr('action', '/admin/keuangan/' + transaksiId);
        });
    });
</script> --}}

@endsection


