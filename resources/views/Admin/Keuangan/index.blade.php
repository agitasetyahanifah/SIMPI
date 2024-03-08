@extends('Admin.Layouts.main')

@section('title', 'Keuangan')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h5 class="font-weight-bolder mb-0">Manajemen Keuangan</h5>
            <form action="/admin/dashboard/uploadGambar" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
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
                    @foreach ($keuangans as $key => $keuangan)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $keuangan->tanggal_transaksi }}</td>
                      <td>{{ $keuangan->jumlah }}</td>
                      <td>{{ $keuangan->jenis_transaksi }}</td>
                      <td>{{ $keuangan->keterangan }}</td>
                      <td></td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
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

@endsection