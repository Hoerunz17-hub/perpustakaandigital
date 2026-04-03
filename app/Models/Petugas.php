<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
     protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $guarded = [];
    // 🔥 TAMBAHIN DI SINI
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
