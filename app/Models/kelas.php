<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    /** @use HasFactory<\Database\Factories\KelasFactory> */
    use HasFactory;

    protected $table = "kelas";

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        "nama_kelas",
        "nama_jurusan",
    ];

    public function siswa()
    {
        return $this->hasMany(Kelas::class, "kelas_id", "id");
    }
}
