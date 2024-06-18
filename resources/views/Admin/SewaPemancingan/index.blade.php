@extends('Admin.Layouts.main')

@section('title', 'Sewa Pemancingan')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="font-weight-bolder mb-0">Manajemen Penyewaan Spot Pemancingan</h4>
                
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
                            <h5 class="modal-title" id="detailModalLabel{{ $pemancingan->id }}">Detail Spot Pemancingan</h5>
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
                                            {{-- <button type="button" class="btn btn-success mt-3" onclick="showKonfirmasiModal({{ $pemancingan->id }})">Konfirmasi</button> --}}
                                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $pemancingan->id }}">
                                                Konfirmasi
                                            </button>                                                                                    
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
                            <button type="button" class="btn btn-success" onclick="submitKonfirmasiForm({{ $pemancingan->id }})">Konfirmasi</button>
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
                            <h5 class="modal-title" id="editModalLabel{{ $pemancingan->id }}">Edit Sewa Spot Pemancingan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/sewaPemancingan/{{ $pemancingan->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p class="me-3" style="font-size: 18pt"><b>Kode Booking: {{ $pemancingan->kode_booking }}</b></p>
                                <div class="form-group mb-3">
                                    <label for="edit_nama_pelanggan">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="edit_nama_pelanggan" name="edit_nama_pelanggan" value="{{ $pemancingan->member->nama }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_tanggal_sewa">Tanggal Sewa</label>
                                    <input type="date" class="form-control" id="edit_tanggal_sewa_{{ $pemancingan->id }}" name="edit_tanggal_sewa" value="{{ $pemancingan->tanggal_sewa }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_sesi">Sesi</label>
                                    <select class="form-control" id="edit_sesi_{{ $pemancingan->id }}" name="edit_sesi" required>
                                        <option value="08.00-12.00" {{ $pemancingan->sesi == '08.00-12.00' ? 'selected' : '' }}>08.00-12.00</option>
                                        <option value="13.00-17.00" {{ $pemancingan->sesi == '13.00-17.00' ? 'selected' : '' }}>13.00-17.00</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_nomor_spot">Nomor Spot</label>
                                    <select class="form-control" id="edit_nomor_spot_{{ $pemancingan->id }}" name="edit_nomor_spot" required>
                                        @foreach($spots as $spot)
                                            @php
                                                $availableSessions = $spot->getAvailableSessions($pemancingan->tanggal_sewa, $pemancingan->sesi);
                                            @endphp
                                            @if(count($availableSessions) > 0 || $spot->id == $pemancingan->spot->id)
                                                <option value="{{ $spot->id }}" {{ $spot->id == $pemancingan->spot->id ? 'selected' : '' }}>
                                                    {{ $spot->nomor_spot }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        function updateAvailableSpots(id) {
            const tanggalSewa = $(`#edit_tanggal_sewa_${id}`).val();
            const sesi = $(`#edit_sesi_${id}`).val();
            const currentSpotId = $(`#edit_nomor_spot_${id}`).val();
            const currentSesi = $(`#edit_sesi_${id} option:selected`).val();

            $.ajax({
                url: '{{ route("admin.sewapemancingan.getAvailableSpotsJson") }}',
                type: 'GET',
                data: {
                    tanggal_sewa: tanggalSewa,
                    sesi: sesi,
                    current_spot_id: currentSpotId,
                    current_sesi: currentSesi
                },
                success: function(response) {
                    const availableSpots = response.jsonSpots;
                    let options = '';

                    availableSpots.forEach(function(spot) {
                        options += `<option value="${spot.id}">${spot.nomor_spot}</option>`;
                    });

                    $(`#edit_nomor_spot_${id}`).html(options);
                    $(`#edit_nomor_spot_${id}`).val(currentSpotId);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('[id^=edit_tanggal_sewa_], [id^=edit_sesi_]').change(function() {
            const id = $(this).attr('id').split('_').pop();
            updateAvailableSpots(id);
        });

        $('[id^=edit_tanggal_sewa_], [id^=edit_sesi_]').each(function() {
            const id = $(this).attr('id').split('_').pop();
            updateAvailableSpots(id);
        });
    });
</script>


@endsection
