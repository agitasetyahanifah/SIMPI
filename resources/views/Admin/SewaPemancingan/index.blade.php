@extends('Admin.Layouts.main')

@section('title', 'Fishing Spot Reservations')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>    
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>    
    </div>
@endif

<div class="container-fluid py-4">
    {{-- Update harga sewa spot --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="font-weight-bolder mb-0">Update Fishing Spot Reservation Price</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Price for Member -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    Member Price
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Rp <span id="memberPrice">{{ number_format($hargaMember, 0, ',', '.') }} ,-</span></h5>
                                        <p class="card-text">The price for members.</p>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updatePriceModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Update Price Modal Member -->
                        <div class="modal fade" id="updatePriceModal" tabindex="-1" aria-labelledby="updatePriceModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updatePriceModalLabel">Update Member Price</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.sewapemancingan.updateHargaSpot') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="newPrice" class="form-label">New Price</label>
                                                <input type="number" class="form-control" id="newPrice" name="price" required>
                                            </div>
                                            <input type="hidden" name="price_type" value="member">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price for Non-Member -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    Non-Member Price
                                </div>
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Rp <span id="nonMemberPrice">{{ number_format($hargaNonMember, 0, ',', '.') }} ,-</span></h5>
                                        <p class="card-text">The price for non-members.</p>
                                    </div>
                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updatePriceNonMemberModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Update Price for Non-Member -->
                        <div class="modal fade" id="updatePriceNonMemberModal" tabindex="-1" aria-labelledby="updatePriceNonMemberModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updatePriceNonMemberModalLabel">Update Non-Member Price</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.sewapemancingan.updateHargaSpot') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="newNonMemberPrice" class="form-label">New Price</label>
                                                <input type="number" class="form-control" id="newNonMemberPrice" name="price" required>
                                            </div>
                                            <input type="hidden" name="price_type" value="non member">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>            
        </div>
    </div>

    {{-- Update sesi sewa spot --}}
    <div class="row mb-3">
        <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h4 class="font-weight-bolder mb-0">Update Fishing Spot Reservation Session</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Add
                </button>

                <!-- Modal Add Session -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add New Session</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.sewaPemancingan.sessionsStore') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="startTime" class="form-label">Start Time</label>
                                            <input type="time" class="form-control" name="start_time">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="endTime" class="form-label">End Time</label>
                                            <input type="time" class="form-control" name="end_time">
                                        </div>
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($sesiSpot->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No sessions available.
                </div>
                @else
                    @foreach($sesiSpot as $session)
                        <form class="d-flex align-items-center" method="POST" action="{{ route('sewaPemancingan.index') }}">
                            @csrf
                            <div id="form-container" class="row w-100 g-3">
                                <div class="col-md-3">
                                    <label for="startTime" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" name="start_time" value="{{ $session->waktu_mulai }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="endTime" class="form-label">End Time</label>
                                    <input type="time" class="form-control" name="end_time" value="{{ $session->waktu_selesai }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="sessionTime" class="form-label">Session Time</label>
                                    <input type="text" class="form-control" name="session_time" value="{{ $session->waktu_sesi }}" readonly disabled>
                                </div>
                                <div class="col-md-3 d-flex justify-content-end">
                                    <!-- Update Button -->
                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $session->id }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
            
                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $session->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                @endif
            </div>         
        </div>
        </div>
    </div>

    <!-- Modal Update Sesi -->
    @foreach($sesiSpot as $session)
    <div class="modal fade" id="updateModal{{ $session->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $session->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{ $session->id }}">Update Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.sewaPemancingan.sessionsUpdate', $session->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="startTime{{ $session->id }}" class="form-label">Start Time</label>
                                {{-- <input type="time" class="form-control" id="startTime{{ $session->id }}" name="start_time" value="{{ $session->waktu_mulai }}" required> --}}
                                <input type="time" class="form-control" id="startTime{{ $session->id }}" name="start_time" value="{{ \Carbon\Carbon::parse($session->waktu_mulai)->format('H:i') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="endTime{{ $session->id }}" class="form-label">End Time</label>
                                {{-- <input type="time" class="form-control" id="endTime{{ $session->id }}" name="end_time" value="{{ $session->waktu_selesai }}" required> --}}
                                <input type="time" class="form-control" id="endTime{{ $session->id }}" name="end_time" value="{{ \Carbon\Carbon::parse($session->waktu_selesai)->format('H:i') }}" required>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Delete Modal -->
    @foreach($sesiSpot as $session)
    <div class="modal fade" id="deleteModal{{ $session->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $session->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $session->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this session?
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.sewaPemancingan.sessionsDelete', $session->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Sewa Spot Manajemen --}}
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="font-weight-bolder mb-0">Fishing Spot Reservation Management</h4>
            <div class="mt-3">                
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
          </div>
          <div class="card-body ">
            <div class="table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Booking Code</th>
                    <th>Customer Name</th>
                    <th>Booking Date</th>
                    <th class="text-center">Status</th>
                    <th>Action</th>
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
                            @if($pemancingan->status == 'sudah dibayar')
                                <span class="badge badge-sm bg-gradient-success">Already Paid</span>
                            @elseif($pemancingan->status == 'menunggu pembayaran')
                                <span class="badge badge-sm bg-gradient-secondary">Waiting for Payment</span>
                            @elseif($pemancingan->status == 'dibatalkan')
                                <span class="badge badge-sm bg-gradient-danger">Canceled</span>
                            @endif                    
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
                <h6 class="text-muted text-center">No data has been added yet</h6>
            @endif 

            <!-- Modal Detail Sewa Pemancingan -->
            @foreach($sewaPemancingan as $pemancingan)
            <div class="modal fade" id="detailModal{{ $pemancingan->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $pemancingan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $pemancingan->id }}">Fishing Spot Reservation Details</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <div class="row">
                                <div class="col">
                                    <p class="me-3" style="font-size: 18pt"><b>Booking Code: {{ $pemancingan->kode_booking }}</b></p>
                                    <table class="table">
                                        <tr>
                                            <th style="width: 35%">Customer Name</th>
                                            <td>{{ $pemancingan->member->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Booking Date</th>
                                            <td>{{ $pemancingan->tanggal_sewa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Spot Number</th>
                                            <td>{{ $pemancingan->spot->nomor_spot }}</td>
                                        </tr>
                                        <tr>
                                            <th>Session</th>
                                            <td>{{ $pemancingan->updateSesiSewaSpot->waktu_sesi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reservation Fee</th>
                                            <td>Rp {{ number_format($pemancingan->UpdateHargaSewaSpot->harga, 0, ',', '.') }} ,-</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>
                                                @if($pemancingan->status === 'dibatalkan')
                                                    <span class="text-danger">Canceled</span>
                                                @elseif($pemancingan->status === 'sudah dibayar')
                                                    <span class="text-success">Already Paid</span>
                                                @elseif($pemancingan->status === 'menunggu pembayaran')
                                                    <span class="text-warning">Waiting for Payment</span>
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
                                                    Payment Confirmation
                                                </label>
                                            </div>
                                            {{-- <button type="button" class="btn btn-success mt-3" onclick="showKonfirmasiModal({{ $pemancingan->id }})">Konfirmasi</button> --}}
                                            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $pemancingan->id }}">
                                                Confirm
                                            </button>                                                                                    
                                        </form>
                                        @elseif($pemancingan->status === 'dibatalkan')
                                            <p style="color: red"><i class="fas fa-times-circle" style="font-size: 18px"></i> Payment Cancelled</p>
                                        @elseif($pemancingan->status === 'sudah dibayar')
                                            <p style="color: green"><i class="fas fa-check-circle" style="font-size: 18px"></i> Payment has been confirmed</p>
                                        @endif                                
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal untuk Konfirmasi Pembayaran -->
            <div class="modal fade" id="konfirmasiModal{{ $pemancingan->id }}" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel{{ $pemancingan->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="konfirmasiModalLabel{{ $pemancingan->id }}">Payment Confirmation</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure want to confirm payment for the Booking Code: {{ $pemancingan->kode_booking }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" onclick="submitKonfirmasiForm({{ $pemancingan->id }})">Confirm</button>
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
                            <h5 class="modal-title" id="editModalLabel{{ $pemancingan->id }}">Edit Fishing Spot Reservations</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/sewaPemancingan/{{ $pemancingan->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p class="me-3" style="font-size: 18pt"><b>Booking Code: {{ $pemancingan->kode_booking }}</b></p>
                                <div class="form-group mb-3">
                                    <label for="edit_nama_pelanggan">Customer Name</label>
                                    <input type="text" class="form-control" id="edit_nama_pelanggan" name="edit_nama_pelanggan" value="{{ $pemancingan->member->nama }}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_tanggal_sewa">Booking Date</label>
                                    <input type="date" class="form-control dynamic-spot" id="edit_tanggal_sewa_{{ $pemancingan->id }}" name="edit_tanggal_sewa" value="{{ $pemancingan->tanggal_sewa }}" min="{{ date('Y-m-d') }}" data-id="{{ $pemancingan->id }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_sesi">Session</label>
                                    <select class="form-control dynamic-spot" id="edit_sesi_{{ $pemancingan->id }}" name="edit_sesi" data-id="{{ $pemancingan->id }}" required>
                                        @foreach($sesiSpot as $sesi)
                                            <option value="{{ $sesi->id }}" {{ $pemancingan->sesi_id == $sesi->id ? 'selected' : '' }}>
                                                {{ $sesi->waktu_sesi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edit_nomor_spot">Spot Number</label>
                                    <select class="form-control" id="edit_nomor_spot_{{ $pemancingan->id }}" name="edit_nomor_spot" required>
                                        @foreach($spots as $spot)
                                            @php
                                                // Mendapatkan sesi yang tersedia untuk spot ini pada tanggal yang ditentukan
                                                $availableSessions = $spot->getAvailableSessions($pemancingan->tanggal_sewa, $pemancingan->sesi_id);
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
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
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
                            Are you sure want to delete this data?
                        </div>
                        <div class="modal-footer">
                            <form id="deleteForm" action="/admin/sewaPemancingan/{id}" method="post">
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
{{-- <script>
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
</script> --}}

{{-- Script untuk Search --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const bookingCode = row.cells[1].textContent.toLowerCase().trim();
            const customerName = row.cells[2].textContent.toLowerCase().trim();
            const bookingDate = row.cells[3].textContent.toLowerCase().trim();
            const status = row.cells[4].textContent.toLowerCase().trim();

            if (bookingCode.includes(searchValue) || customerName.includes(searchValue) || bookingDate.includes(searchValue) || status.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

{{-- Javascript untuk ambil nomor spot yang tersedia berdasarkan tanggal dan sesi --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dynamic-spot').forEach(function(element) {
            element.addEventListener('change', function() {
                let id = this.getAttribute('data-id');
                let tanggalSewa = document.getElementById('edit_tanggal_sewa_' + id).value;
                let sesiId = document.getElementById('edit_sesi_' + id).value;
                let currentSpotId = document.getElementById('edit_nomor_spot_' + id).value;

                if (tanggalSewa && sesiId) {
                    fetch(`/admin/sewapemancingan/getAvailableSpots?tanggal_sewa=${tanggalSewa}&sesi_id=${sesiId}&current_spot_id=${currentSpotId}`)
                        .then(response => response.json())
                        .then(data => {
                            let spotSelect = document.getElementById('edit_nomor_spot_' + id);
                            spotSelect.innerHTML = '';

                            data.jsonSpots.forEach(spot => {
                                let option = document.createElement('option');
                                option.value = spot.id;
                                option.textContent = spot.nomor_spot;

                                if (spot.id == currentSpotId) {
                                    option.selected = true;
                                }

                                spotSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    });
</script>

@endsection
