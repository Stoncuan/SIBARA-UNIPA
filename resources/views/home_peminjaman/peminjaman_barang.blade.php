<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link href="{{ asset('Image') }}/logo.png" rel="icon">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>
    @if (Session::has('message'))
        <script>
            Swal.fire({
                title: 'Sukses',
                text: "{{ Session::get('message') }}",
                icon: 'success',
                confirmButtonText: 'Oke'
            });
        </script>
    @endif
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="logo me-3">
                            <img src="{{ asset('Image') }}/logo.png" height="60px" alt="Logo">
                        </div>
                        <div>
                            <h4 class="mb-0">UPA TIK</h4>
                            <small>Unit Penunjang Akademik Teknologi Informasi dan Komunikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end mt-2">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="me-3">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        {{ $userSession['username'] }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <form method="post" action="/logout">
                                            @csrf

                                            <li><button class="dropdown-item btn btn-warning" href="#"><i
                                                        class="fa-solid me-1 fa-right-from-bracket"></i>Logout</button>
                                            </li>
                                        </form>

                                        <li>
                                            <a href="{{ url('/edit-user-profile') }}"
                                                class="dropdown-item btn btn-warning me-1">
                                                <i class="fa-solid me-1 fa-pen-to-square"></i></i>Update Profile
                                            </a>


                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="container text-center position-relative" style="z-index: 2;">
            <h1 class="hero-title">SIBARA-UNIPA</h1>
            <p class="hero-subtitle">Sistem Informasi Barang Universitas Papua</p>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="stats-container">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: var(--primary-color);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-number text-primary" id="totalBarang">{{ $totalBarang }}</div>
                        <div class="text-muted">Total Barang</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: var(--warning-color);">
                            <i class="fas fa-hand-holding"></i>
                        </div>
                        <div class="stat-number text-warning" id="barangDipinjam">{{ $totalBarangPinjam }}</div>
                        <div class="text-muted">Barang Dipinjam</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background: var(--success-color);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number text-success" id="barangDikembalikan">{{ $totalBarangTersedia }}</div>
                        <div class="text-muted">Barang Tersedia</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Items Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="text-center mb-4">Daftar Barang Tersedia</h2>
                </div>
                <div class="col-12">
                    @can('tambah barang')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarang">
                            Tambah Barang
                        </button>
                    @endcan



                    @if ($errors->tambahBarang->any())
                        <script>
                            window.onload = function () {
                                var modal = new bootstrap.Modal(document.getElementById('tambahBarang'));
                                modal.show();
                            };  
                        </script>
                    @endif



                    <!-- Modal -->
                    <div class="modal fade" id="tambahBarang" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/tambah-barang" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_barang" class="form-label"></label>
                                            <input type="text"
                                                class="form-control @error('nama_barang', 'tambahBarang') is-invalid @enderror"
                                                id="nama_barang" placeholder="nama barang" name="nama_barang"
                                                value="{{ old('nama_barang') }}">
                                            @error('nama_barang', 'tambahBarang')
                                                <div id="nama_barang" class="form-text" style="color: red;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="total_barang" class="form-label"></label>
                                            <input type="text"
                                                class="form-control @error('total_barang', 'tambahBarang') is-invalid @enderror"
                                                id="total_barang" placeholder="total barang" name="total_barang"
                                                value="{{ old('total_barang') }}">
                                            @error('total_barang', 'tambahBarang')
                                                <div id="total_barang" class="form-text" style="color: red;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>





                                        <div class="mb-3">
                                            <label for="penjelasan_barang" class="form-label">
                                                Karakteristik barang</label>
                                            <textarea
                                                class="form-control @error('penjelasan_barang', 'tambahBarang') is-invalid @enderror"
                                                id="penjelasan_barang" rows="3"
                                                name="penjelasan_barang">{{ old('penjelasan_barang') }}</textarea>
                                            @error('penjelasan_barang', 'tambahBarang')
                                                <div id="penjelasan_barang" class="form-text" style="color: red;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="gambar_barang" class="form-label">Gambar barang</label>
                                            <input
                                                class="form-control @error('gambar_barang', 'tambahBarang') is-invalid @enderror"
                                                name="gambar_barang" type="file" id="gambar_barang">
                                            @error('gambar_barang', 'tambahBarang')
                                                <div id="gambar_barang" class="form-text" style="color: red;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $barang->links() }}
                </div>
            </div>
            <div class="row g-4" id="itemsContainer">
                <!-- Items will be populated by JavaScript -->

            </div>

        </div>

    </section>

    <!-- My Borrowed Items Table -->
    <section class="py-5">
        <div class="container">
            <div class="card table-card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user-check me-2"></i>Barang Yang Saya Pinjam</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myBorrowedTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Borrowed Items Table -->
    <section class="py-5">
        <div class="container">
            <div class="card table-card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i>Semua Barang Yang Dipinjam</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="allBorrowedTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can('data user list')
        <!-- user data list -->
        <section class="py-5">
            <div class="container">
                <div class="card table-card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i>Data list user</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @can('tambah user')
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                    data-bs-target="#tambahUser">
                                    Tambah User
                                </button>
                            @endcan

                            @can('manage role')
                                <!-- Button trigger modal -->
                                <a href="{{ url('/manage-role') }}" type="button" class="btn btn-info mb-2">
                                    Manage role
                                </a>
                            @endcan
                            <table id="userTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan


    @if ($errors->tambahUser->any())
        <script>
            window.onload = function () {
                var modal = new bootstrap.Modal(document.getElementById('tambahUser'));
                modal.show();
            };
        </script>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="tambahUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="/tambah-user">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name', 'tambahUser') is-invalid @enderror"
                                id="name" placeholder="name" name="name" value="{{ old('name') }}">
                            @error('name', 'tambahUser')
                                <div class="form-text" style="color: red;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text"
                                class="form-control @error('username', 'tambahUser') is-invalid @enderror" id="username"
                                placeholder="username" name="username" value="{{ old('username') }}">
                            @error('username', 'tambahUser')
                                <div class="form-text" style="color: red;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text"
                                class="form-control @error('password', 'tambahUser') is-invalid @enderror" id="password"
                                placeholder="password" name="password" value="{{ old('password') }}">
                            @error('password', 'tambahUser')
                                <div class="form-text" style="color: red;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <select name="role" class="form-select @error('role', 'tambahUser') is-invalid @enderror"
                            aria-label="Default select example">
                            <option value="" selected>Pilih role</option>
                            @foreach ($allRole as $role)
                            @continue(in_array($role->name, ['superAdmin']))
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                        @error('role', 'tambahUser')
                            <div class="form-text" style="color: red;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer mb-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->tambahPinjam->any())
        <script>
            window.onload = function () {
                var modal = new bootstrap.Modal(document.getElementById('borrowModal'));
                modal.show();
            };
        </script>
    @endif

    <!-- Borrow Modal -->
    <div class="modal fade" id="borrowModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-hand-holding me-2"></i>Form Peminjaman Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="borrowForm" action="/pinjam-barang" method="post">
                        @csrf
                        <div class="row">
                            <input hidden type="text" name="id" class="form-control" id="id" readonly>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text"
                                        class="form-control @error('nama_barang', 'tambahPinjam') is-invalid @enderror"
                                        id="namaBarang" name="nama_barang" value="{{ old('nama_barang') }}" readonly>
                                    @error('nama_barang', 'tambahPinjam')
                                        <div id="nama_barang" class="form-text" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Tersedia</label>
                                    <input type="text" class="form-control" name="availableQty"
                                        value="{{ old('availableQty') }}" id="availableQty" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Peminjam</label>
                                    <input type="text" class="form-control" id="borrowerName"
                                        value="{{ old('username', $userSession['username']) }}"
                                        name="nama_penanggung_jawab" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Pinjam</label>
                                    <input type="number"
                                        class="form-control @error('total_pinjam', 'tambahPinjam') is-invalid @enderror"
                                        id="borrowQty" name="total_pinjam" min="1" value="{{ old('total_pinjam') }}">
                                    @error('total_pinjam', 'tambahPinjam')
                                        <div id="total_pinjam" class="form-text" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal pinjam</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pinjam_barang', 'tambahPinjam') is-invalid @enderror"
                                        id="returnDate" name="tanggal_pinjam_barang"
                                        value="{{ old('tanggal_pinjam_barang') }}">
                                    @error('tanggal_pinjam_barang', 'tambahPinjam')
                                        <div id="tanggal_pinjam_barang" class="form-text" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keperluan</label>
                            <textarea
                                class="form-control @error('keperluan_barang', 'tambahPinjam') is-invalid @enderror"
                                name="keperluan_barang" id="purpose" rows="3">{{ old('keperluan_barang')}}</textarea>
                            @error('keperluan_barang', 'tambahPinjam')
                                <div id="keperluan_barang" class="form-text" style="color: red;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient">
                        <span class="submit-text">Pinjam Barang</span>
                        <span class="loading d-none"></span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->editBarang->any())
        <script>
            window.onload = function () {
                var modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            };
        </script>
    @endif



    <!-- Borrow Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-hand-holding me-2"></i>Form Edit Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/edit-barang" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-md-6" hidden>
                                <div class="mb-3">
                                    <label class="form-label">id</label>
                                    <input type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                                        id="editId" readonly>
                                    @error('id')
                                        <div id="id" class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text"
                                        class="form-control @error('nama_barang', 'editBarang') is-invalid @enderror"
                                        id="editNamaBarang" name="nama_barang">

                                    @error('nama_barang', 'editBarang')
                                        <div id="nama_barang" class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Tersedia</label>
                                    <input type="text"
                                        class="form-control @error('barang_tersedia', 'editBarang') is-invalid @enderror"
                                        id="editJumlahTersedia" name="barang_tersedia" value="barang_tersedia">

                                    @error('barang_tersedia', 'editBarang')
                                        <div id="barang_tersedia" class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Barang</label>
                                    <input type="text"
                                        class="form-control @error('total_barang', 'editBarang') is-invalid @enderror"
                                        id="editJumlahBarang" name="total_barang" required>
                                    @error('total_barang', 'editBarang')
                                        <div id="total_barang" class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Gambar Barang</label>
                                    <input type="file"
                                        class="form-control @error('gambar_barang', 'editBarang') is-invalid @enderror"
                                        id="editJumlahBarang" name="gambar_barang">
                                    @error('gambar_barang_edit', 'editBarang')
                                        <div id="gambar_barang" class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penjelasan Barang</label>
                            <textarea
                                class="form-control @error('penjelasan_barang', 'editBarang') is-invalid @enderror"
                                id="editPenjelasan" name="penjelasan_barang" rows="3" required></textarea>
                            @error('penjelasan_barang', 'editBarang')
                                <div id="penjelasan_barang" class="form-text" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient">
                        <span class="submit-text">Edit Barang</span>
                        <span class="loading d-none"></span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>








    @if ($errors->userEditProfile->any())
        <script>
            window.onload = function () {
                var modal = new bootstrap.Modal(document.getElementById('userEditProfile'));
                modal.show();
            };  
        </script>
    @endif


    <!-- Modal -->
    <div class="modal fade" id="userEditProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="/edit-user-profile">
                @csrf
                <div class="modal-content">
                    <input type="hidden" name="userIdProfile"
                        class="form-control @error('userIdProfile', 'userEditProfile') is-invalid @enderror"
                        id="userIdProfile">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">User Edit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="usernameProfile" class="form-label">Username</label>
                            <input readonly type="text"
                                class="form-control @error('usernameProfile', 'userEditProfile') is-invalid @enderror"
                                name="usernameProfile" id="usernameProfile" placeholder="username">
                            @error('usernameProfile', 'userEditProfile')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nameProfile" class="form-label">Nama</label>
                            <input type="text"
                                class="form-control @error('nameProfile', 'userEditProfile') is-invalid @enderror"
                                name="nameProfile" id="nameProfile" placeholder="name">
                            @error('nameProfile', 'userEditProfile')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="passwordProfile" class="form-label">Password</label>
                            <input type="text"
                                class="form-control @error('passwordProfile', 'userEditProfile') is-invalid @enderror"
                                name="passwordProfile" id="passwordProfile" placeholder="password">
                            @error('passwordProfile', 'userEditProfile')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>





    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>// Sample data
        const items = [
            @foreach ($barang as $b)
                                                                                                                                                                                                                                                                                                                                                                                {
                    id: {{ $b['id'] }},
                    name: @json($b['nama_barang']),
                    description: @json($b['penjelasan_barang']),
                    image: @json(url('/gambar-barang/' . $b['gambar_barang'])),
                    total: {{ $b['total_barang'] }},
                    available: {{ $b['barang_tersedia'] }},
                    category: "all"
                }@if(!$loop->last), @endif
            @endforeach
            
        ];

        const myBorrowedItems = [
            @foreach ($userPinjamBarang as $UP)

                                                                                                                                                                                 {
                id: {{ $UP['id'] }},
                itemName: @json($UP['nama_barang']),
                borrowDate: "2024-01-15",
                id_barang: {{ $UP['id_barang'] }},
                total_pinjam: {{ $UP['total_pinjam'] }},
                returnDate: @json($UP['tanggal_barang_kembali'] ?? 'Belum Kembali'),

                status: @json($UP['status_barang']),
                @if($UP['status_barang'] === 'Dipinjam')
                    statusClass: "warning"
                @else
                    statusClass: "success"
                @endif
                                                                                                                                                                                },
            @endforeach
           
           
        ];

        const allBorrowedItems = [
            @foreach ($pinjamanBarangAll as $pinjamAll)
                                                                                                                                                                                 {
                id: {{ $pinjamAll['id'] }},
                itemName: @json($pinjamAll['nama_barang']),
                borrower: @json($pinjamAll['nama_penanggung_jawab']),
                borrowDate: @json($pinjamAll['tanggal_pinjam_barang']),
                id_barang: {{ $pinjamAll['id_barang'] }},
                total_pinjam: @json($pinjamAll['total_pinjam']),
                keperluan: @json($pinjamAll['keperluan_barang']),
                returnDate: @json($pinjamAll['tanggal_barang_kembali'] ?? 'Belum Kembali'),
                status: @json($pinjamAll['status_barang']),
                @if($pinjamAll['status_barang'] === 'Dipinjam')
                    statusClass: "warning"
                @else
                    statusClass: "success"
                @endif
                                                                                                                                                                                },
            @endforeach
           
        ];

        const user = [
            @foreach ($user as $u)
                                                                                                                                                                                                        {
                    id: {{ $u['id'] }},
                    username: @json($u['username']),
                    name: @json($u['name']),
                    created: @json($u['created_at']),
                    role: @json($u->getRoleNames()->first() ?? 'No Role'),
                    statusClass: "warning",
                },
            @endforeach
            
        ];

        // Initialize page
        document.addEventListener("DOMContentLoaded", function () {
            renderItems();
            initializeTables();
            setTodayDate();
            animateStats();
        });

        // Render items
        function renderItems() {
            const container = document.getElementById("itemsContainer");
            container.innerHTML = "";

            items.forEach((item, index) => {
                const itemCard = `
                    <div class="col-lg-4 col-md-6">
                        <div class="card item-card" style="animation-delay: ${index * 0.1
                    }s;">
                            <div class="item-image">
                                <img src="${item.image}" alt="${item.description
                    }" class="card-img-top">
                                <span class="badge ${item.available > 0
                        ? "bg-success"
                        : "bg-danger"
                    } badge-status">
                                    ${item.available > 0 ? "Tersedia" : "Habis"}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${item.name}</h5>
                                <p class="card-text text-muted">${item.description
                    }</p>
                                <div class="row text-center mb-3">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h6 class="text-primary mb-0">${item.total
                    }</h6>
                                            <small class="text-muted">Total</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-success mb-0">${item.available
                    }</h6>
                                        <small class="text-muted">Tersedia</small>
                                    </div>
                                </div>
                                <button class="btn btn-gradient w-100" 
                                        onclick="openBorrowModal(${item.id})"
                                        ${item.available === 0
                        ? "disabled"
                        : ""
                    }>
                                    <i class="fas fa-hand-holding me-2"></i>
                                    ${item.available > 0
                        ? "Pinjam Barang"
                        : "Tidak Tersedia"
                    }
                                </button>
                                
                                @can('hapus barang')
                                    <form action="/hapus-barang/${item.id}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100 mt-2">
                                    <i class="fas fa-hand-holding me-2"></i>
                                    Hapus Barang</button>
                                    </form>
                                @endcan

                            
                                @can('edit barang')
                                    <button class="btn btn-warning w-100 mt-2" onclick="editBorrowModal(${item.id})"  >
                                    <i class="fas fa-hand-holding me-2"></i>
                                    Edit Barang</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += itemCard;
            });
        }

        // Initialize DataTables
        function initializeTables() {
            // My Borrowed Items Table
            const myTable = $("#myBorrowedTable").DataTable({
                data: myBorrowedItems,
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                    { data: "itemName" },
                    { data: "borrowDate" },
                    { data: "returnDate" },
                    {
                        data: "status",
                        render: function (data, type, row) {
                            return `<span class="badge bg-${row.statusClass}">${data}</span>`;
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            if (
                                row.status === "Dipinjam" ||
                                row.status === "Terlambat"
                            ) {
                                return `<form method="POST" action="/kembalikan-barang/${row.id}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id_barang" value="${row.id_barang}">
                                            <input type="hidden" name="total_pinjam" value="${row.total_pinjam}">
                                    <button type="submit" class="btn btn-sm btn-success">
                                           <i class="fas fa-undo me-1"></i>Kembalikan
                                        </button>
                                </form>`;

                            }

                            return '<span class="text-muted">-</span>';
                        },
                    },
                ],
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json",
                },
            });

            // All Borrowed Items Table
            const allTable = $("#allBorrowedTable").DataTable({
                data: allBorrowedItems,
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                    { data: "itemName" },
                    { data: "borrower" },
                    { data: "borrowDate" },
                    { data: "returnDate" },
                    {
                        data: "status",
                        render: function (data, type, row) {
                            return `<span class="badge bg-${row.statusClass}">${data}</span>`;
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            let buttons = "";
                            if (
                                row.status === "Dipinjam" ||
                                row.status === "Terlambat"
                            ) {
                                buttons += `@can('kembalikan barang user')
                                        <form method="POST" action="/kembalikan-barang/${row.id}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id_barang" value="${row.id_barang}">
                                                <input type="hidden" name="total_pinjam" value="${row.total_pinjam}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                               <i class="fas fa-undo me-1"></i>Kembalikan
                                            </button>
                                    </form>
                                @endcan`;
                            }
                            buttons += `<button class="btn btn-sm btn-info" onclick="viewDetails(${row.id})">
                                           <i class="fas fa-eye me-1"></i>Detail
                                        </button>`;
                            return buttons;
                        },
                    },
                ],
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json",
                },
            });

            // All Borrowed Items Table
            const userTable = $("#userTable").DataTable({
                data: user,
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                    { data: "username" },
                    { data: "role",
                        render: function (data, type, row) {
                            return `<span class="badge bg-primary">${data}</span>`;
                        },
                     },
                    

                    {
                        data: null,
                        render: function (data, type, row) {
                            let buttons = "";

                            buttons += `<button class="btn btn-sm btn-info me-1" onclick="viewDetailsUser(${row.id})">
                                           <i class="fas fa-eye me-1"></i>Detail
                                        </button>`;

                            buttons += `@can('edit user')
                                                                <a href="javascript:void(0)" 
                                    class="btn btn-warning btn-sm me-1" 
                                    onclick="editUser(${row.id})">
                                    <i class="fas fa-check me-1"></i>Edit
                                </a>
                            @endcan`;

                            buttons += `@can('hapus user') 
                                <form method="POST" action="/hapus-user/${row.id}" class="d-inline">
                                                @csrf
                                    <button class="btn btn-sm btn-danger me-1" >
                                                   <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                </form>
                            @endcan`;
                            return buttons;
                        },
                    },
                ],
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json",
                },
            });
        }

        // Open borrow modal
        function openBorrowModal(itemId) {
            const item = items.find((i) => i.id === itemId);
            if (item) {
                document.getElementById("namaBarang").value = item.name;
                document.getElementById("id").value = item.id;
                document.getElementById("availableQty").value = item.available;
                document.getElementById("borrowQty").max = item.available;

                const modal = new bootstrap.Modal(
                    document.getElementById("borrowModal")
                );
                modal.show();

                // Store item ID for form submission
                document.getElementById("borrowForm").dataset.itemId = itemId;
            }
        }

        function editBorrowModal(itemId) {
            const item = items.find((i) => i.id === itemId);
            if (item) {

                document.getElementById("editNamaBarang").value = item.name;
                document.getElementById("editJumlahBarang").value = item.total;
                document.getElementById("editJumlahTersedia").value = item.available;
                document.getElementById("editPenjelasan").value = item.description;
                document.getElementById("editId").value = item.id;

                const modal = new bootstrap.Modal(
                    document.getElementById("editModal")
                );
                modal.show();

                // // Store item ID for form submission
                // document.getElementById("borrowForm").dataset.itemId = itemId;
            }
        }

        function editUser(userId) {
            window.location.href = `/edit-user/${userId}`;
        }


        // Set today's date as default
        function setTodayDate() {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("borrowDate").value = today;

            // Set minimum return date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById("returnDate").min = tomorrow
                .toISOString()
                .split("T")[0];
        }

        // Submit borrow form
        function submitBorrow() {
            const form = document.getElementById("borrowForm");
            const formData = new FormData(form);

            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Show loading
            const submitBtn = event.target;
            const submitText = submitBtn.querySelector(".submit-text");
            const loading = submitBtn.querySelector(".loading");

            submitText.classList.add("d-none");
            loading.classList.remove("d-none");
            submitBtn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                // Reset loading
                submitText.classList.remove("d-none");
                loading.classList.add("d-none");
                submitBtn.disabled = false;

                // Close modal
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("borrowModal")
                );
                modal.hide();

                // Show success message
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Permintaan peminjaman berhasil disubmit",
                    confirmButtonColor: "#007bff",
                }).then(() => {
                    // Update stats and refresh data
                    updateStats();
                    form.reset();
                    setTodayDate();
                });
            }, 2000);
        }

        // Return item
        function returnItem(itemId) {
            Swal.fire({
                title: "Konfirmasi Pengembalian",
                text: "Apakah Anda yakin ingin mengembalikan barang ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Kembalikan",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate API call
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Barang berhasil dikembalikan",
                        confirmButtonColor: "#007bff",
                    }).then(() => {
                        // Update tables and stats
                        updateStats();
                        $("#myBorrowedTable").DataTable().ajax.reload();
                    });
                }
            });
        }

        // Hapus
        function returnItemHapus(itemId) {
            Swal.fire({
                title: "Anda ingin menghapus user?",
                text: "Apakah Anda yakin ingin menghapus user?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Kembalikan",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulate API call
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "User berhasil terhapus",
                        confirmButtonColor: "#007bff",
                    }).then(() => {
                        // Update tables and stats
                        updateStats();
                        $("#myBorrowedTable").DataTable().ajax.reload();
                    });
                }
            });
        }

        // Admin return item
        function adminReturnItem(itemId) {
            returnItem(itemId);
        }

        function adminReturnItemHapus(itemId) {
            returnItemHapus(itemId);
        }

        // View details
        function viewDetails(itemId) {
            const item = allBorrowedItems.find(i => i.id === itemId);

            if (!item) {
                Swal.fire("Error", "Data tidak ditemukan", "error");
                return;
            }

            Swal.fire({
                title: "Detail Peminjaman",
                html: `
            <div class="text-start">
                <p><strong>ID: ${item.id}</strong> </p>
                <p><strong>Barang: ${item.itemName}</strong> </p>
                <p><strong>Peminjam: ${item.borrower}</strong> </p>
                <p><strong>Keperluan: ${item.keperluan}</strong> </p>
                <p><strong>Tanggal Pinjam: ${item.borrowDate}</strong> </p>
                <p><strong>Tanggal Kembali: ${item.returnDate}</strong> </p>
                <p><strong>Status:</strong>
                    <span class="badge bg-${item.statusClass}">${item.status}</span>
                </p>
            </div>
        `,
                confirmButtonColor: "#007bff",
            });
        }

        // View details
        function viewDetailsUser(itemId) {
            const item = user.find(i => i.id === itemId);
            Swal.fire({
                title: "Detail User",
                html: `
                    <div class="text-start">
                        <p><strong>ID:</strong> ${item.id}</p>
                        <p><strong>Username:</strong> ${item.username}</p>
                        <p><strong>Name:</strong> ${item.name}</p>
                        <p><strong>Role:</strong> ${item.role}</p>
                        <p><strong>Created at</strong> ${item.created}</p>
                    </div>
                `,
                confirmButtonColor: "#007bff",
            });
        }

        // Update statistics
        function updateStats() {
            // This would normally fetch from API
            const stats = {
                total: 250,
                borrowed: Math.floor(Math.random() * 50) + 40,
                available: 0,
                borrowers: Math.floor(Math.random() * 10) + 25,
            };

            stats.available = stats.total - stats.borrowed;

            document.getElementById("totalBarang").textContent = stats.total;
            document.getElementById("barangDipinjam").textContent = stats.borrowed;
            document.getElementById("barangDikembalikan").textContent = stats.available;
            document.getElementById("totalPeminjam").textContent = stats.borrowers;
        }

        // Animate statistics on load
        function animateStats() {
            const counters = document.querySelectorAll(".stat-number");
            counters.forEach((counter) => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            });
        }

        // Date validation
        document.getElementById("borrowDate").addEventListener("change", function () {
            const borrowDate = new Date(this.value);
            const returnInput = document.getElementById("returnDate");

            // Set minimum return date to the day after borrow date
            const minReturnDate = new Date(borrowDate);
            minReturnDate.setDate(minReturnDate.getDate() + 1);
            returnInput.min = minReturnDate.toISOString().split("T")[0];

            // Clear return date if it's before the new minimum
            if (returnInput.value && new Date(returnInput.value) <= borrowDate) {
                returnInput.value = "";
            }
        });

        // Quantity validation
        document.getElementById("borrowQty").addEventListener("input", function () {
            const max = parseInt(this.max);
            const value = parseInt(this.value);

            if (value > max) {
                this.value = max;
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: `Jumlah maksimal yang dapat dipinjam adalah ${max}`,
                    confirmButtonColor: "#007bff",
                });
            }
        });
    </script>



</body>

</html>