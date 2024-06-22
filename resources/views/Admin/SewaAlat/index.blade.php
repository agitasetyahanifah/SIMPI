@extends('Admin.Layouts.main')

@section('title', 'Sewa Alat Pancing')

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
            <h4 class="font-weight-bolder mb-0">Manajemen Sewa Alat Pancing</h4>
          </div>
          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Kode Sewa</th>
                    <th>Nama Pelanggan</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pengembalian</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $currentNumber = $lastItem - $sewaAlat->count() + 1;
                    @endphp
                    @foreach ($sewaAlat as $key => $alat)
                    <tr>
                        <td class="text-center">{{ $currentNumber++ }}</td>
                        <td>{{ $alat->kode_sewa}}</td>
                        <td>{{ $alat->member->nama }}</td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm
                            @if($alat->status == 'sudah dibayar')
                                bg-gradient-success
                            @elseif($alat->status == 'menunggu pembayaran')
                                bg-gradient-secondary
                            @elseif($alat->status == 'dibatalkan')
                                bg-gradient-danger
                            @endif
                        ">{{ $alat->status }}</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm
                            @if($alat->status_pengembalian == 'sudah kembali')
                                bg-gradient-success
                            @elseif($alat->status_pengembalian == 'proses')
                                bg-gradient-warning
                            @elseif($alat->status_pengembalian == 'terlambat kembali')
                                bg-gradient-danger
                            @endif
                        ">{{ $alat->status_pengembalian }}</span>
                        </td>
                        <td class="text-align-end">
                            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $alat->id }}"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger delete" data-alatid="{{ $alat->id }}"><i class="fas fa-trash"></i></button>                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            
            {{-- Cek ada data atau kosong --}}
            @if($sewaAlat->isEmpty())
                <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
            @endif 

            <!-- Modal Detail Sewa alat -->
            @foreach($sewaAlat as $alat)
            <div class="modal fade" id="detailModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $alat->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $alat->id }}">Detail Sewa Alat Pancing</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="row">
                                <div class="col">
                                    <p class="me-3" style="font-size: 18pt"><b>Kode Sewa: {{ $alat->kode_sewa }}</b></p>
                                    <table class="table">
                                        <tr>
                                            <th style="width: 35%">Nama Pelanggan</th>
                                            <td>{{ $alat->member->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Alat</th>
                                            <td>{{ $alat->alatPancing->nama_alat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah</th>
                                            <td>{{ $alat->jumlah }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pinjam</th>
                                            <td>{{ $alat->tgl_pinjam }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Kembali</th>
                                            <td>{{ $alat->tgl_kembali }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Sewa</th>
                                            <td>{{ number_format($alat->biaya_sewa, 0, ',', '.') }} ,-</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>
                                                @if($alat->status === 'dibatalkan')
                                                    <span class="text-danger">Dibatalkan</span>
                                                @elseif($alat->status === 'sudah dibayar')
                                                    <span class="text-success">Sudah Dibayar</span>
                                                @elseif($alat->status === 'menunggu pembayaran')
                                                    <span class="text-warning">Menunggu Pembayaran</span>
                                                @else
                                                    {{ $alat->status }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Pengembalian</th>
                                            <td>
                                                @if($alat->status === 'sudah dibayar')
                                                    @if($alat->status_pengembalian === null)
                                                        @php
                                                            $alat->status_pengembalian = 'proses';
                                                            $alat->save();
                                                        @endphp
                                                    @endif

                                                    @php
                                                        $today = Carbon\Carbon::now();
                                                        $tglKembali = Carbon\Carbon::parse($alat->tgl_kembali);
                                                        // Tentukan status pengembalian apakah terlambat atau tidak
                                                        if ($today->greaterThan($tglKembali) && $alat->status_pengembalian !== 'sudah kembali') {
                                                            $alat->status_pengembalian = 'terlambat kembali';
                                                            $alat->save();
                                                        }
                                                    @endphp

                                                    @if($alat->status_pengembalian === 'proses')
                                                        <span class="text-warning">Proses</span>
                                                    @elseif($alat->status_pengembalian === 'sudah kembali')
                                                        <span class="text-success">Sudah Kembali</span>
                                                    @elseif($alat->status_pengembalian === 'terlambat kembali')
                                                        <span class="text-danger">Terlambat Kembali</span>
                                                    @endif
                                                @else
                                                    {{ $alat->status_pengembalian }}
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- Calculate and display late fee -->
                                        @php
                                            $today = Carbon\Carbon::now();
                                            $tglKembali = Carbon\Carbon::parse($alat->tgl_kembali);
                                            $selisihHari = $tglKembali->diffInDays($today, false);
                                            $denda = $today->gt($tglKembali) ? $selisihHari * 5000 : 0;

                                            if ($alat->denda != $denda) {
                                                $alat->denda = $denda;
                                                $alat->save();
                                            }
                                        
                                            // Debugging output
                                            // echo "Today's Date: " . $today->toDateString() . "<br>";
                                            // echo "Return Date: " . $tglKembali->toDateString() . "<br>";
                                            // echo "Difference in Days: " . $selisihHari . "<br>";
                                            // echo "Fine: Rp " . number_format($denda, 0, ',', '.') . " ,-<br>";
                                        @endphp
                                        <tr>
                                            <th>Denda Terlambat</th>
                                            <td>
                                                @if($denda > 0)
                                                    <span class="text-danger">Rp {{ number_format($denda, 0, ',', '.') }} ,-</span>
                                                @else
                                                    Rp {{ number_format(0, 0, ',', '.') }} ,-
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    @if($alat->status === 'menunggu pembayaran')
                                        <form id="konfirmasiForm{{ $alat->id }}" action="{{ route('admin.sewaAlat.konfirmasiPembayaran', $alat->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="sudah dibayar" id="konfirmasiPembayaran{{ $alat->id }}" name="status" required>
                                                <label class="form-check-label" for="konfirmasiPembayaran{{ $alat->id }}">
                                                    Konfirmasi Pembayaran
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $alat->id }}">
                                                Konfirmasi
                                            </button>                                                                                    
                                        </form>
                                    @elseif($alat->status === 'sudah dibayar')
                                        <p style="color: green"><i class="fas fa-check-circle" style="font-size: 18px"></i> Pembayaran sudah dikonfirmasi</p>
                                    @elseif($alat->status === 'dibatalkan')
                                        <p style="color: red"><i class="fas fa-times-circle" style="font-size: 18px"></i> Pesanan dibatalkan</p>
                                    @endif

                                    @if($alat->status_pengembalian === 'proses' || $alat->status_pengembalian === 'terlambat kembali')
                                        <form id="konfirmasiPengembalianForm{{ $alat->id }}" action="{{ route('admin.sewaAlat.konfirmasiPengembalian', $alat->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="sudah kembali" id="konfirmasiPengembalian{{ $alat->id }}" name="status_pengembalian" required>
                                                <label class="form-check-label" for="konfirmasiPengembalian{{ $alat->id }}">
                                                    Konfirmasi Pengembalian Barang
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#konfirmasiPengembalianModal{{ $alat->id }}">
                                                Konfirmasi
                                            </button>                                                                                    
                                        </form>
                                    @elseif($alat->status_pengembalian === 'sudah kembali')
                                        <p style="color: green"><i class="fas fa-check-circle" style="font-size: 18px"></i> Pengembalian barang sudah dikonfirmasi</p>
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
            <div class="modal fade" id="konfirmasiModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel{{ $alat->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiModalLabel{{ $alat->id }}">Konfirmasi Pembayaran</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengonfirmasi pembayaran untuk Kode Sewa: {{ $alat->kode_sewa }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success" onclick="submitKonfirmasiForm({{ $alat->id }})">Ya, Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Modal untuk Konfirmasi Pengembalian Barang -->
            @foreach($sewaAlat as $alat)
            <div class="modal fade" id="konfirmasiPengembalianModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="konfirmasiPengembalianModalLabel{{ $alat->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiPengembalianModalLabel{{ $alat->id }}">Konfirmasi Pengembalian</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin mengkonfirmasi pengembalian barang untuk Kode Sewa: {{ $alat->kode_sewa }}?
                        </div>
                        <div class="modal-footer">
                            <form id="konfirmasiPengembalianForm{{ $alat->id }}" action="{{ route('admin.sewaAlat.konfirmasiPengembalian', $alat->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Modal Edit Sewa alat -->
            @foreach ($sewaAlat as $alat)
            <div class="modal fade" id="editModal{{ $alat->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $alat->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $alat->id }}">Edit Sewa Alat Pancing</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/sewaAlat/{{ $alat->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_nama_pelanggan">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="edit_nama_pelanggan" name="edit_nama_pelanggan" value="{{ $alat->member->nama }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="edit_alat">Alat yang Disewa</label>
                                    <select class="form-control" id="edit_alat" name="edit_alat">
                                        @foreach($alatPancings as $alatPancing)
                                            <option value="{{ $alatPancing->id }}" {{ $alatPancing->id == $alat->alatPancing->id ? 'selected' : '' }}>
                                                {{ $alatPancing->nama_alat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <div class="form-group">
                                    <label for="edit_jumlah">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" value="{{ $alat->jumlah }}">
                                </div>                           
                                <div class="row row-cols-2">
                                    <div class="col form-group">
                                        <label for="edit_tgl_pinjam">Tanggal Pinjam</label>
                                        <input type="date" class="form-control" id="edit_tgl_pinjam" name="edit_tgl_pinjam" value="{{ date('Y-m-d', strtotime($alat->tgl_pinjam)) }}" required>
                                    </div>
                                    <div class="col form-group">
                                        <label for="edit_tgl_kembali">Tanggal Kembali</label>
                                        <input type="date" class="form-control" id="edit_tgl_kembali" name="edit_tgl_kembali" value="{{ date('Y-m-d', strtotime($alat->tgl_kembali)) }}" required>
                                    </div>
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
                            <form id="deleteForm" action="/admin/sewaAlat/{id}" method="post">
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
                    <li class="page-item {{ $sewaAlat->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $sewaAlat->previousPageUrl() ?? '#' }}" tabindex="-1">
                            <i class="fa fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!-- Tampilkan nomor halaman -->
                    @for ($i = 1; $i <= $sewaAlat->lastPage(); $i++)
                        <li class="page-item {{ $sewaAlat->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $sewaAlat->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $sewaAlat->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $sewaAlat->nextPageUrl() ?? '#' }}">
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
            const alatid = $(this).data('alatid');
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID data yang dipilih
            $('#deleteForm').attr('action', '/admin/sewaAlat/' +alatid);
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

    function showKonfirmasiPengembalianModal(id) {
        var modal = new bootstrap.Modal(document.getElementById('konfirmasiPengembalianModal' + id), {
            keyboard: false
        });
        modal.show();
    }
</script>

@endsection

