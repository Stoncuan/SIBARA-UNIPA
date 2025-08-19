<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Session;

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
        $validasi = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $name = $validasi['name'];
        $username = $validasi['username'];
        $password = $validasi['password'];

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

            Session::flash('error', 'Data user berhasil ditambahkan');
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

    public function updateUser(Request $request)
    {
        $validasi = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);

        $id = $validasi['id'];
        $name = $validasi['name'];
        $password = $validasi['password'];
        $username = $request->input('username');

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();


        Session::flash('error', 'Data user '.$username.'');
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
