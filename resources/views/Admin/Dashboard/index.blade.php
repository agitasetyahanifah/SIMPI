@extends('Admin.Layouts.main')

@section('title', 'Manajemen Keuangan')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>
</div>

{{-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}

{{-- Update jumlah pengunjung --}}
<form method="post" action="/admin/dashboard/updatePengunjung">
  @csrf
  <h6 class="update-title">Update Jumlah Pengunjung</h6>
  <div class="input-group mb-3">
    <span class="input-group-text custom-box">{{ $visitors->jumlah }}</span>
    <input name="visitors" id="visitors" type="number" class="form-control" placeholder="Update Jumlah Pengunjung">
    <button class="btn btn-primary" type="submit">Update</button>
  </div>
</form>
    
@endsection