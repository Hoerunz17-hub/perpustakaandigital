<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $guarded = [];

    public function user()
{
    return $this->belongsTo(User::class, 'id_user', 'id_user');
}
}
