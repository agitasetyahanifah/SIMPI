
@extends('Admin.Layouts.main')

@section('title', 'Manajemen Member')

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
            <h4 class="font-weight-bolder mb-0">Manajemen Member</h4>
            {{-- Button Tambah Member --}}
            <form action="/admin/members" method="post">
              @csrf
              <div class="col-12 text-end">
                  <button class="btn btn-outline-primary mb-1" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">Tambah</button>
              </div>
          </div>
          {{-- Modal Tambah Member --}}
          <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-m" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Member</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/admin/members" method="POST">
                        @csrf
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="form-group">
                                <label for="nama" class="col-form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="telepon" class="col-form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" maxlength="13" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
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
                    <th class="text-center">No</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $currentNumber = $lastItem - $members->count() + 1;
                  @endphp
                  @if($members->count() > 0)
                    @foreach($members as $key => $member)
                    <tr>
                      <td class="text-center">{{ $currentNumber++ }}</td>
                      <td>{{ $member->nama }}</td>
                      <td>{{ $member->telepon }}</td>
                      <td>{{ $member->email }}</td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm {{ $member->status == 'aktif' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $member->status }}</span>
                      </td>
                      <td class="align-middle text-center">
                          <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $member->id }}"><i class="fas fa-eye"></i></button>
                          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $member->id }}"><i class="fas fa-edit"></i></button>
                          <button class="btn btn-danger delete" data-memberId="{{ $member->id }}"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
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
                          <form id="deleteForm" action="/admin/members/{id}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger" id="confirmDelete">Hapus</button>
                        </form>                        
                        </div>                                    
                    </div>
                </div>
              </div>
              <!-- Modal Edit member Pancing -->
              @foreach($members as $member)
              <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-m" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel{{ $member->id }}">Edit Data Member</h5>
                              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <form action="/admin/members/{{ $member->id }}" method="post">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                  <div class="form-group">
                                      <label for="nama{{ $member->id }}" class="col-form-label">Nama</label>
                                      <input type="text" class="form-control" id="nama{{ $member->id }}" name="nama" value="{{ $member->nama }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="telepon{{ $member->id }}" class="col-form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon{{ $member->id }}" name="telepon" value="{{ $member->telepon }}" maxlength="13" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                  </div>                                                               
                                  <div class="form-group">
                                      <label for="email{{ $member->id }}" class="col-form-label">Email</label>
                                      <input type="email" class="form-control" id="email{{ $member->id }}" name="email" value="{{ $member->email }}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="password{{ $member->id }}" class="col-form-label">Password</label>
                                    <input type="password" class="form-control" id="password{{ $member->id }}" name="password">
                                  </div>
                                  <div class="form-group">
                                      <label for="status{{ $member->id }}" class="col-form-label">Status</label>
                                      <select class="form-select" id="status{{ $member->id }}" name="status" required>
                                          <option value="aktif" {{ $member->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                          <option value="tidak aktif" {{ $member->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              @endforeach
              <!-- Modal Detail member Pancing -->
              @foreach($members as $member)
              <div class="modal fade" id="detailModal{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $member->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="detailModalLabel{{ $member->id }}">Detail Member</h5>
                              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                          </div>
                          <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                              <div class="row">
                                <div class="col">
                                    <table class="table">
                                        <tr>
                                            <th>Nama</th>
                                            <td><b>{{ $member->nama }}</b></td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $member->telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $member->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $member->status }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $member->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $member->updated_at }}</td>
                                        </tr>
                                    </table>
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
            </div>
          </div>
          
          {{-- Cek ada data atau kosong --}}
          @if($members->isEmpty())
            <h6 class="text-muted text-center">Belum ada data yang ditambahkan</h6>
          @endif
        
          <!-- Pagination -->
          <nav class="p-3" aria-label="Pagination">
            <ul class="pagination">
                <li class="page-item {{ $members->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $members->previousPageUrl() ?? '#' }}" tabindex="-1">
                        <i class="fa fa-angle-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <!-- Tampilkan nomor halaman -->
                @for ($i = 1; $i <= $members->lastPage(); $i++)
                    <li class="page-item {{ $members->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $members->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $members->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $members->nextPageUrl() ?? '#' }}">
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

<!-- Javascript Button Delete -->
<script>
  $(document).ready(function() {
      // Menangani button delete
      $(document).on('click', '.delete', function() {
          const members = $(this).data('memberid'); 
          $('#deleteModal').modal('show');

          // Mengubah action form berdasarkan ID transaksi yang dipilih
          $('#deleteForm').attr('action', '/admin/members/' + members);
      });
  });
</script>

@endsection

