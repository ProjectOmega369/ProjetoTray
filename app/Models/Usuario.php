<?php

namespace App\Models;
use App\Models\Compra;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuario';

    protected $fillable = ['nome', 'email'];

    public $timestamps = false;

    protected $hidden = [];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_comprador');
    }
}
