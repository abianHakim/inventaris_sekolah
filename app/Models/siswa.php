<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    protected $table = 'siswa';

    protected $primaryKey = 'siswa_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'siswa_id',
        'nisn',
        'nama_siswa',
        'kelas_id',
        'no_siswa',
    ];

    // public function jurusan()
    // {
    //     return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    // }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
