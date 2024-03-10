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
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h5 class="font-weight-bolder mb-0">Daftar Alat Pancing</h5>
            <div class="col-12 text-end">
                <button class="btn btn-outline-primary mb-" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
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
                            <img src="{{ $alat->foto }}" class="avatar avatar-xl me-3" alt="Alat Pancing">
                            {{-- <img src="https://source.unsplash.com/featured/?fish" class="avatar avatar-xl me-3" alt=""> --}}
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

@endsection

