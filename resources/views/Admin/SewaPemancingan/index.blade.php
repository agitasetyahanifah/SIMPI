@extends('Admin.Layouts.main')

@section('title', 'Sewa Pemancingan')

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
            <h4 class="font-weight-bolder mb-0">Manajemen Penyewaan Spot Pemancingan</h4>
          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Sewa</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $currentNumber = $lastItem - $sewaPemancingan->count() + 1;
                    @endphp
                    @foreach ($sewaPemancingan as $key => $pemancingan)
                    <tr>
                        <td class="text-center">{{ $currentNumber++ }}</td>
                        <td>{{ $pemancingan->kode_booking }}</td>
                        <td>{{ $pemancingan->member->nama }}</td>
                        <td>{{ $pemancingan->tanggal_sewa }}</td>
                        <td class="text-align-end">
                            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pemancingan->id }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $pemancingan->id }}"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger delete" data-pemancinganid="{{ $pemancingan->id }}"><i class="fas fa-trash"></i></button>                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            
            {{-- Cek ada data atau kosong --}}
            @if($sewaPemancingan->isEmpty())
                <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
            @endif 

            <!-- Modal Detail Sewa Pemancingan -->
            @foreach($sewaPemancingan as $pemancingan)
            <div class="modal fade" id="detailModal{{ $pemancingan->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $pemancingan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $pemancingan->id }}">Detail Penyewan Pemancingan</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="row">
                                <div class="col">
                                    <p class="me-3" style="font-size: 18pt"><b>Kode Booking: {{ $pemancingan->kode_booking }}</b></p>
                                    <table class="table">
                                        <tr>
                                            <th style="width: 35%">Nama Pelanggan</th>
                                            <td>{{ $pemancingan->member->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Sewa</th>
                                            <td>{{ $pemancingan->tanggal_sewa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jam Mulai</th>
                                            <td>{{ $pemancingan->jam_mulai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jam Selesai</th>
                                            <td>{{ $pemancingan->jam_selesai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Sewa</th>
                                            <td>{{ $pemancingan->jumlah_sewa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Sewa</th>
                                            <td>{{ $pemancingan->biaya_sewa }}</td>
                                        </tr>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Modal Edit Sewa Pemancingan -->
            @foreach ($sewaPemancingan as $pemancingan)
            <div class="modal fade" id="editModal{{ $pemancingan->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $pemancingan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $pemancingan->id }}">Edit Penyewaan Pemancingan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/sewaPemancingan/{{ $pemancingan->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_nama_pelanggan">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="edit_nama_pelanggan" name="edit_nama_pelanggan" value="{{ $pemancingan->member->nama }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="edit_tanggal_sewa">Tanggal Sewa</label>
                                    <input type="date" class="form-control" id="edit_tanggal_sewa" name="edit_tanggal_sewa" value="{{ $pemancingan->tanggal_sewa }}" required>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col form-group">
                                        <label for="edit_jam_mulai">Jam Mulai</label>
                                        <input type="time" class="form-control" id="edit_jam_mulai" name="edit_jam_mulai" value="{{ date('H:i', strtotime($pemancingan->jam_mulai)) }}" required>
                                    </div>
                                    <div class="col form-group">
                                        <label for="edit_jam_selesai">Jam Selesai</label>
                                        <input type="time" class="form-control" id="edit_jam_selesai" name="edit_jam_selesai" value="{{ date('H:i', strtotime($pemancingan->jam_selesai)) }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="edit_jumlah_sewa">Jumlah Sewa</label>
                                    <input type="number" class="form-control" id="edit_jumlah_sewa" name="edit_jumlah_sewa" value="{{ $pemancingan->jumlah_sewa }}" required>
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
            @endforeach        
            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                            <form id="deleteForm" action="/admin/sewaPemancingan/{id}" method="post">
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
                    <li class="page-item {{ $sewaPemancingan->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $sewaPemancingan->previousPageUrl() ?? '#' }}" tabindex="-1">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!-- Tampilkan nomor halaman -->
                    @for ($i = 1; $i <= $sewaPemancingan->lastPage(); $i++)
                        <li class="page-item {{ $sewaPemancingan->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $sewaPemancingan->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $sewaPemancingan->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $sewaPemancingan->nextPageUrl() ?? '#' }}">
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

<!-- Javascript Button Delete -->
<script>
    $(document).ready(function() {
        // Menangani button delete
        $(document).on('click', '.delete', function() {
            const pemancinganid = $(this).data('pemancinganid'); // Perhatikan penggunaan snake_case di sini
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID data yang dipilih
            $('#deleteForm').attr('action', '/admin/sewaPemancingan/' +pemancinganid);
        });
    });
</script>

@endsection

