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

    <h1>Daftar Ikan</h1>
    <a href="{{ route('ikans.create') }}" class="btn btn-success mb-3">Tambah Ikan</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Jenis</th>
                <th scope="col">Berat</th>
                <th scope="col">Tanggal Masuk</th>
                <th scope="col">Tanggal Tangkap</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ikans as $ikan)
                <tr>
                    <th scope="row">{{ $ikan->id }}</th>
                    <td>{{ $ikan->nama }}</td>
                    <td>{{ $ikan->jenis }}</td>
                    <td>{{ $ikan->berat }}</td>
                    <td>{{ $ikan->tanggal_masuk }}</td>
                    <td>{{ $ikan->tanggal_tangkap }}</td>
                    <td>
                        <a href="{{ route('ikans.edit', $ikan->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('ikans.destroy', $ikan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
