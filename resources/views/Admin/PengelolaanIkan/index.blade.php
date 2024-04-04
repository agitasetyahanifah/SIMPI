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

{{-- Tambah Jenis Ikan --}}
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="font-weight-bolder mb-0">Jenis Ikan</h4>
            {{-- Button Tambah --}}
            <form action="/admin/pengelolaanIkan/tambahIkan" method="post">
                @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
                </div>
          </div>

          {{-- Modal Tambah Jenis Ikan --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Ikan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis_ikan" class="col-form-label">Jenis Ikan</label>
                            <input type="text" class="form-control" id="jenis_ikan" name="jenis_ikan" required>
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
                        <th>Jenis Ikan</th>
                        <th style="width: 10%;" class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        @php
                            $currentNumber = $lastItem3 - $jenisIkan->count() + 1;
                        @endphp
                        @foreach ($jenisIkan as $key => $jenis_ikan)
                        <tr>
                            <td style="width: 5%;" class="text-center">{{ $currentNumber++ }}</td>
                            <td>{{ $jenis_ikan->jenis_ikan }}</td>
                            <td class="text-center" style="width: 10]%;">
                                <button class="btn btn-danger delete3" data-ikanid="{{ $jenis_ikan->id }}"><i class="fas fa-trash"></i></button>                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>                
            </div>
            
            {{-- Cek ada data atau kosong --}}
            @if($jenisIkan->isEmpty())
                <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
            @endif 

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal3" tabindex="-1" aria-labelledby="deleteModalLabel3" aria-hidden="true">
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
                            <form id="deleteForm3" action="/admin/pengelolaanIkan/hapusIkan/{id}/delete" method="post">
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
                    <li class="page-item {{ $jenisIkan->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $jenisIkan->previousPageUrl() ?? '#' }}" tabindex="-1">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!-- Tampilkan nomor halaman -->
                    @for ($i = 1; $i <= $jenisIkan->lastPage(); $i++)
                        <li class="page-item {{ $jenisIkan->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $jenisIkan->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $jenisIkan->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $jenisIkan->nextPageUrl() ?? '#' }}">
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

{{-- Manajemen Pengelolaan Ikan --}}
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
                  {{-- Tab Pengelolaan Ikan Masuk --}}
                  <div class="tab-pane fade show active" id="profile-tabs-simple" role="tabpanel" aria-labelledby="profile-tabs-simple">
                      <h5>Pengelolaan Ikan Masuk</h5>
                      {{-- Button Tambah --}}
                      <form action="{{ route('admin.pengelolaan_ikan.ikan_keluar.store') }}" method="post">
                        @csrf
                        <div class="col-12 text-end">
                          <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                        </div>
                      <!-- Modal Tambah Data Ikan Masuk -->
                      <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Ikan Masuk</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="tanggal_ikan_masuk" class="col-form-label">Tanggal Ikan Masuk</label>
                                            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="jenis_ikan" class="col-form-label">Jenis Ikan</label>
                                          <select class="form-select" id="jenis_ikan" name="jenis_ikan" required>
                                              <option value="Ikan Lele">Ikan Lele</option>
                                              <option value="Ikan Mas">Ikan Mas</option>
                                              <option value="Ikan Nila">Ikan Nila</option>
                                              <option value="Ikan Gurame">Ikan Gurame</option>
                                              <option value="Ikan Patin">Ikan Patin</option>
                                              <option value="Ikan Gabus">Ikan Gabus</option>
                                              <option value="Ikan Bawal">Ikan Bawal</option>
                                              <option value="Ikan Kakap">Ikan Kakap</option>
                                              <option value="Ikan Bandeng">Ikan Bandeng</option>
                                              <option value="Ikan Kerapu">Ikan Kerapu</option>
                                          </select>
                                      </div>                                      
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan" class="col-form-label">Catatan</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
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
                                <th>Tanggal Ikan Masuk</th>
                                <th>Jenis Ikan</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentNumber = $lastItem1 - $ikanMasuk->count() + 1;
                                @endphp
                                @foreach ($ikanMasuk as $key => $ikan_masuk)
                                <tr>
                                    <td class="text-center">{{ $currentNumber++ }}</td>
                                    <td>{{ $ikan_masuk->tanggal }}</td>
                                    <td>{{ $ikan_masuk->jenis_ikan }}</td>
                                    <td>{{ number_format($ikan_masuk->jumlah, 0, ',', '.') }}</td>
                                    <td class="keterangan-column">{{ $ikan_masuk->catatan }}</td>
                                    <td class="text-align-end">
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $ikan_masuk->id }}"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger delete1" data-bs-toggle="modal" data-bs-target="#deleteModal1" data-ikanmasukid="{{ $ikan_masuk->id }}"><i class="fas fa-trash"></i></button>                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        
                        {{-- Cek ada data atau kosong --}}
                        @if($ikanMasuk->isEmpty())
                            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
                        @endif 
            
                        <!-- Modal Edit Data Ikan Masuk -->
                        @foreach ($ikanMasuk as $ikan_masuk)
                        <div class="modal fade" id="editModal{{ $ikan_masuk->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ikan_masuk->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $ikan_masuk->id }}">Edit Data Ikan Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.pengelolaan_ikan.ikan_masuk.update', $ikan_masuk->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="edit_tanggal_transaksi">Tanggal Ikan Masuk</label>
                                                <input type="date" class="form-control" id="edit_tanggal_transaksi" name="edit_tanggal_transaksi" value="{{ $ikan_masuk->tanggal }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_jenis_ikan">Jenis Ikan</label>
                                                <select class="form-select" id="edit_jenis_ikan" name="edit_jenis_ikan" required>
                                                    <option value="Ikan Lele" {{ $ikan_masuk->jenis_ikan == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele</option>
                                                    <option value="Ikan Mas" {{ $ikan_masuk->jenis_ikan == 'Ikan Mas' ? 'selected' : '' }}>Ikan Mas</option>
                                                    <option value="Ikan Nila" {{ $ikan_masuk->jenis_ikan == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
                                                    <option value="Ikan Gurame" {{ $ikan_masuk->jenis_ikan == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame</option>
                                                    <option value="Ikan Patin" {{ $ikan_masuk->jenis_ikan == 'Ikan Patin' ? 'selected' : '' }}>Ikan Patin</option>
                                                    <option value="Ikan Gabus" {{ $ikan_masuk->jenis_ikan == 'Ikan Gabus' ? 'selected' : '' }}>Ikan Gabus</option>
                                                    <option value="Ikan Bawal" {{ $ikan_masuk->jenis_ikan == 'Ikan Bawal' ? 'selected' : '' }}>Ikan Bawal</option>
                                                    <option value="Ikan Kakap" {{ $ikan_masuk->jenis_ikan == 'Ikan Kakap' ? 'selected' : '' }}>Ikan Kakap</option>
                                                    <option value="Ikan Bandeng" {{ $ikan_masuk->jenis_ikan == 'Ikan Bandeng' ? 'selected' : '' }}>Ikan Bandeng</option>
                                                    <option value="Ikan Kerapu" {{ $ikan_masuk->jenis_ikan == 'Ikan Kerapu' ? 'selected' : '' }}>Ikan Kerapu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_jumlah">Jumlah</label>
                                                <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" value="{{ $ikan_masuk->jumlah }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_catatan">Catatan</label>
                                                <textarea class="form-control" id="edit_catatan" name="edit_catatan" rows="3">{{ $ikan_masuk->catatan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteModal1" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deleteForm1" action="/admin/pengelolaanIkan/ikan-masuk/{id}/delete" method="post">
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
                                <li class="page-item {{ $ikanMasuk->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $ikanMasuk->previousPageUrl() ?? '#' }}" tabindex="-1">
                                        <i class="fa fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <!-- Tampilkan nomor halaman -->
                                @for ($i = 1; $i <= $ikanMasuk->lastPage(); $i++)
                                    <li class="page-item {{ $ikanMasuk->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $ikanMasuk->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $ikanMasuk->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $ikanMasuk->nextPageUrl() ?? '#' }}">
                                        <i class="fa fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- End Pagination -->
                      </div>
                  </div>

                  {{-- Tab Pengelolaan Ikan Keluar --}}
                  <div class="tab-pane fade" id="dashboard-tabs-simple" role="tabpanel" aria-labelledby="dashboard-tabs-simple">
                      <h5>Pengelolaan Ikan Keluar</h5>
                      {{-- Button Tambah --}}
                      <form action="{{ route('admin.pengelolaan_ikan.ikan_keluar.store') }}" method="post">
                        @csrf
                        <div class="col-12 text-end">
                          <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage2">Tambah</button>
                        </div>
                      <!-- Modal Tambah Data Ikan Keluar -->
                      <div class="modal fade" id="exampleModalMessage2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Ikan Keluar</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="tanggal_ikan_keluar" class="col-form-label">Tanggal Ikan Keluar</label>
                                            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="jenis_ikan" class="col-form-label">Jenis Ikan</label>
                                          <select class="form-select" id="jenis_ikan" name="jenis_ikan" required>
                                              <option value="Ikan Lele">Ikan Lele</option>
                                              <option value="Ikan Mas">Ikan Mas</option>
                                              <option value="Ikan Nila">Ikan Nila</option>
                                              <option value="Ikan Gurame">Ikan Gurame</option>
                                              <option value="Ikan Patin">Ikan Patin</option>
                                              <option value="Ikan Gabus">Ikan Gabus</option>
                                              <option value="Ikan Bawal">Ikan Bawal</option>
                                              <option value="Ikan Kakap">Ikan Kakap</option>
                                              <option value="Ikan Bandeng">Ikan Bandeng</option>
                                              <option value="Ikan Kerapu">Ikan Kerapu</option>
                                          </select>
                                      </div>                                      
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="kondisi_ikan" class="col-form-label">Kondisi Ikan</label>
                                          <select class="form-select" id="kondisi_ikan" name="kondisi_ikan" required>
                                              <option value="Baik">Baik</option>
                                              <option value="Sakit">Sakit</option>
                                              <option value="Mati">Mati</option>
                                          </select>
                                      </div> 
                                        <div class="form-group">
                                            <label for="catatan" class="col-form-label">Catatan</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
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
                                <th>Tanggal Ikan Keluar</th>
                                <th>Jenis Ikan</th>
                                <th>Jumlah</th>
                                <th>Kondisi Ikan</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                  $currentNumber = $lastItem2 - $ikanKeluar->count() + 1;
                              @endphp
                              @foreach ($ikanKeluar as $key => $ikan_keluar)
                              <tr>
                                  <td class="text-center">{{ $currentNumber++ }}</td>
                                  <td>{{ $ikan_keluar->tanggal }}</td>
                                  <td>{{ $ikan_keluar->jenis_ikan }}</td>
                                  <td>{{ $ikan_keluar->kondisi_ikan }}</td>
                                  <td>{{ number_format($ikan_keluar->jumlah, 0, ',', '.') }}</td>
                                  <td class="keterangan-column">{{ $ikan_keluar->catatan }}</td>
                                  <td class="text-align-end">
                                      <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal2{{ $ikan_keluar->id }}"><i class="fas fa-edit"></i></a>
                                      <button class="btn btn-danger delete2" data-bs-toggle="modal" data-bs-target="#deleteModal2" data-ikankeluarid="{{ $ikan_keluar->id }}"><i class="fas fa-trash"></i></button>                            
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                          </table>
                        </div>
                        
                        {{-- Cek ada data atau kosong --}}
                        @if($ikanKeluar->isEmpty())
                            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
                        @endif 
            
                        <!-- Modal Edit Data Ikan Keluar -->
                        @foreach ($ikanKeluar as $ikan_keluar)
                        <div class="modal fade" id="editModal2{{ $ikan_keluar->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ikan_keluar->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $ikan_keluar->id }}">Edit Data Ikan Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.pengelolaan_ikan.ikan_keluar.update', $ikan_keluar->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="edit_tanggal_transaksi">Tanggal Ikan Masuk</label>
                                                <input type="date" class="form-control" id="edit_tanggal_transaksi" name="edit_tanggal_transaksi" value="{{ $ikan_keluar->tanggal }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_jenis_ikan">Jenis Ikan</label>
                                                <select class="form-select" id="edit_jenis_ikan" name="edit_jenis_ikan" required>
                                                    <option value="Ikan Lele" {{ $ikan_keluar->jenis_ikan == 'Ikan Lele' ? 'selected' : '' }}>Ikan Lele</option>
                                                    <option value="Ikan Mas" {{ $ikan_keluar->jenis_ikan == 'Ikan Mas' ? 'selected' : '' }}>Ikan Mas</option>
                                                    <option value="Ikan Nila" {{ $ikan_keluar->jenis_ikan == 'Ikan Nila' ? 'selected' : '' }}>Ikan Nila</option>
                                                    <option value="Ikan Gurame" {{ $ikan_keluar->jenis_ikan == 'Ikan Gurame' ? 'selected' : '' }}>Ikan Gurame</option>
                                                    <option value="Ikan Patin" {{ $ikan_keluar->jenis_ikan == 'Ikan Patin' ? 'selected' : '' }}>Ikan Patin</option>
                                                    <option value="Ikan Gabus" {{ $ikan_keluar->jenis_ikan == 'Ikan Gabus' ? 'selected' : '' }}>Ikan Gabus</option>
                                                    <option value="Ikan Bawal" {{ $ikan_keluar->jenis_ikan == 'Ikan Bawal' ? 'selected' : '' }}>Ikan Bawal</option>
                                                    <option value="Ikan Kakap" {{ $ikan_keluar->jenis_ikan == 'Ikan Kakap' ? 'selected' : '' }}>Ikan Kakap</option>
                                                    <option value="Ikan Bandeng" {{ $ikan_keluar->jenis_ikan == 'Ikan Bandeng' ? 'selected' : '' }}>Ikan Bandeng</option>
                                                    <option value="Ikan Kerapu" {{ $ikan_keluar->jenis_ikan == 'Ikan Kerapu' ? 'selected' : '' }}>Ikan Kerapu</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_jumlah">Jumlah</label>
                                                <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" value="{{ $ikan_keluar->jumlah }}" required>
                                            </div>
                                            <div class="form-group">
                                              <label for="edit_kondisi_ikan">Kondisi Ikan</label>
                                              <select class="form-select" id="edit_kondisi_ikan" name="edit_kondisi_ikan" required>
                                                  <option value="Baik" {{ $ikan_keluar->kondisi_ikan == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                  <option value="Sakit" {{ $ikan_keluar->kondisi_ikan == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                                  <option value="Mati" {{ $ikan_keluar->kondisi_ikan == 'Mati' ? 'selected' : '' }}>Mati</option>
                                              </select>
                                          </div>                                           
                                            <div class="form-group">
                                                <label for="edit_catatan">Catatan</label>
                                                <textarea class="form-control" id="edit_catatan" name="edit_catatan" rows="3">{{ $ikan_keluar->catatan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteModal2" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deleteForm2" action="/admin/pengelolaanIkan/ikan-keluar/{id}/delete" method="post">
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
                                <li class="page-item {{ $ikanKeluar->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $ikanKeluar->previousPageUrl() ?? '#' }}" tabindex="-1">
                                        <i class="fa fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <!-- Tampilkan nomor halaman -->
                                @for ($i = 1; $i <= $ikanKeluar->lastPage(); $i++)
                                    <li class="page-item {{ $ikanKeluar->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $ikanKeluar->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $ikanKeluar->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $ikanKeluar->nextPageUrl() ?? '#' }}">
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
        </div>  
      </div>
    </div>
</div>

<!-- Javascript Button Delete -->
<script>
  $(document).ready(function() {
      // Menangani button delete untuk ikan masuk
      $(document).on('click', '.delete1', function() {
          const ikanmasukid = $(this).data('ikanmasukid'); 
          $('#deleteModal1').modal('show');

          // Mengubah action form berdasarkan ID transaksi yang dipilih
          const deleteUrl = `/admin/pengelolaanIkan/ikan-masuk/${ikanmasukid}/delete`;
          $('#deleteForm1').attr('action', deleteUrl);
      });

      // Menangani button delete untuk ikan keluar
      $(document).on('click', '.delete2', function() {
          const ikankeluarid = $(this).data('ikankeluarid'); 
          $('#deleteModal2').modal('show');

          // Mengubah action form berdasarkan ID transaksi yang dipilih
          const deleteUrl = `/admin/pengelolaanIkan/ikan-keluar/${ikankeluarid}/delete`;
          $('#deleteForm2').attr('action', deleteUrl);
      });

      // Menangani button delete untuk jenis ikan
      $(document).on('click', '.delete3', function() {
          const ikanid = $(this).data('ikanid'); 
          $('#deleteModal3').modal('show');

          // Mengubah action form berdasarkan ID transaksi yang dipilih
          const deleteUrl = `/admin/pengelolaanIkan/hapusIkan/${ikanid}/delete`;
          $('#deleteForm3').attr('action', deleteUrl);
      });
  });
</script>

@endsection
