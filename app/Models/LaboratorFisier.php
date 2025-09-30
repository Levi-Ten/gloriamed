<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorFisier extends Model
{
    use HasFactory;

    protected $table = 'laborator_fisiere';

    protected $fillable = [
        'laborator_id',
        'tip_rezultat', // hemograma, biochimia, imunologia, urograma, coprologia
        'fisier',
    ];

    public function laborator()
    {
        return $this->belongsTo(Laborator::class, 'laborator_id');
    }
}
