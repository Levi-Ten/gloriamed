<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laborator extends Model
{
    use HasFactory;

    protected $table = 'laborator';

    protected $fillable = [
        'pacient_id',

        // Hemograma
        'hemograma', 'proba_hemograma', 'rezultat_hemograma_text',

        // VSH
        'vsh', 'rezultat_vsh_text',

        // Coagulograma
        'coagulograma', 'rezultat_coagulograma_text',

        // Hemostaza
        'hemostaza', 'proba_hemostaza',

        // MRS HIV
        'mrs_hiv', 'proba_mrs_hiv',

        // Biochimia
        'biochimia', 'proba_biochimia', 'rezultat_biochimia_text',

        // Biochimia detalii
        'colesterol_total','hdl_colesterol','ldl_colesterol','trigliceride',
        'ureea','creatina',

        // AFP
        'afp','proba_afp',

        // Alte biochimice
        'glucoza','alt','ast','alfa_amilaza','fosfataza_alcalina','ldh',
        'bilirubina_totala','bilirubina_directa','lipaza','proteina_totala',
        'albumina','acid_uric','ggt','magneziu','calciu','ferum',

        // Imunologia
        'imunologia','proba_imunologia','rezultat_imunologia_text',

        // Imunologia detalii
        'antistreptolizina_o','factor_reumatic','pcr','tt3','tt4','tsh','psa',

        // HBsAg
        'hbsag','proba_hbsag',

        // HbA1c
        'hba1c','proba_hba1c',

        // Urograma
        'urograma','proba_urograma','rezultat_urograma_text',

        // Coprologia
        'coprologia','proba_coprologia','rezultat_coprologia_text',

        // Diverse
        'helminti','sange_ocult'
    ];

    public function pacient()
    {
        return $this->belongsTo(Cnam::class, 'pacient_id');
    }

    public function fisiere()
    {
        return $this->hasMany(LaboratorFisier::class, 'laborator_id');
    }
}
