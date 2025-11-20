<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'web';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'edad',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 Relaciones
    public function preferencias()
    {
        return $this->hasOne(Preferencia::class, 'usuario_id');
    }

    public function recetasPreferidas()
    {
        return $this->hasOne(RecetasPreferidas::class, 'usuario_id');
    }
}
