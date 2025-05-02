<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jugador extends Model
{
    //
    use HasFactory;

    protected $table = 'jugadores';
    protected $primaryKey = 'id_jugador';
    protected $fillable = ['nombre', 'puesto', 'pierna'];
}
