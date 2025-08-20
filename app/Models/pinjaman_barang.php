<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pinjaman_barang extends Model
{
    protected $table = "pinjaman_barangs";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        "id",
        "nama_barang",
        "keperluan_barang",
        "total_pinjam",
        "tanggal_pinjam_barang",
        "tanggal_barang_kembali",
        "nama_penanggung_jawab",
        "status_barang"
    ];
}
