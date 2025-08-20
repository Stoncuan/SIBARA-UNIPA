<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class BarangController extends Controller
{
    private BarangService $barangService;
    private PinjamanBarangService $pinjamanBarangService;
    private UserService $userService;

    public function __construct(BarangService $barangService, UserService $userService, PinjamanBarangService $pinjamanBarangService)
    {
        $this->barangService = $barangService;
        $this->pinjamanBarangService = $pinjamanBarangService;
        $this->userService = $userService;
    }

    public function homeBarang()
    {
        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        return response()->view('home_peminjaman.peminjaman_barang', [
            "title" => "Peminjaman Barang UPA TIK",
            "totalBarang" => $totalBarang,
            "barang" => $barang,
            "totalBarangTersedia" => $totalBarangTersedia,
            "totalBarangPinjam" => $totalBarangPinjam,
            "user" => $user,
            "userSession" => $userSession
        ]);
    }

    public function viewGambarBarang($path)
    {
         // pastikan file ada
        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        // ambil full path file di storage
        $fullPath = Storage::disk('local')->path($path);

        $fullPath = Storage::disk('local')->path($path);
        return response()->file($fullPath);

        // kalau mau langsung download, gunakan ini:
        // return response()->download($fullPath, basename($path));
    }

    public function createBarang(Request $request)
    {
        // validasi erronya custom
        $validasiBarang = $request->validateWithBag('tambahBarang', [
            'nama_barang' => 'required',
            'penjelasan_barang' => 'required',
            'gambar_barang' => 'required|file|mimes:jpeg,png,jpg|max:8000',
            'total_barang' => 'required',
            'barang_tersedia' => 'required',
        ]);

        $nama_barang = $validasiBarang['nama_barang'];
        $penjelasan_barang = $validasiBarang['penjelasan_barang'];
        $gambar_barang = $request->file('gambar_barang');
        $total_barang = $validasiBarang['total_barang'];
        $barang_tersedia = $validasiBarang['barang_tersedia'];

        $pathGambar = time() . "_" . $gambar_barang->getClientOriginalName();
        $path = 'gambar_barang/' . $pathGambar;

        Storage::disk('local')->put($path, file_get_contents($gambar_barang));


        $this->barangService->createBarang(
            $nama_barang,
            $penjelasan_barang,
            $gambar_barang,
            $total_barang,
            $barang_tersedia
        );

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Data barang berhasil ditambahkan');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function updateBarang(Request $request)
    {
        $validasiBarang = $request->validateWithBag("editBarang", [
            'id' => 'required',
            'nama_barang' => 'required',
            'penjelasan_barang' => 'required',
            'gambar_barang' => 'required',
            'total_barang' => 'required',
            'barang_tersedia' => 'required',
        ]);

        $id = $validasiBarang['id'];
        $nama_barang = $validasiBarang['nama_barang'];
        $penjelasan_barang = $validasiBarang['penjelasan_barang'];
        $gambar_barang = $validasiBarang['gambar_barang'];
        $total_barang = $validasiBarang['total_barang'];
        $barang_tersedia = $validasiBarang['barang_tersedia'];


        $dataBarang = $this->barangService->getBarangById($id);
        if ($gambar_barang) {
            $pathGambar = time() . "_" . $gambar_barang->getClientOriginalName();
            $path = 'gambar_barang/' . $pathGambar;

            if ($dataBarang) {
                Storage::disk('local')->delete('gambar_barang/' . $dataBarang['gambar_barang']);
            }

            Storage::disk('local')->put($path, file_get_contents($gambar_barang));
            $gambar_barang = $pathGambar;
        }

        $this->barangService->updateBarang(
            $id,
            $nama_barang,
            $penjelasan_barang,
            $gambar_barang,
            $total_barang,
            $barang_tersedia
        );

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Data barang berhasil di rubah');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }

    public function deleteBarang(Request $request, $id)
    {
        $this->barangService->deleteBarang($id);

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();
        $totalBarangPinjam = $this->pinjamanBarangService->getTotalPinjaman();
        $user = $this->userService->getAllUser();
        $userSession = $this->userService->getUserSession();

        Session::flash('message', 'Data barang berhasil dihapus');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia)
            ->with('totalBarangPinjam', $totalBarangPinjam)
            ->with('user', $user)
            ->with('userSession', $userSession);
    }
}
