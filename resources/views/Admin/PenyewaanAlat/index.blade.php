@extends('Admin.Layouts.main')

@section('title', 'Penyewaan Alat Pancing')

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
        <div class="card mb-0">
          <div class="card-header pb-0">
            <h5 class="font-weight-bolder mb-0">Penyewaan Alat Pancing</h5>
            {{-- Button Tambah Alat Pancing --}}
            <form action="/admin/penyewaanAlat" method="post">
              @csrf
              <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-1" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
              </div>
          </div>
          {{-- Modal Tambah Penyewaan Alat Pancing --}}
          <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penyewaan Alat Pancing</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/admin/penyewaanAlat" method="POST">
                        @csrf
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="form-group">
                                <label for="nama_pelanggan" class="col-form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                            </div>
                            <div class="form-group">
                                <label for="alat_pancing" class="col-form-label">Alat Pancing</label>
                                <div id="alat_pancing_container">
                                    <select class="form-select" name="alat_pancing_id[]" required>
                                        @foreach($alatPancing->sortBy('nama_alat') as $alat)
                                            @if($alat->status == 'available')
                                                <option value="{{ $alat->id }}" data-harga="{{ $alat->harga }}">{{ $alat->nama_alat }}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>                            
                            <button type="button" class="btn btn-primary" onclick="tambahKolomAlatPancing()">
                                <i class="fas fa-plus"></i> Tambah Alat Pancing
                            </button>                                                        
                            <div class="form-group">
                                <label for="tanggal_pinjam" class="col-form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                            </div>
                            <div class="form-group">
                                <label for="masa_pinjam" class="col-form-label">Masa Pinjam (hari)</label>
                                <input type="number" class="form-control" id="masa_pinjam" name="masa_pinjam" required>
                            </div>
                            <div class="form-group">
                                <label for="biaya_sewa" class="col-form-label">Biaya Sewa</label>
                                <input type="number" class="form-control" id="biaya_sewa" name="biaya_sewa" onclick="hitungBiayaSewa()" value="" required readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Tambah</button>
                        </div>
                    </form>
                </div>
              </div>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alat Pancing</th>
                        <th>Tanggal Pinjam</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>                
                {{-- <tbody>
                  @php
                    $currentNumber = $lastItem - $sewaAlat->count() + 1;
                  @endphp
                  @if($alatPancing->count() > 0)
                    @foreach($alatPancing as $key => $alat)
                    <tr>
                      <td>
                        <p class="text-sm font-weight-bold mb-0 ps-4">{{ $currentNumber++ }}</p>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ asset('images/' . $alat->foto) }}" class="avatar avatar-xl me-3" alt="Alat Pancing">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $alat->nama_alat }}</h6>
                            <p class="text-xl text-secondary mb-0">{{ number_format($alat->harga, 0, ',', '.') }} /hari</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm text-center font-weight-bold mb-0">{{ $alat->jumlah }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span>
                      </td>
                      <td class="align-middle text-center">
                          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}"><i class="fas fa-eye"></i></button>
                          <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $alat->id }}"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger delete" data-alatId="{{ $alat->id }}"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody> --}}
              </table>
              <!-- Modal Delete -->
              {{-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus transaksi ini?
                        </div>
                        <div class="modal-footer">
                          <form id="deleteForm" action="/admin/alatPancing/{alatPancing}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
                        </form>                        
                        </div>                                    
                    </div>
                </div>
              </div> --}}
              <!-- Modal Edit Alat Pancing -->
              {{-- @foreach($alatPancing as $alat) --}}
              {{-- <div class="modal fade" id="editModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $alat->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel{{ $alat->id }}">Edit Alat Pancing</h5>
                              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <form action="/admin/alatPancing/{{ $alat->id }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                                  <div class="form-group">
                                      <label for="foto{{ $alat->id }}" class="col-form-label">Foto</label>
                                      <input type="file" class="form-control" id="foto{{ $alat->id }}" name="foto" accept="image/*">
                                  </div>
                                  <div class="form-group">
                                      <label for="nama_alat{{ $alat->id }}" class="col-form-label">Nama Alat</label>
                                      <input type="text" class="form-control" id="nama_alat{{ $alat->id }}" name="nama_alat" value="{{ $alat->nama_alat }}" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="harga{{ $alat->id }}" class="col-form-label">Harga</label>
                                      <input type="number" class="form-control" id="harga{{ $alat->id }}" name="harga" value="{{ $alat->harga }}" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="jumlah{{ $alat->id }}" class="col-form-label">Jumlah</label>
                                      <input type="number" class="form-control" id="jumlah{{ $alat->id }}" name="jumlah" value="{{ $alat->jumlah }}" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="status{{ $alat->id }}" class="col-form-label">Status</label>
                                      <select class="form-select" id="status{{ $alat->id }}" name="status" required>
                                          <option value="available" {{ $alat->status == 'available' ? 'selected' : '' }}>Available</option>
                                          <option value="not available" {{ $alat->status == 'not available' ? 'selected' : '' }}>Not Available</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="spesifikasi{{ $alat->id }}" class="col-form-label">Spesifikasi</label>
                                      <textarea class="form-control" id="spesifikasi{{ $alat->id }}" name="spesifikasi" rows="3">{{ $alat->spesifikasi }}</textarea>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn bg-gradient-primary">Update</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div> --}}
              {{-- @endforeach --}}
              <!-- Modal Detail Alat Pancing -->
              {{-- @foreach($alatPancing as $alat) --}}
              {{-- <div class="modal fade" id="detailModal{{ $alat->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $alat->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="detailModalLabel{{ $alat->id }}">Detail Alat Pancing</h5>
                              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                              <div class="row">
                                  <div class="col-md-6">
                                      <img src="{{ asset('images/' . $alat->foto) }}" class="img-fluid" alt="Foto Alat Pancing">
                                  </div>
                                  <div class="col-md-6">
                                      <h5>{{ $alat->nama_alat }}</h5>
                                      <p>Harga: {{ number_format($alat->harga, 0, ',', '.') }} /hari</p>
                                      <p>Jumlah: {{ $alat->jumlah }}</p>
                                      <p>Status: <span class="badge {{ $alat->status == 'available' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $alat->status }}</span></p>
                                      <p>Spesifikasi: </p><p>{!! nl2br(e($alat->spesifikasi)) !!}</p>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div> --}}
              {{-- @endforeach --}}
            </div>
          </div>
          
          {{-- Cek ada data atau kosong --}}
          {{-- @if($alatPancing->isEmpty())
            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
          @endif --}}
        
          <!-- Pagination -->
          {{-- <nav class="p-3" aria-label="Pagination">
            <ul class="pagination">
                <li class="page-item {{ $alatPancing->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $alatPancing->previousPageUrl() ?? '#' }}" tabindex="-1">
                        <i class="fa fa-angle-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <!-- Tampilkan nomor halaman -->
                @for ($i = 1; $i <= $alatPancing->lastPage(); $i++)
                    <li class="page-item {{ $alatPancing->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $alatPancing->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $alatPancing->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $alatPancing->nextPageUrl() ?? '#' }}">
                        <i class="fa fa-angle-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
          </nav> --}}
          <!-- End Pagination -->
        </div>
      </div>
    </div>
  </div>


{{-- Untuk tambah kolom alat pancing --}}
<script>
    function tambahKolomAlatPancing() {
        var alatPancingContainer = document.getElementById('alat_pancing_container');
        var newAlatPancingInput = document.createElement('div');
        newAlatPancingInput.classList.add('form-group');
        newAlatPancingInput.classList.add('mt-3');

        newAlatPancingInput.innerHTML = `
            <div class="input-group col-md-11">
                <select class="form-select" name="alat_pancing_id[]" required>
                    @foreach($alatPancing->sortBy('nama_alat') as $alat)
                        @if($alat->status == 'available')
                            <option value="{{ $alat->id }}" data-harga="{{ $alat->harga }}">{{ $alat->nama_alat }}</option>
                        @endif
                    @endforeach
                </select> 
                <a class="p-2" onclick="hapusKolomAlatPancing(this)">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        `;
        alatPancingContainer.appendChild(newAlatPancingInput);
    }

    function hapusKolomAlatPancing(button) {
        button.parentElement.remove();
    }
</script>

{{-- Untuk kolom biaya sewa --}}
<script>
    // Fungsi untuk menghitung biaya sewa
    function hitungBiayaSewa() {
        var masaPinjam = parseInt(document.getElementById('masa_pinjam').value);
        var totalBiayaSewa = 0; // Variabel untuk menyimpan total biaya sewa

        // Loop melalui setiap alat pancing yang dipilih
        var alatPancingInputs = document.getElementsByName('alat_pancing[]');
        alatPancingInputs.forEach(function(input) {
            var hargaAlat = parseInt(input.options[input.selectedIndex].getAttribute('data-harga'));
            totalBiayaSewa += hargaAlat; // Tambahkan harga alat ke total biaya sewa
        });

        // Hitung total biaya sewa
        var biayaSewa = masaPinjam * totalBiayaSewa;

        // Mengisi nilai biaya sewa pada input
        document.getElementById('biaya_sewa').value = biayaSewa;
    }

    // Panggil fungsi hitungBiayaSewa saat nilai masa pinjam berubah
    document.getElementById('masa_pinjam').addEventListener('change', hitungBiayaSewa);
    // Panggil fungsi hitungBiayaSewa saat nilai alat pancing berubah
    var alatPancingInputs = document.getElementsByName('alat_pancing[]');
    alatPancingInputs.forEach(function(input) {
        input.addEventListener('change', hitungBiayaSewa);
    });

</script>


@endsection

