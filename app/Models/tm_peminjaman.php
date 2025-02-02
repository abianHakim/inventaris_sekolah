<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tm_peminjaman extends Model
{
    /** @use HasFactory<\Database\Factories\TmPeminjamanFactory> */
    use HasFactory;


    protected $table = 'tm_peminjaman';
    protected $primaryKey = 'pb_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'pb_tgl' => 'datetime',
        'pb_harus_kembali_tgl' => 'datetime',
    ];
    protected $fillable = [
        'pb_id',
        'user_id',
        'siswa_id',
        'pb_stat',
        'pb_tgl',
        'pb_harus_kembali_tgl',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function peminjamanBarang()
    {
        return $this->hasMany(td_peminjaman_barang::class, 'pb_id', 'pb_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(tm_pengembalian::class, 'pb_id', 'pb_id');
    }
}
