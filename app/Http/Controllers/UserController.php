<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
use Auth;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private UserService $userService;
    private BarangService $barangService;
    private PinjamanBarangService $pinjamanBarangService;

    public function __construct(UserService $userService, BarangService $barangService, PinjamanBarangService $pinjamanBarangService)
    {
        $this->userService = $userService;
        $this->barangService = $barangService;
        $this->pinjamanBarangService = $pinjamanBarangService;
    }

    public function createUser(Request $request)
    {
        $validasi = $request->validateWithBag('tambahUser', [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'nullable|required',
        ]);

        $name = $validasi['name'];
        $username = $validasi['username'];
        $password = $validasi['password'];
        $role = $validasi['role'];

        $findUser = $this->userService->getUserByUsername($username);

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();


        if ($findUser) {
            Session::flash('error', 'Data user ' . $username . ' sudah ada');
            return redirect('/peminjaman-barang#userTable')
                ->with('title', 'SIBARA-UNIPA')
                ->with('barang', $barang)
                ->with('totalBarang', $totalBarang)
                ->with('totalBarangTersedia', $totalBarangTersedia)
                ->with('totalBarangPinjam', $totalBarangPinjam)
                ->with('user', $user)
                ->with('userSession', $userSession);
        } else {
            $this->userService->createUser($name, $username, $password, $role);


            Session::flash('message', 'Data user berhasil ditambahkan');
            return redirect('/peminjaman-barang#userTable')
                ->with('title', 'SIBARA-UNIPA')
                ->with('barang', $barang)
                ->with('totalBarang', $totalBarang)
                ->with('totalBarangTersedia', $totalBarangTersedia)
                ->with('totalBarangPinjam', $totalBarangPinjam)
                ->with('user', $user)
                ->with('userSession', $userSession);
        }
    }

    public function showUpateUser(Request $request, $id)
    {
        $userDetail = $this->userService->getUserById($id);
        $userSession = $this->userService->getUserSession();

        $user = $this->userService->getUserById($id);

        $allRole = Role::all();
        $allPermission = Permission::all();

        $USER = Auth::user();
        $userRoles = $USER->getRoleNames();
        $userPermission = $USER->getAllPermissions();

        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        return view('home_peminjaman.update_user')
            ->with('userDetail', $userDetail)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('userSession', $userSession)
            ->with('allRole', $allRole)
            ->with('allPermission', $allPermission)
            ->with('userRoles', $userRoles)
            ->with('user', $user)
            ->with('userPermission', $userPermission);
    }

    public function updateUser(Request $request)
    {
        $validasi = $request->validateWithBag('userEdit', [
            'userId' => 'required',
            'name' => 'required',
            'role' => 'nullable|required',
        ]);

        $id = $validasi['userId'];
        $name = $validasi['name'];
        $username = $request->input('username');
        $password = $request->input('password');

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        $USER = User::findOrFail($id);

        if ($request->has('role')) {
            $USER->syncRoles($validasi['role']);
        }

        if (empty($password)) {
            $this->userService->updateUserNoPassword($id, $name);
        } else {
            $this->userService->updateUser($id, $name, $password);
        }

        Session::flash('message', 'Data user ' . $username . ' berhasil diubah');
        return redirect('/peminjaman-barang#userTable')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function showRolePermission()
    {
        $userSession = $this->userService->getUserSession();

        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();

        $allRole = Role::all();
        $allPermission = Permission::all();

        $USER = Auth::user();
        $userRoles = $USER->getRoleNames();
        $userPermission = $USER->getAllPermissions();

        $allRolePermission = Role::with('permissions')->get();


        return view('home_peminjaman.role')
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('allRole', $allRole)
            ->with('userRoles', $userRoles)
            ->with('allPermission', $allPermission)
            ->with('userPermission', $userPermission)
            ->with('allRolePermission', $allRolePermission)
            ->with('userSession', $userSession);
    }

    public function createRole(Request $request)
    {
        $validasi = $request->validateWithBag('tambahRole', [
            'role' => 'required|unique:roles,name',
            'permission' => 'nullable',
            'permission.*' => 'string|exists:permissions,name'
        ]);

        $roleName = $validasi['role'];

        $role = Role::create(['name' => $roleName]);

        if ($request->has('permission')) {
            $role->givePermissionTo($validasi['permission']);
        }

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Role ' . $roleName . ' berhasil ditambahkan');
        return redirect('/manage-role')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function deleteRole($id)
    {
        $role = Role::findById($id);
        $roleName = $role->name;
        $role->delete();

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Role ' . $roleName . ' berhasil dihapus');
        return redirect('/manage-role')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function showEditRole(Request $request, $id)
    {
        $roleDetail = Role::with('permissions')->find($id);
        $userSession = $this->userService->getUserSession();

        $allRole = Role::all();
        $allPermission = Permission::all();

        $USER = Auth::user();
        $userRoles = $USER->getRoleNames();
        $userPermission = $USER->getAllPermissions();

        $PermissionByRole = Role::with('permissions')->find($id);

        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        return view('home_peminjaman.edit_role')
            ->with('roleDetail', $roleDetail)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('userSession', $userSession)
            ->with('allRole', $allRole)
            ->with('allPermission', $allPermission)
            ->with('userRoles', $userRoles)
            ->with('PermissionByRole', $PermissionByRole)
            ->with('userPermission', $userPermission);
    }

    public function updateRole(Request $request)
    {
        $validasi = $request->validate([
            'id' => 'required',
            'role' => 'required|nullable',
            'permission' => 'nullable|required',
        ]);

        $roleName = $validasi['role'];
        $id = $validasi['id'];

        $role = Role::findById($id);
        $role->name = $roleName;
        $role->save();

        if ($request->has('permission')) {
            $role->syncPermissions($validasi['permission']);
        } else {
            $role->syncPermissions([]); // Hapus semua jika kosong
        }

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Permission ' . $roleName . ' berhasil diubah');
        return redirect('/manage-role')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function showEditUserProfile()
    {
        $userSession = $this->userService->getUserSession();

        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();

        return view('home_peminjaman.update_user_profile')
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('userSession', $userSession);
    }

    public function updateUserProfile(Request $request)
    {
        $validasi = $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $id = $validasi['id'];
        $name = $validasi['name'];
        $password = $request->input('password');

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        if (empty($password)) {
            $this->userService->updateUserNoPassword($id, $name);
        } else {
            $this->userService->updateUser($id, $name, $password);
        }


        Session::flash('message', 'Profile anda berhasil diubah');
        return redirect('/peminjaman-barang')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);

    }

    public function deleteUser($id)
    {
        $this->userService->deleteUser($id);

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Data user berhasil dihapus');
        return redirect('/peminjaman-barang#userTable')
            ->with('title', 'SIBARA-UNIPA')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }
}
