<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage role - SIBARA UNIPA</title>

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
            <div>
                <h3 class="text-center mb-4 mt-3">Manage Role & Permission</h3>
            </div>
            <a class="btn btn-warning mb-2 me-2" href="{{ url('/peminjaman-barang#userTable')}}">
                Kembali
            </a>
            <!-- Button trigger modal -->
            <button type=" button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahRole">
                Tambah role
            </button>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="text-align: center;">
                        <th scope="col">Role name</th>
                        <th scope="col">permissions</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allRolePermission as $rolePermission)
                        @continue(in_array($rolePermission->name, ['superAdmin']))

                        <tr>
                            <td>{{ $rolePermission->name }}</td>
                            <td>
                                @foreach ($rolePermission->permissions as $permission)
                                    <span class="">{{ $permission->name . "," }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ url('/edit-role/' . $rolePermission->id) }}"
                                    class="btn btn-sm btn-primary mb-2">Edit</a>

                                <form action="/delete-role/{{ $rolePermission->id }}" method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>
    </section>



    @if ($errors->tambahRole->any())
        <script>
            window.onload = function () {
                var modal = new bootstrap.Modal(document.getElementById('tambahRole'));
                modal.show();
            };  
        </script>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="tambahRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/tambah-role">
                        @csrf
                        <div class="modal-body: m-2">

                            <div class="mb-4">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" name="role" id="role"
                                    class="form-control @error('role', 'tambahRole') is-invalid @enderror"
                                    value="{{ old('role') }}">

                                @error('role', 'tambahRole')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                @foreach ($allPermission as $p)
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input @error('permission', 'tambahRole') is-invalid @enderror"
                                            type="checkbox" name="permission[]" id="permission_{{ $p['id'] }}"
                                            value="{{ $p['name'] }}">
                                        <label class="form-check-label"
                                            for="permission_{{ $p['id'] }}">{{ $p['name'] }}</label>
                                        @error('permission', 'tambahRole')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
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



</body>

</html>