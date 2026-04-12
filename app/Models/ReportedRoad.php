<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedRoad extends Model
{
    protected $table = 'reported_roads';

    protected $fillable = [
        'nama_jalanan',
        'deskripsi',
        'path_foto_jalanan',
        'latitude',
        'longitude',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
