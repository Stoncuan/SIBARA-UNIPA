<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barangs";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        "id",
        "nama_barang",
        "penjelasan_barang",
        "gambar_barang",
        "total_barang",
        "barang_tersedia"
    ];

}
