<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['id_vendedor', 'referencia', 'valor'];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }
}