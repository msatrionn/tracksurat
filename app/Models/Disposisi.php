<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_disposisi';
    protected $table = "disposisi";
    protected $fillable = ['id_disposisi', 'no_agenda', 'nip', 'id_status', 'keterangan'];
}
