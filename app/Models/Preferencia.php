<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'ingredientesPositivos',
        'ingredientesNegativos',
    ];

    protected $casts = [
        'ingredientesPositivos' => 'array',
        'ingredientesNegativos' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
