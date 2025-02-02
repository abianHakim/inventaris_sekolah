<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class td_peminjaman_barang extends Model
{
    /** @use HasFactory<\Database\Factories\TdPeminjamanBarangFactory> */
    use HasFactory;

    protected $table = 'td_peminjaman_barang';
    protected $primaryKey = 'pbd_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pbd_id',
        'pb_id',
        'br_kode',
        'pdb_tgl',
        'pdb_sts',
    ];

    public function barangInventaris()
    {
        return $this->belongsTo(tm_barang_inventaris::class, 'br_kode', 'br_kode');
    }

    public function peminjaman()
    {
        return $this->belongsTo(tm_peminjaman::class, 'pb_id', 'pb_id');
    }

    public function scopeBelumDikembalikan($query)
    {
        return $query->where('pdb_sts', 1); // 1 = Masih dipinjam
    }
}
