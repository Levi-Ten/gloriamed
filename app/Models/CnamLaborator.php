<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnamLaborator extends Model
{
    use HasFactory;

    protected $table = 'cnam_laborator';

    protected $fillable = [
        'cnam_id', 'laborator_id', 'checked', 'categoria', 'proba', 'rezultat_text'
    ];

    protected $casts = [
        'proba' => 'array',
    ];

    public function cnam()
    {
        return $this->belongsTo(Cnam::class);
    }

    public function laborator()
    {
        return $this->belongsTo(Laborator::class);
    }

    public function fisiere()
    {
        return $this->hasMany(Fisiere::class, 'cnam_laborator_id');
    }
}
