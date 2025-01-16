<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurusan extends Model
{
    /** @use HasFactory<\Database\Factories\JurusanFactory> */
    use HasFactory;

    protected $tabel = "jurusan";

    protected $fillable = [
        "nama_jurusan",
    ];

    public function siswa(){
        return $this->hasMany(Jurusan::class , "jurusan_id","id");
    }
}
