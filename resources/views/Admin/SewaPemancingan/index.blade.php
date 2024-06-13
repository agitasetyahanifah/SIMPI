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
            {{-- Button Tambah --}}
            {{-- <form action="/admin/sewaPemancingan" method="post">
                @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                </div> --}}
                
            <!-- Form Search -->
            {{-- <form action="{{ route('admin.sewaPemancingan.search') }}" method="GET">
                @if (request('kode_booking'))
                    <input type="hidden" class="form-control" name="kode_booking" placeholder="Kode Booking" value="{{ request('kode_booking') }}">
                @endif
                @if (request('nama_pelanggan'))
                    <input type="hidden" class="form-control" name="nama_pelanggan" placeholder="Nama Pelanggan" value="{{ request('nama_pelanggan') }}">
                @endif
                <div class="input-group mt-3">
                    <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari berdasarkan nama pelanggan/kode booking" aria-label="Cari berdasarkan nama pelanggan/kode booking" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary mb-0" type="submit" id="button-addon2">Cari</button>                    
                </div>
            </form> --}}
            <!-- End Form Search -->

            <form action="{{ route('admin.sewaPemancingan.search') }}" method="GET">
                <div class="input-group mt-3">
                    <input type="text" class="form-control" id="searchInput" name="keyword" placeholder="Cari berdasarkan nama pelanggan/kode booking" aria-label="Cari berdasarkan nama pelanggan/kode booking" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary mb-0" type="submit" id="button-addon2">Cari</button>                    
                </div>
            </form>
            
          </div>
          <!-- Modal Tambah Data Sewa Pemancingan -->
          {{-- <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sewa Spot Pemancingan</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                        <select class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                            <option value="">Pilih Nama Pelanggan</option>
                            @foreach($members as $member)
                                @if($member->status == 'aktif')
                                    <option value="{{ $member->id }}">{{ $member->nama }}</option>
                                @endif
                            @endforeach
                        </select>                        
                    </div>
                    <div class="form-group">
                        <label for="tanggal_sewa" class="col-form-label">Tanggal Sewa</label>
                        <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                    </div>
                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                        </div>
                        <div class="col form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_sewa">Jumlah Sewa</label>
                        <input type="number" class="form-control" id="jumlah_sewa" name="jumlah_sewa" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
            </div>
            </div>
          </div> --}}
          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Sewa</th>
                    <th>Status</th>
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
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm
                            @if($pemancingan->status == 'sudah dibayar')
                                bg-gradient-success
                            @elseif($pemancingan->status == 'menunggu pembayaran')
                                bg-gradient-secondary
                            @elseif($pemancingan->status == 'dibatalkan')
                                bg-gradient-danger
                            @endif
                        ">{{ $pemancingan->status }}</span>
                        </td>
                        <td class="text-align-end">
                            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pemancingan->id }}" data-id="{{ $pemancingan->id }}"><i class="fas fa-eye"></i></a>
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
                            <h5 class="modal-title" id="detailModalLabel{{ $pemancingan->id }}">Detail Penyewaan Pemancingan</h5>
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
                                            <th>Nomor Spot</th>
                                            <td>{{ $pemancingan->spot->nomor_spot }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sesi</th>
                                            <td>{{ $pemancingan->sesi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Sewa</th>
                                            <td>Rp {{ number_format($pemancingan->biaya_sewa, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>
                                                @if($pemancingan->status === 'dibatalkan')
                                                    <span class="text-danger">Dibatalkan</span>
                                                @elseif($pemancingan->status === 'sudah dibayar')
                                                    <span class="text-success">Sudah Dibayar</span>
                                                @elseif($pemancingan->status === 'menunggu pembayaran')
                                                    <span class="text-warning">Menunggu Pembayaran</span>
                                                @else
                                                    {{ $pemancingan->status }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    @if($pemancingan->status === 'menunggu pembayaran')
                                        <form id="konfirmasiForm{{ $pemancingan->id }}" action="{{ route('admin.sewaPemancingan.konfirmasiPembayaran', $pemancingan->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="sudah dibayar" id="konfirmasiPembayaran{{ $pemancingan->id }}" name="status" required>
                                                <label class="form-check-label" for="konfirmasiPembayaran{{ $pemancingan->id }}">
                                                    Konfirmasi Pembayaran
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-success mt-3" onclick="showKonfirmasiModal({{ $pemancingan->id }})">Konfirmasi</button>
                                        </form>
                                        @elseif($pemancingan->status === 'dibatalkan')
                                            <p style="color: red"><i class="fas fa-times-circle" style="font-size: 18px"></i> Pembayaran dibatalkan</p>
                                        @elseif($pemancingan->status === 'sudah dibayar')
                                            <p style="color: green"><i class="fas fa-check-circle" style="font-size: 18px"></i> Pembayaran sudah dikonfirmasi</p>
                                        @endif                                
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal untuk Konfirmasi Pembayaran -->
            <div class="modal fade" id="konfirmasiModal{{ $pemancingan->id }}" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel{{ $pemancingan->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiModalLabel{{ $pemancingan->id }}">Konfirmasi Pembayaran</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengonfirmasi pembayaran untuk Kode Booking: {{ $pemancingan->kode_booking }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="submitKonfirmasiForm({{ $pemancingan->id }})">Konfirmasi</button>
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
                                    <input type="date" class="form-control" id="edit_tanggal_sewa" name="edit_tanggal_sewa" value="{{ $pemancingan->tanggal_sewa }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_spot_id_{{ $pemancingan->id }}">Nomor Spot</label>
                                    <select class="form-control edit_spot_id" id="edit_spot_id_{{ $pemancingan->id }}" name="edit_spot_id" required>
                                        <option value="{{ $pemancingan->spot_id }}" selected>{{ $pemancingan->spot->nomor_spot }}</option>
                                        <!-- Pilihan akan diisi oleh AJAX -->
                                        @foreach ($availableSpots as $spotNumber)
                                            <option id="" value="{{ $spotNumber }}">{{ sprintf('%02d', $spotNumber) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_sesi_{{ $pemancingan->id }}">Sesi</label>
                                    <select class="form-control edit_sesi" id="edit_sesi_{{ $pemancingan->id }}" name="edit_sesi" required>
                                        <option value="{{ $pemancingan->sesi }}" selected>{{ $pemancingan->sesi }}</option>
                                        <!-- Pilihan akan diisi oleh AJAX -->
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="edit_spot_id">Nomor Spot</label>
                                    <select class="form-control" id="edit_spot_id" name="edit_spot_id" required>
                                        @foreach ($availableSpots as $spotNumber)
                                            <option value="{{ $spotNumber }}" {{  $pemancingan->spot->nomor_spot == $spotNumber ? 'selected' : '' }}>
                                                {{ sprintf('%02d', $spotNumber) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                      --}}
                                {{-- <div class="form-group">
                                    <label for="edit_spot_id">Nomor Spot</label>
                                    <select class="form-control" id="edit_spot_id" name="edit_spot_id" required>
                                        @if($pemancingan->spot)
                                            <option value="{{ $pemancingan->spot->id }}" selected>{{ sprintf('%02d', $pemancingan->spot->nomor_spot) }}</option>
                                        @endif
                                        @foreach ($availableSpots as $spotNumber)
                                            <option value="{{ $spotNumber }}">{{ sprintf('%02d', $spotNumber) }}</option>
                                        @endforeach
                                    </select>
                                </div>  --}}
                                {{-- <div class="form-group">
                                    <label for="edit_sesi">Sesi</label>
                                    <select class="form-control" id="edit_sesi" name="edit_sesi" required>
                                        @if(!empty($availableSessions))
                                            @foreach ($availableSessions as $spot => $sessions)
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session }}">{{ $session }}</option>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <option value="">Tidak ada sesi yang tersedia</option>
                                        @endif
                                    </select>
                                 </div> --}}
                            {{-- </div>                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
            @endforeach         --}}         
            
            
            {{-- @foreach ($sewaPemancingan as $pemancingan)
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
                                    <input type="date" class="form-control" id="edit_tanggal_sewa" name="edit_tanggal_sewa" value="{{ $pemancingan->tanggal_sewa }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_spot_id_{{ $pemancingan->id }}">Nomor Spot</label>
                                    <select class="form-control edit_spot_id" id="edit_spot_id_{{ $pemancingan->id }}" name="edit_spot_id" required>
                                        <option value="{{ $pemancingan->spot_id }}" selected>{{ $pemancingan->spot->nomor_spot }}</option>
                                        <!-- Pilihan akan diisi oleh AJAX -->
                                        @foreach ($availableSpots as $spotNumber)
                                            <option id="" value="{{ $spotNumber }}">{{ sprintf('%02d', $spotNumber) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_sesi_{{ $pemancingan->id }}">Sesi</label>
                                    <select class="form-control edit_sesi" id="edit_sesi_{{ $pemancingan->id }}" name="edit_sesi" required>
                                        <option value="{{ $pemancingan->sesi }}" selected>{{ $pemancingan->sesi }}</option>
                                        <!-- Pilihan akan diisi oleh AJAX -->
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="edit_spot_id">Nomor Spot</label>
                                    <select class="form-control" id="edit_spot_id" name="edit_spot_id" required>
                                        @foreach ($availableSpots as $spotNumber)
                                            <option value="{{ $spotNumber }}" {{  $pemancingan->spot->nomor_spot == $spotNumber ? 'selected' : '' }}>
                                                {{ sprintf('%02d', $spotNumber) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                      --}}
                                {{-- <div class="form-group">
                                    <label for="edit_spot_id">Nomor Spot</label>
                                    <select class="form-control" id="edit_spot_id" name="edit_spot_id" required>
                                        @if($pemancingan->spot)
                                            <option value="{{ $pemancingan->spot->id }}" selected>{{ sprintf('%02d', $pemancingan->spot->nomor_spot) }}</option>
                                        @endif
                                        @foreach ($availableSpots as $spotNumber)
                                            <option value="{{ $spotNumber }}">{{ sprintf('%02d', $spotNumber) }}</option>
                                        @endforeach
                                    </select>
                                </div>  --}}
                                {{-- <div class="form-group">
                                    <label for="edit_sesi">Sesi</label>
                                    <select class="form-control" id="edit_sesi" name="edit_sesi" required>
                                        @if(!empty($availableSessions))
                                            @foreach ($availableSessions as $spot => $sessions)
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session }}">{{ $session }}</option>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <option value="">Tidak ada sesi yang tersedia</option>
                                        @endif
                                    </select>
                                 </div> --}}
                            {{-- </div>                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
            @endforeach         --}}



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
            const pemancinganid = $(this).data('pemancinganid');
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID data yang dipilih
            $('#deleteForm').attr('action', '/admin/sewaPemancingan/' +pemancinganid);
        });
    });
</script>

<script>
    function showKonfirmasiModal(id) {
        const checkbox = document.getElementById('konfirmasiPembayaran' + id);
        if (checkbox.checked) {
            var modal = new bootstrap.Modal(document.getElementById('konfirmasiModal' + id), {
                keyboard: false
            });
            modal.show();
        } else {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal' + id), {
                keyboard: false
            });
            errorModal.show();
        }
    }

    function submitKonfirmasiForm(id) {
        document.getElementById('konfirmasiForm' + id).submit();
    }
</script>

@routes

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var pemancinganId = button.data('id');
        var modal = $(this);
        var tanggalInput = modal.find('.edit_tanggal_sewa');
        var sesiSelect = modal.find('.edit_sesi');
        var spotSelect = modal.find('.edit_spot_id');

        function fetchAvailableSpots(tanggal, sesi) {
            $.ajax({
                url: route('available-spots'), // Ubah url menjadi rute Laravel
                type: 'GET',
                data: { tanggal: tanggal, sesi: sesi },
                success: function(data) {
                    spotSelect.empty();
                    $.each(data.availableSpots, function(index, spot) {
                        spotSelect.append(`<option value="${spot.id}">${('0' + spot.nomor_spot).slice(-2)}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function fetchAvailableSessions(tanggal, spotId) {
            $.ajax({
                url: route('available-sessions'), // Ubah url menjadi rute Laravel
                type: 'GET',
                data: { tanggal: tanggal, spot_id: spotId },
                success: function(data) {
                    sesiSelect.empty();
                    $.each(data.availableSessions, function(index, session) {
                        sesiSelect.append(`<option value="${session}">${session}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        tanggalInput.change(function() {
            var tanggal = $(this).val();
            var sesi = sesiSelect.val();
            fetchAvailableSpots(tanggal, sesi);
        });

        sesiSelect.change(function() {
            var tanggal = tanggalInput.val();
            var spotId = spotSelect.val();
            fetchAvailableSessions(tanggal, spotId);
        });

        // Initialize when modal is shown
        var tanggalAwal = tanggalInput.val();
        var sesiAwal = sesiSelect.val();
        fetchAvailableSpots(tanggalAwal, sesiAwal);
        fetchAvailableSessions(tanggalAwal, spotSelect.val());
    });
});
</script>

@endsection

