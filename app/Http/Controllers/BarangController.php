<?php

namespace App\Http\Controllers;

use App\Service\BarangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    private BarangService $barangService;

    public function __construct(BarangService $barangService)
    {
        $this->barangService = $barangService;
    }

    public function homeBarang()
    {
        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();

        return response()->view('home_peminjaman.peminjaman_barang', [
            "title" => "Peminjaman Barang UPA TIK",
            "totalBarang" => $totalBarang,
            "barang" => $barang,
            "totalBarangTersedia" => $totalBarangTersedia
        ]);
    }

    public function createBarang(Request $request)
    {
        $validasiBarang = $request->validate([
            'nama_barang' => 'required',
            'penjelasan_barang' => 'required',
            'gambar_barang' => 'required',
            'total_barang' => 'required',
            'barang_tersedia' => 'required',
        ]);

        $nama_barang = $validasiBarang['nama_barang'];
        $penjelasan_barang = $validasiBarang['penjelasan_barang'];
        $gambar_barang = $validasiBarang['gambar_barang'];
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

        Session::flash('message', 'Data barang berhasil ditambahkan');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia);
    }

    public function updateBarang(Request $request)
    {
        $validasiBarang = $request->validate([
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

        Session::flash('message', 'Data barang berhasil di rubah');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia);
    }

    public function deleteBarang(Request $request, int $id)
    {
        $this->barangService->deleteBarang($id);

        $barang = $this->barangService->getAllBarang();
        $totalBarang = $this->barangService->totalBarang();
        $totalBarangTersedia = $this->barangService->totalBarangTersedia();

        Session::flash('message', 'Data barang berhasil dihapus');
        return redirect('/peminjaman-barang')
            ->with('barang', $barang)
            ->with('totalBarang', $totalBarang)
            ->with('totalBarangTersedia', $totalBarangTersedia);
    }
}
