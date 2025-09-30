<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedura extends Model
{
    use HasFactory;

    protected $table = 'proceduri';

    protected $fillable = [
        'pacient_id', 'data_procedurii',
        'hemograma','urograma','biochimia','imunologia',
        'hba1c','hbsag','mrs_hiv','afp','hemostaza'
    ];

    public function pacient()
    {
        return $this->belongsTo(Cnam::class, 'pacient_id');
    }
}
