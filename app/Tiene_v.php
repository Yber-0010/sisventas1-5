<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tiene_v extends Model
{
    protected $table='tiene_v';
    protected $primaryKey='idtieneVenta';
    public $timestamps=false;

    protected $fillable=[
        'idtieneVenta',
        'idcaja',
        'idventa'
    ];
    protected $guarded=[

    ];
}
