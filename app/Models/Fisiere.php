<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisiere extends Model
{
    use HasFactory;

    protected $table = 'fisiere';

    protected $fillable = [
        'cnam_laborator_id', 'cale_fisier', 'tip'
    ];

    public function cnamLaborator()
    {
        return $this->belongsTo(CnamLaborator::class, 'cnam_laborator_id');
    }
}
