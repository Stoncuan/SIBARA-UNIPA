<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\FuncCall;

class PinjamanBarangController extends Controller
{
    private PinjamanBarangService $pinjamanBarangService;
    private BarangService $barangService;
    private UserService $userService;

    public function __construct(PinjamanBarangService $pinjamanBarangService, BarangService $barangService, UserService $userService)
    {
        $this->pinjamanBarangService = $pinjamanBarangService;
        $this->barangService = $barangService;
        $this->userService = $userService;
    }

    public function createPinjaman(Request $request)
    {
        $validasi = $request->validate([
            'nama_barang' => 'required',
            'keperluan_barang' => 'required',
            'total_pinjaman' => 'required',
            'tanggal_pinjam_barang' => 'required',
            'tanggal_barang_kembali' => 'required',
            'nama_penanggung_jawab' => 'required',
            'status_barang' => 'required'
        ]);

        $nama_barang = $validasi['nama_barang'];
        $keperluan_barang = $validasi['keperluan_barang'];
        $total_pinjaman = $validasi['total_pinjaman'];
        $tanggal_pinjam_barang = $validasi['tanggal_pinjam_barang'];
        $tanggal_barang_kembali = $validasi['tanggal_barang_kembali'];
        $nama_penanggung_jawab = $validasi['nama_penanggung_jawab'];
        $status_barang = $validasi['status_barang'];

        $this->pinjamanBarangService->pinjamBarang(
            $nama_barang,
            $keperluan_barang,
            $total_pinjaman,
            $tanggal_pinjam_barang,
            $tanggal_barang_kembali,
            $nama_penanggung_jawab,
            $status_barang
        );

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();




        Session::flash('message', 'Barang berhasil di pinjam');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function editPinjaman(Request $request)
    {
        $validasi = $request->validate([
            'id' => 'required',
            'nama_barang' => 'required',
            'keperluan_barang' => 'required',
            'total_pinjaman' => 'required',
            'tanggal_pinjam_barang' => 'required',
            'tanggal_barang_kembali' => 'required',
            'nama_penanggung_jawab' => 'required',
            'status_barang' => 'required'
        ]);

        $id = $validasi['id'];
        $nama_barang = $validasi['nama_barang'];
        $keperluan_barang = $validasi['keperluan_barang'];
        $total_pinjaman = $validasi['total_pinjaman'];
        $tanggal_pinjam_barang = $validasi['tanggal_pinjam_barang'];
        $tanggal_barang_kembali = $validasi['tanggal_barang_kembali'];
        $nama_penanggung_jawab = $validasi['nama_penanggung_jawab'];
        $status_barang = $validasi['status_barang'];

        $this->pinjamanBarangService->updatePinjamBarang(
            $id,
            $nama_barang,
            $keperluan_barang,
            $total_pinjaman,
            $tanggal_pinjam_barang,
            $tanggal_barang_kembali,
            $nama_penanggung_jawab,
            $status_barang
        );

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();


        Session::flash('message', 'Barang ' . $nama_barang . 'berhasil di rubah');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function deletePinjaman(Request $request, $id)
    {
        $this->pinjamanBarangService->deletePinjaman($id);
        
        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        // ambil nama barang
        $nama_barang = $request->input('nama_barang');

        

        Session::flash('message', 'Barang ' . $nama_barang . 'berhasil di rubah');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

  
}
