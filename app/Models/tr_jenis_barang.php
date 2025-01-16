<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tr_jenis_barang extends Model
{
    /** @use HasFactory<\Database\Factories\TrJenisBarangFactory> */
    use HasFactory;

    protected $table = "tr_jenis_barang";

    protected $primaryKey = "jns_brg_kode";

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        "jns_brg_kode",
        "jns_brg_nama",
    ];

    public function barangInventaris()
    {
        return $this->hasMany(tm_barang_inventaris::class, "jns_brg_kode", "jns_brg_kode");
    }
}
