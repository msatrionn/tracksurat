<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_agenda';
    protected $table = 'm_surat_masuk';
    protected $fillable = [
        'no_agenda', 'no_surat', 'dari', 'kepada', 'status_disposisi', 'perihal', 'lampiran', 'tanggal_surat', 'jenis_surat', 'id_status', 'created_at'
    ];
}
