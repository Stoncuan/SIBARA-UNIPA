<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use App\Service\PinjamanBarangService;
use App\Service\UserService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $userPinjamBarang = $this->pinjamanBarangService->getPinjamanByUser();
        $pinjamanBarangAll = $this->pinjamanBarangService->getAllPinjaman();
        $data = 0;


        return response()->view('home_peminjaman.peminjaman_barang', [
            "title" => "SIBARA-UNIPA",
            "totalBarang" => $totalBarang,
            "barang" => $barang,
            "totalBarangTersedia" => $totalBarangTersedia,
            "totalBarangPinjam" => $totalBarangPinjam,
            "user" => $user,
            "userSession" => $userSession,
            "userPinjamBarang" => $userPinjamBarang,
            "pinjamanBarangAll" => $pinjamanBarangAll,
            "data" => $data,
        ]);
    }

    public function viewGambarBarang($path)
    {
        // pastikan file ada
        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }



        $fullPath = Storage::disk('private')->path($path);
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
        ]);

        $nama_barang = $validasiBarang['nama_barang'];
        $penjelasan_barang = $validasiBarang['penjelasan_barang'];
        $gambar_barang = $request->file('gambar_barang');
        $total_barang = $validasiBarang['total_barang'];
        $barang_tersedia = $validasiBarang['total_barang'];

        $pathGambar = time() . "_" . $gambar_barang->getClientOriginalName();
        $path = 'gambar_barang/' . $pathGambar;

        Storage::disk('private')->put($path, file_get_contents($gambar_barang));


        $this->barangService->createBarang(
            $nama_barang,
            $penjelasan_barang,
            $path,
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
                Storage::disk('private')->delete('gambar_barang/' . $dataBarang['gambar_barang']);
            }

            Storage::disk('private')->put($path, file_get_contents($gambar_barang));
            $gambar_barang = $path;
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
