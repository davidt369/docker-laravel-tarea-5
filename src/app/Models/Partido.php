<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partido extends Model
{
    use HasFactory;

    protected $table = 'partidos';
    protected $primaryKey = 'id_partido';
    protected $fillable = ['id_equipo_local', 'id_equipo_visitante', 'resultado'];


    public function equipoLocal(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo_local', 'id_equipo');
    }


    public function equipoVisitante(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo_visitante', 'id_equipo');
    }
}
