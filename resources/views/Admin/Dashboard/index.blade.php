@extends('Admin.Layouts.main')

@section('title', 'Dashboard')

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
    {{-- Update Jumlah Pengunjung --}}
    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-4 mb-2">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Pengunjung Pemancingan</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ isset($visitors) ? $visitors->jumlah : 0 }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="numbers">
                                {{-- Update jumlah pengunjung --}}
                                <form method="post" action="/admin/dashboard/updatePengunjung">
                                    @csrf
                                    <div class="input-group p-1 col-8">
                                        <input name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Update Jumlah Pengunjung">
                                        <button class="btn btn-outline-primary mb-0" type="submit">Button</button>
                                    </div>
                                    @if(isset($visitors) && $visitors->updated_at)
                                    <div class="p-0">
                                        <a style="color: grey; font-size: 14px; margin-right: 4px" class="p-1">Tanggal terakhir kali diperbarui: {{ $visitors->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</a>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Galeri --}}
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex flex-column h-100">
                                <h5 class="font-weight-bolder">Galeri Pemancingan</h5>
                                <div class="col-12 text-end p-1">
                                  <button class="btn-transparent">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                      <i class="ni ni-fat-add text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                  </button>
                                </div>                                
                                @if($images->isEmpty())
                                    <h6 class="text-muted text-center">Belum ada gambar yang ditambahkan</h6>
                                @endif
                                {{-- <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                    Read More
                                    <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                </a> --}}
                                <div class="d-flex justify-content-center">
                                  {{ $images->links() }}
                              </div>                              
                            </div>
                        </div>
                        {{-- card gambar --}}
                        @foreach($images as $image)
                            <div class="col-lg-2 ms-auto text-center mt-5 mt-lg-0">
                                <div class="bg-gradient-primary border-radius-lg h-100">
                                    <div class="position-relative d-flex align-items-center justify-content-center h-100">
                                        @if($image->filename)
                                            <img class="w-100 position-relative z-index-2 pt-4" src="{{ asset('images/' . $image->filename) }}" alt="{{ asset('images/' . $image->filename) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach                      
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
