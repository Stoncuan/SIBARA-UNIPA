<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
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
            'password' => 'required'
        ]);

        $name = $validasi['name'];
        $username = $validasi['username'];
        $password = $validasi['password'];

        // permision
        $allRole = Role::all();
        $allPermission = Permission::all();



        $findUser = $this->userService->getUserByUsername($username);

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        if ($findUser) {
            Session::flash('error', 'Data user ' . $username . ' sudah ada');
            return redirect('/peminjaman-barang')
                ->with('title', 'Peminjaman Barang UPA TIK')
                ->with('barang', $barang)
                ->with('totalBarang', $totalBarang)
                ->with('totalBarangTersedia', $totalBarangTersedia)
                ->with('totalBarangPinjam', $totalBarangPinjam)
                ->with('user', $user)
                ->with('userSession', $userSession);
        } else {
            $this->userService->createUser($name, $username, $password);

            Session::flash('message', 'Data user berhasil ditambahkan');
            return redirect('/peminjaman-barang')
                ->with('title', 'Peminjaman Barang UPA TIK')
                ->with('barang', $barang)
                ->with('totalBarang', $totalBarang)
                ->with('totalBarangTersedia', $totalBarangTersedia)
                ->with('totalBarangPinjam', $totalBarangPinjam)
                ->with('user', $user)
                ->with('allRole', $allRole)
                ->with('allPermission', $allPermission)
                ->with('userSession', $userSession);
        }
    }

    public function updateUser(Request $request)
    {
        $validasi = $request->validateWithBag('userEdit', [
            'userId' => 'required',
            'name' => 'required',
            'password' => 'required'
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

        $this->userService->updateUser($id, $name, $password);


        Session::flash('message', 'Data user ' . $username . ' berhasil diubah');
        return redirect('/peminjaman-barang')
            ->with('title', 'Peminjaman Barang UPA TIK')
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

        $this->userService->updateUser($id, $name, $password);


        Session::flash('message', 'Profile anda berhasil diubah');
        return redirect('/peminjaman-barang')
            ->with('title', 'Peminjaman Barang UPA TIK')
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
        return redirect('/peminjaman-barang')
            ->with('title', 'Peminjaman Barang UPA TIK')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }
}
