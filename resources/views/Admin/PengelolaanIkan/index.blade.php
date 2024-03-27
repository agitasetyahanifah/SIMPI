@extends('Admin.Layouts.main')

@section('title', 'Pengelolaan Ikan')

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
            <h4 class="font-weight-bolder mb-3">Manajemen Pengelolaan Ikan</h4>

            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                   <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-simple" role="tab" aria-controls="profile" aria-selected="true">
                      Pengelolaan Ikan Masuk
                      </a>
                   </li>
                   <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard" aria-selected="false">
                      Pengelolaan Ikan Keluar
                      </a>
                   </li>
                 </ul>

                 <div class="tab-content mt-3">
                  <div class="tab-pane fade show active" id="profile-tabs-simple" role="tabpanel" aria-labelledby="profile-tabs-simple">
                      <h5>Pengelolaan Ikan Masuk</h5>
                      {{-- Button Tambah --}}
                      <form action="#" method="post">
                        @csrf
                        <div class="col-12 text-end">
                          <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                        </div>
                      <div class="card-body ">
                        <div class="table-responsive p-0">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal Ikan Masuk</th>
                                <th>Jenis Ikan</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            {{-- <tbody>
                                @php
                                    $currentNumber = $lastItem - $keuangans->count() + 1;
                                @endphp
                                @foreach ($keuangans as $key => $keuangan)
                                <tr>
                                    <td class="text-center">{{ $currentNumber++ }}</td>
                                    <td>{{ $keuangan->tanggal_transaksi }}</td>
                                    <td>{{ number_format($keuangan->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $keuangan->jenis_transaksi }}</td>
                                    <td class="keterangan-column">{{ $keuangan->keterangan }}</td>
                                    <td class="text-align-end">
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $keuangan->id }}"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger delete" data-transaksiid="{{ $keuangan->id }}"><i class="fas fa-trash"></i></button>                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                          </table>
                        </div>
                        
                        {{-- Cek ada data atau kosong --}}
                        {{-- @if($keuangans->isEmpty())
                            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
                        @endif  --}}
            
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

                  <div class="tab-pane fade" id="dashboard-tabs-simple" role="tabpanel" aria-labelledby="dashboard-tabs-simple">
                      <h5>Pengelolaan Ikan Keluar</h5>
                      {{-- Button Tambah --}}
                      <form action="#" method="post">
                        @csrf
                        <div class="col-12 text-end">
                          <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                        </div>
                      <div class="card-body ">
                        <div class="table-responsive p-0">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal Ikan Keluar</th>
                                <th>Jenis Ikan</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            {{-- <tbody>
                                @php
                                    $currentNumber = $lastItem - $keuangans->count() + 1;
                                @endphp
                                @foreach ($keuangans as $key => $keuangan)
                                <tr>
                                    <td class="text-center">{{ $currentNumber++ }}</td>
                                    <td>{{ $keuangan->tanggal_transaksi }}</td>
                                    <td>{{ number_format($keuangan->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $keuangan->jenis_transaksi }}</td>
                                    <td class="keterangan-column">{{ $keuangan->keterangan }}</td>
                                    <td class="text-align-end">
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $keuangan->id }}"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger delete" data-transaksiid="{{ $keuangan->id }}"><i class="fas fa-trash"></i></button>                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody> --}}
                          </table>
                        </div>
                        
                        {{-- Cek ada data atau kosong --}}
                        {{-- @if($keuangans->isEmpty())
                            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
                        @endif  --}}
            
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
      </div>
    </div>
</div>

@endsection
