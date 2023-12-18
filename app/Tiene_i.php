<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tiene_i extends Model
{
    protected $table='tiene_i';
    protected $primaryKey='idtieneIngreso';
    public $timestamps=false;

    protected $fillable=[
        'idtieneIngreso',
        'idcaja',
        'idingreso'
    ];
    protected $guarded=[

    ];
}
