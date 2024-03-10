@extends('Admin.Layouts.main')

@section('title', 'Daftar Alat Pancing')

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
        <div class="card mb-0">
          <div class="card-header pb-0">
            <h5 class="font-weight-bolder mb-0">Daftar Alat Pancing</h5>
            {{-- Button Tambah Alat Pancing --}}
            <form action="/admin/alatPancing" method="post" enctype="multipart/form-data">
              @csrf
              <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-1" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
              </div>
          </div>
          {{-- Modal Tambah Alat Pancing --}}
          <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Alat Pancing</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/admin/alatPancing" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="form-group">
                                <label for="foto" class="col-form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" required accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="nama_alat" class="col-form-label">Nama Alat</label>
                                <input type="text" class="form-control" id="nama_alat" name="nama_alat" required>
                            </div>
                            <div class="form-group">
                                <label for="harga" class="col-form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah" class="col-form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="available">Available</option>
                                    <option value="not available">Not Available</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="spesifikasi" class="col-form-label">Spesifikasi</label>
                                <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="3"></textarea>
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
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alat Pancing</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if($alatPancing->count() > 0)
                    @foreach($alatPancing as $key => $alat)
                    <tr>
                      <td>
                        <p class="text-sm font-weight-bold mb-0 ps-4">{{ $key + 1 }}</p>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ asset('images/' . $alat->foto) }}" class="avatar avatar-xl me-3" alt="Alat Pancing">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $alat->nama_alat }}</h6>
                            <p class="text-xl text-secondary mb-0">{{ number_format($alat->harga, 0, ',', '.') }} /hari</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $alat->jumlah }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span>
                      </td>
                      <td class="align-middle text-center">
                          <button class="btn btn-success"><i class="fas fa-eye"></i></button>
                          <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="4" class="text-center">Tidak ada data tersedia.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

