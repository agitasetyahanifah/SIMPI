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

<div class="container">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Data Ikan Masuk</button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Data Ikan Keluar</button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
            Content for Data Ikan Masuk
        </div>
        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
            Content for Data Ikan Keluar
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

@endsection
