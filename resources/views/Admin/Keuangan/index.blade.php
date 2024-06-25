@extends('Admin.Layouts.main')

@section('title', 'Financial Management')

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
    @php
        $totalPemasukan = App\Models\Keuangan::where('jenis_transaksi', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = App\Models\Keuangan::where('jenis_transaksi', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;
    @endphp

    <div class="card p-3 mb-3">
        <div class="row">
            <div class="col">
                <h2>Saldo</h2>
            </div>
            <div class="col text-end">
                <a style="font-size: 18pt; font-weight: bold; color: {{ $saldo < 0 ? 'red' : 'green' }};">Rp {{ number_format($saldo, 0, ',', '.') }},-</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="font-weight-bolder mb-0">Financial Management</h4>
                    <div class="nav-wrapper position-relative end-0 mt-3 mb-3">
                        <ul class="nav nav-pills nav-fill p-1 mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#transaksi-tabs-simple" role="tab" aria-controls="transaksi" aria-selected="true">
                                    Transaction
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#mutasi-tabs-simple" role="tab" aria-controls="mutasi" aria-selected="false">
                                    Transaction Mutations
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            {{-- Tab Transaksi --}}
                            <div class="tab-pane fade show active" id="transaksi-tabs-simple" role="tabpanel" aria-labelledby="transaksi-tabs-simple">
                                {{-- Button Tambah --}}
                                <form action="/admin/keuangan/store" method="post">
                                    @csrf
                                    <div class="col-12 text-end">
                                        <button class="btn btn-outline-primary mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Add</button>
                                    </div>

                                    <!-- Modal Tambah Transaksi -->
                                    <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="tanggal_transaksi" class="col-form-label">Transaction Date</label>
                                                        <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ date('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jumlah" class="col-form-label">Amount</label>
                                                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenis_transaksi" class="col-form-label">Transaction Type</label>
                                                        <select class="form-select" id="jenis_transaksi" name="jenis_transaksi" required>
                                                            <option value="pemasukan">Income</option>
                                                            <option value="pengeluaran">Expenditure</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keterangan" class="col-form-label">Description</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="card-body ">
                                    <div class="table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th>Transaction Date</th>
                                                    <th>Amount</th>
                                                    <th>Transaction Type</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $currentNumber = $lastItem - $keuangans->count() + 1;
                                                @endphp
                                                @foreach ($keuangans as $key => $keuangan)
                                                    <tr>
                                                        <td class="text-center">{{ $currentNumber++ }}</td>
                                                        <td>{{ $keuangan->tanggal_transaksi }}</td>
                                                        <td>Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }},-</td>
                                                        <td class="text-center">
                                                            @if($keuangan->jenis_transaksi === 'pemasukan')
                                                                <span class="badge badge-sm text-success">Income</span>
                                                            @elseif($keuangan->jenis_transaksi === 'pengeluaran')
                                                                <span class="badge badge-sm text-danger">Expenditure</span>
                                                            @endif  
                                                        </td>
                                                        <td class="keterangan-column">{{ $keuangan->keterangan }}</td>
                                                        <td class="text-align-end">
                                                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $keuangan->id }}"><i class="fas fa-edit"></i></a>
                                                            <button class="btn btn-danger delete" data-transaksiid="{{ $keuangan->id }}"><i class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Cek ada data atau kosong --}}
                                    @if($keuangans->isEmpty())
                                        <h6 class="text-muted text-center">No data has been added yet</h6>
                                    @endif

                                    <!-- Modal Edit Transaksi -->
                                    @foreach ($keuangans as $keuangan)
                                        <div class="modal fade" id="editModal{{ $keuangan->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $keuangan->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $keuangan->id }}">Edit Transaction</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="/admin/keuangan/update/{{ $keuangan->id }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="edit_tanggal_transaksi">Transaction Date</label>
                                                                <input type="date" class="form-control" id="edit_tanggal_transaksi" name="edit_tanggal_transaksi" value="{{ $keuangan->tanggal_transaksi }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_jumlah">Amount</label>
                                                                <input type="number" class="form-control" id="edit_jumlah" name="edit_jumlah" value="{{ $keuangan->jumlah }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_jenis_transaksi">Transaction Type</label>
                                                                <select class="form-select" id="edit_jenis_transaksi" name="edit_jenis_transaksi" required>
                                                                    <option value="pemasukan" {{ $keuangan->jenis_transaksi == 'pemasukan' ? 'selected' : '' }}>Income</option>
                                                                    <option value="pengeluaran" {{ $keuangan->jenis_transaksi == 'pengeluaran' ? 'selected' : '' }}>Expenditure</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_keterangan">Description</label>
                                                                <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" rows="3">{{ $keuangan->keterangan }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
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
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure want to delete this transaction?
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="deleteForm" action="/admin/keuangan/{id}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <nav class="p-3" aria-label="Pagination">
                                        <ul class="pagination">
                                            <li class="page-item {{ $keuangans->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $keuangans->previousPageUrl() ?? '#' }}" tabindex="-1">
                                                    <i class="fa fa-angle-left"></i>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <!-- Tampilkan nomor halaman -->
                                            @for ($i = 1; $i <= $keuangans->lastPage(); $i++)
                                                <li class="page-item {{ $keuangans->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $keuangans->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                            <li class="page-item {{ $keuangans->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $keuangans->nextPageUrl() ?? '#' }}">
                                                    <i class="fa fa-angle-right"></i>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <!-- End Pagination -->
                                </div>
                            </div>

                            {{-- Tab Mutasi --}}
                            <div class="tab-pane fade" id="mutasi-tabs-simple" role="tabpanel" aria-labelledby="mutasi-tabs-simple">
                                @foreach ($mutasiTransaksi as $mutasi)
                                    <div class="card p-3 mt-2">
                                        <div class="row">
                                            <div class="col-md-2 d-flex align-items-center">
                                                <b>{{ $mutasi->kode_transaksi }}</b>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <a>{{ $mutasi->tanggal_transaksi }}</a><br>
                                                <small>{{ $mutasi->waktu_transaksi }}</small>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                {{ $mutasi->keterangan }}
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <b class="{{ $mutasi->jenis_transaksi === 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                                    {{ $mutasi->jenis_transaksi === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($mutasi->jumlah, 0, ',', '.') }},-
                                                </b>
                                            </div>                                            
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Cek ada data atau kosong --}}
                                @if($mutasiTransaksi->isEmpty())
                                    <h6 class="text-muted text-center">No data has been added yet</h6>
                                @endif

                                <!-- Pagination -->
                                <nav class="p-3" aria-label="Pagination">
                                    <ul class="pagination">
                                        <li class="page-item {{ $mutasiTransaksi->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $mutasiTransaksi->previousPageUrl() ?? '#' }}" tabindex="-1">
                                                <i class="fa fa-angle-left"></i>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <!-- Tampilkan nomor halaman -->
                                        @for ($i = 1; $i <= $mutasiTransaksi->lastPage(); $i++)
                                            <li class="page-item {{ $mutasiTransaksi->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $mutasiTransaksi->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $mutasiTransaksi->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $mutasiTransaksi->nextPageUrl() ?? '#' }}">
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
    </div>
</div>


<!-- Javascript Button Delete -->
<script>
    $(document).ready(function() {
        // Menangani button delete
        $(document).on('click', '.delete', function() {
            const transaksiId = $(this).data('transaksiid'); // Perhatikan penggunaan snake_case di sini
            $('#deleteModal').modal('show');

            // Mengubah action form berdasarkan ID transaksi yang dipilih
            $('#deleteForm').attr('action', '/admin/keuangan/' + transaksiId);
        });
    });
</script>

@endsection

