@extends('Admin.Layouts.main')

@section('title', 'Keuangan')

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
            <h5 class="font-weight-bolder mb-0">Manajemen Keuangan</h5>
            {{-- Button Tambah --}}
            <form action="/admin/keuangan/store" method="POST">
            @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                </div>
          </div>
          <!-- Modal Tambah Transaksi -->
          <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_transaksi" class="col-form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_transaksi" class="col-form-label">Jenis Transaksi</label>
                        <select class="form-select" id="jenis_transaksi" name="jenis_transaksi" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Tambah</button>
                </div>
            </div>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah</th>
                    <th>Jenis Transaksi</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $currentNumber = $lastItem - $keuangans->count() + 1;
                    @endphp
                    @foreach ($keuangans as $key => $keuangan)
                    <tr>
                        <td>{{ $currentNumber++ }}</td>
                        <td>{{ $keuangan->tanggal_transaksi }}</td>
                        <td>{{ number_format($keuangan->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $keuangan->jenis_transaksi }}</td>
                        <td>{{ $keuangan->keterangan }}</td>
                        <td class="text-align-end">
                            {{-- <a href="{{ route('keuangan.edit', $keuangan->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Update
                            </a>
                            <form action="{{ route('keuangan.destroy', $keuangan->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form> --}}
                            <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Update</a>
                            <button class="btn btn-sm btn-danger delete" data-id="{{ $keuangan->id }}"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
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
            </nav>
            <!-- End Pagination -->
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

{{-- Javascript Button Delete --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                const action = `/admin/keuangan/${id}`;
                deleteForm.setAttribute('action', action);

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });
    });
</script>

@endsection

