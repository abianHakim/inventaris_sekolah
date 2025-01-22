<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tm_barang_inventaris extends Model
{
    /** @use HasFactory<\Database\Factories\TmBarangInventarisFactory> */
    use HasFactory;

    protected $table = 'tm_barang_inventaris'; // Nama tabel
    protected $primaryKey = 'br_kode'; // Primary key
    public $incrementing = false; // Jika primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe primary key
    public function getStatusLabelAttribute()
    {
        // Pastikan kolom br_status ada di database dan diakses dengan benar
        return $this->br_status == 1 ? 'Tersedia' : 'Tidak Tersedia';
    }

    protected $fillable = [
        'br_kode',
        'jns_brg_kode',
        'user_id',
        'br_nama',
        'br_tgl_terima',
        'br_tgl_entry',
        'br_status',
    ];

    /**
     * Relasi ke tabel jenis barang.
     */
    public function jenisBarang()
    {
        return $this->belongsTo(tr_jenis_barang::class, 'jns_brg_kode', 'jns_brg_kode');
    }

    /**
     * Relasi ke tabel user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function peminjamanBarang()
    {
        return $this->hasMany(tm_barang_inventaris::class, 'br_code', 'br_code');
    }
}
