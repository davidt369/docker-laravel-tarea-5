<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    //
    use HasFactory;

    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';
    protected $fillable = ['nombre', 'colores'];


    public function partidosComoLocal(): HasMany
    {
        return $this->hasMany(Partido::class, 'id_equipo_local', 'id_equipo');
    }


    public function partidosComoVisitante(): HasMany
    {
        return $this->hasMany(Partido::class, 'id_equipo_visitante', 'id_equipo');
    }
}
