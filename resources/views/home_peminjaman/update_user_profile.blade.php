<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Profile</title>

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
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">UPA TIK</h4>
                            <small>Unit Pelaksana Administrasi Teknologi Informasi dan Komunikasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
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
                                            <li><button class="dropdown-item btn btn-warning" href="#">Logout</button>
                                            </li>
                                        </form>

                                        <li>
                                            <button type="button" class="btn btn-warning btn-sm me-1"
                                                onclick="editUser({{ $userSession['id'] }})" data-bs-toggle="modal">
                                                <i class="fas fa-check me-1"></i>Edit
                                            </button>


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
            <h1 class="hero-title">Sistem Peminjaman Barang</h1>
            <p class="hero-subtitle">Kelola peminjaman barang inventaris dengan mudah dan efisien</p>
        </div>
    </section>



    <!-- update user profile -->

    <section>
        <div class="col-md-6 offset-md-3">
            <div class="modal-dialog">
                <div class="modal-content " style="background-color: #EEEEEE; margin-top: 40px;">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User Profile</h5>
                    </div>
                    <form method="post" action="/edit-user-profile">
                        @csrf
                        <div class="modal-body: m-2">
                            <input type="hidden" name="id" id="id"
                                class="form-control @error('userId', 'userEdit') is-invalid @enderror"
                                value="{{ old('id', $userSession['id']) }}" readonly>
                            @error('id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{ old('username', $userSession['username']) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name', 'userEdit') is-invalid @enderror"
                                    value="{{ old('name', $userSession['name']) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password') }}">
                                @error('password', 'userEdit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('/peminjaman-barang') }}" type="btn btn-primary"
                                    class="btn btn-secondary me-2">Close</a>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                </div>

                </form>
            </div>
        </div>
        </div>
    </section>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>

</html>