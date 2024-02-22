<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuesta'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'descripcion', // Descripción de la encuesta
        'fecha_creacion', // Fecha de creación de la encuesta
        'fecha_finalizacion', // Fecha de finalización de la encuesta
        'id_empresa', // ID de la empresa asociada a la encuesta
    ];

    // Relación con el modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}