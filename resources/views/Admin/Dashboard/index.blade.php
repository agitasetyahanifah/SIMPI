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
  <div class="input-group mb-4">
    <span class="input-group-text custom-box">{{ $visitors->jumlah }}</span>
    <input name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Update Jumlah Pengunjung">
    <button class="btn btn-primary" type="submit">Update</button>
  </div>
</form>
<hr>

{{-- Menu Galeri --}}
<form method="" action="#">
  @csrf
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="update-title">Galeri Pemancingan</h6>
            <button class="btn btn-success p-1 mb-3" ><span data-feather="plus-circle"></span> Tambah</button>
        </div>
      </div>    
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
                <div class="col-md-2 mb-2 position-relative">
                  <div class="card">
                      <img src="https://source.unsplash.com/300x200/?fishing" class="card-img-top" alt="...">
                      <div class="position-absolute top-0 end-0">
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Expand" data-feather="maximize"></button>
                          <button class="btn btn-light btn-sm p-0" type="button" data-toggle="tooltip" title="Delete" data-feather="trash"></button>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" role="button" data-slide="next">
            <span class="sr-only">Next</span>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</form>
    
@endsection