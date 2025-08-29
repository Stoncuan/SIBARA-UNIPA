<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit role - SIBARA UNIPA</title>
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
        <div class="col-md-6 offset-md-3">
            <div class="modal-dialog">
                <div class="modal-content " style="background-color: #EEEEEE; margin-top: 40px;">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permission Role</h5>
                    </div>
                    <form method="post" action="/edit-role">
                        @csrf
                        <div class="modal-body: m-2">

                            <input type="hidden" name="id" value="{{ $PermissionByRole['id'] }}">
                           
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" name="role" id="role"
                                    class="form-control @error('role') is-invalid @enderror"
                                    value="{{ old('role', $PermissionByRole['name']) }}">
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @foreach ($allPermission as $p)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('permission') is-invalid @enderror"
                                        type="checkbox" name="permission[]" id="permission_{{ $p['id'] }}"
                                        value="{{ $p['name'] }}" {{ $PermissionByRole->hasPermissionTo($p['name']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $p['id'] }}">{{ $p['name'] }}</label>
                                    @error('permission')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                            <div class="modal-footer">
                                <a href="{{ url('/manage-role') }}" type="btn btn-primary"
                                    class="btn btn-secondary me-2">Kembali</a>
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