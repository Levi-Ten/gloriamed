<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnam extends Model
{
    use HasFactory;

    protected $table = 'cnam';

    protected $fillable = [
        'numele',
        'prenumele',
        'data_nasterii',
        'idnp',
        'localitatea',
        'sectorul',
        'strada',
        'casa',
        'blocul',
        'apartamentul',
        'full_info',
    ];

    // setăm automat full_info
    protected static function booted()
    {
        static::creating(function ($cnam) {
            $cnam->full_info = $cnam->numele . ' ' . $cnam->prenumele . ' ' . $cnam->data_nasterii . ' ' . $cnam->idnp;
        });

        static::updating(function ($cnam) {
            $cnam->full_info = $cnam->numele . ' ' . $cnam->prenumele . ' ' . $cnam->data_nasterii. ' ' . $cnam->idnp;
        });
    }
    public function laboratorPacienti()
    {
        return $this->hasMany(CnamLaborator::class);
    }
    public function procedura()
    {
        return $this->hasOne(Procedura::class, 'pacient_id');
    }
}
