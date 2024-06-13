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
            {{-- Button Tambah --}}
            {{-- <form action="/admin/sewaAlat" method="post">
                @csrf
                <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-0" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
                </div> --}}
          </div>
          <!-- Modal Tambah Data Sewa Alat -->
          {{-- <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sewa Spot Pemancingan</h5>
                          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                          </button>
                      </div>
                      <form action="/admin/sewaAlat" method="post">
                          @csrf
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
                                  <label for="nama_alat" class="col-form-label">Alat Pancing</label>
                                  <div id="alat-pancing-container">
                                      <div class="row g-3 align-items-center alat-pancing-item">
                                          <div class="col-md-11 col-10 form-group">
                                              <select class="form-control" id="nama_alat" name="nama_alat[]" required>
                                                  <option value="">Pilih Alat Pancing</option>
                                                  @foreach($alatPancing as $alat)
                                                      @if($alat->status == 'available')
                                                          <option value="{{ $alat->id }}">{{ $alat->nama_alat }}</option>
                                                      @endif
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="col-md-1 col-2 d-flex align-items-end justify-content-end p-3 mt-0">
                                              <a onclick="removeAlat(this)"><i class="fas fa-trash" style="color: red"></i></a>
                                          </div>
                                      </div>
                                  </div>
                                  <a class="btn btn-primary" onclick="addAlat2()"><i class="fas fa-plus"></i> Tambah Alat Pancing</a>
                              </div>
                              <div class="row row-cols-2">
                                  <div class="col form-group">
                                      <label for="tgl_pinjam">Tanggal Pinjam</label>
                                      <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required>
                                  </div>
                                  <div class="col form-group">
                                      <label for="tgl_kembali">Tanggal Kembali</label>
                                      <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="{{ date('Y-m-d') }}" required>
                                  </div>
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
                                            <td>{{ $alat->biaya_sewa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>{{ $alat->status }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pengembalian</th>
                                            <td>{{ $alat->status_pengembalian }}</td>
                                        </tr>
                                    </table>
                                    @if($alat->status === 'belum dibayar')
                                        <form id="konfirmasiForm{{ $alat->id }}" action="{{ route('admin.sewaAlat.konfirmasiPembayaran', $alat->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="sudah dibayar" id="konfirmasiPembayaran{{ $alat->id }}" name="status" required>
                                                <label class="form-check-label" for="konfirmasiPembayaran{{ $alat->id }}">
                                                    Konfirmasi Pembayaran
                                                </label>
                                            </div>
                                            <button type="button" class="btn btn-success mt-3" onclick="showKonfirmasiModal({{ $alat->id }})">Konfirmasi</button>
                                        </form>
                                    @else
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
                            <button type="button" class="btn btn-primary" onclick="submitKonfirmasiForm({{ $alat->id }})">Konfirmasi</button>
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
                            <h5 class="modal-title" id="editModalLabel{{ $alat->id }}">Edit Penyewaan Alat Pancing</h5>
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
                                    <label for="edit_alat_pancing">Alat Pancing</label>
                                    <div id="alat-pancing-container">
                                        {{-- @foreach ($sewaAlat as $sewa)
                                            @foreach ($sewa->alatSewa as $alatSewa)
                                                <div class="row g-3 align-items-center alat-pancing-item">
                                                    <div class="col-md-11 col-10 form-group">
                                                        <select name="edit_alat_pancing[]" class="form-control">
                                                            @foreach ($alatSewa->alatPancing as $ap)
                                                                <option value="{{ $ap->id }}" {{ $alatSewa->alat_id == $ap->id ? 'selected' : '' }}>{{ $ap->nama_alat }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1 col-2 d-flex align-items-end justify-content-end p-3 mt-0">
                                                        <a onclick="removeAlat(this)"><i class="fas fa-trash" style="color: red"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach --}}
                                    </div>
                                    <a class="btn btn-primary" onclick="addAlat()"><i class="fas fa-plus"></i> Tambah Alat Pancing</a>
                                
                                    <!-- Hidden element to store the alatPancing options -->
                                    <div id="alatPancingOptions" style="display: none;">
                                        @foreach ($alatPancing as $ap)
                                            {{-- <option value="{{ $ap->id }}">{{ $ap->nama_alat }}</option> --}}
                                        @endforeach
                                    </div>
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
                                {{-- <div class="form-group">
                                    <label for="edit_alat_pancing">Alat Pancing</label>
                                    <div id="alat-pancing-container">
                                        <div class="row g-3 align-items-center alat-pancing-item">
                                            <div class="col-md-11 col-10 form-group">
                                                <select name="edit_alat_pancing[]" class="form-control">
                                                    <option value="">Pancing 1</option>
                                                    <option value="">Pancing 2</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 col-2 d-flex align-items-end justify-content-end p-3 mt-0">
                                                <a onclick="removeAlat(this)"><i class="fas fa-trash" style="color: red"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary" onclick="addAlat()"><i class="fas fa-plus"></i> Tambah Alat Pancing</a>
                                </div> --}}
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
            const alatid = $(this).data('alatid'); // Perhatikan penggunaan snake_case di sini
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
</script>

<script>
    function removeAlat(button) {
        button.closest('.alat-pancing-item').remove();
    }

    function addAlat() {
        const container = document.getElementById('alat-pancing-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'g-3', 'align-items-center', 'alat-pancing-item');
        
        const options = document.getElementById('alatPancingOptions').innerHTML;

        newItem.innerHTML = `
            <div class="col-md-11 col-10 form-group">
                <select name="edit_alat_pancing[]" class="form-control">
                    ${options}
                </select>
            </div>
            <div class="col-md-1 col-2 d-flex align-items-end justify-content-end p-3 mt-0">
                <a onclick="removeAlat(this)"><i class="fas fa-trash" style="color: red"></i></a>
            </div>
        `;
        container.appendChild(newItem);
    }

    function addAlat2() {
        const container = document.getElementById('alat-pancing-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'g-3', 'align-items-center', 'alat-pancing-item');

        const options = `
            <option value="">Pilih Alat Pancing</option>
            @foreach($alatPancings as $alat)
                @if($alat->status == 'available')
                    <option value="{{ $alat->id }}">{{ $alat->nama_alat }}</option>
                @endif
            @endforeach
        `;

        newItem.innerHTML = `
            <div class="col-md-11 col-10 form-group">
                <select class="form-control" name="nama_alat[]" required>
                    ${options}
                </select>
            </div>
            <div class="col-md-1 col-2 d-flex align-items-end justify-content-end p-3 mt-0">
                <a onclick="removeAlat(this)"><i class="fas fa-trash" style="color: red"></i></a>
            </div>
        `;
        container.appendChild(newItem);
    }
    
</script>

@endsection

