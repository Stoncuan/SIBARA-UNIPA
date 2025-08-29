<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - SIBARA UNIPA</title>

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



    <!-- update user profile -->

    <section>
        <div class="col-md-5 m-auto mb-5">
            <div class="modal-dialog">
                <div class="modal-content " style="background-color: #EEEEEE; margin-top: 40px;">
                    <form method="post" action="/edit-user">
                        @csrf
                        <div class="modal-content">
                            <input hidden type="text" name="userId"
                                class="form-control @error('userId', 'userEdit') is-invalid @enderror"
                                value="{{ old('userId', $user['id']) }}">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">User Edit</h1>
                            </div>
                            <div class="modal-body m-2">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input readonly type="text"
                                        class="form-control @error('username', 'userEdit') is-invalid @enderror"
                                        name="username" id="username" placeholder="username"
                                        value="{{ old('username', $user['username']) }}">
                                    @error('username', 'userEdit')
                                        <div class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control @error('name', 'userEdit') is-invalid @enderror" name="name"
                                        id="name" placeholder="name" value="{{ old('name', $user['name']) }}">
                                    @error('name', 'userEdit')
                                        <div class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Password</label>
                                    <input type="text"
                                        class="form-control @error('password', 'userEdit') is-invalid @enderror"
                                        name="password" id="password" placeholder="password">
                                    @error('password', 'userEdit')
                                        <div class="form-text" style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <select name="role" class="form-select @error('role', 'userEdit') is-invalid @enderror"
                                    aria-label="Default select example">
                                    <option value="" selected>Pilih role</option>
                                    @foreach ($allRole as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role', 'userEdit')
                                    <div class="form-text" style="color: red;">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="modal-footer me-3 mb-2">
                                <a href="{{ url('/peminjaman-barang') }}" class="btn btn-secondary me-2">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
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