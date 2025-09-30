<?php

namespace App\Http\Controllers;

use App\Models\Cnam;
use App\Models\Laborator;
use App\Models\LaboratorFisier;
use App\Models\Procedura;
use Illuminate\Http\Request;

class LaboratorController extends Controller
{
    public function showAll()
    {
        // preluăm toate analizele cu pacientul asociat
        $laborator = Laborator::with('pacient')->get();
        $columns = \Schema::getColumnListing('laborator');
        return view('cnam.laboratorShow', compact('laborator', 'columns'));
    }
    
    // public function create(Request $request)
    // {
    //     $query = Cnam::query();

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('numele', 'like', "%$search%")
    //                 ->orWhere('prenumele', 'like', "%$search%")
    //                 ->orWhere('idnp', 'like', "%$search%");
    //         });
    //     }

    //     $pacienti = $query->get();
    //     $pacient_id = $request->get('pacient_id');

    //     // dacă există un singur pacient găsit și nu a fost selectat încă
    //     if (!$pacient_id && $pacienti->count() === 1) {
    //         $pacient_id = $pacienti->first()->id;
    //     }

    //     $analize = $pacient_id ? Laborator::with('fisiere')->where('pacient_id', $pacient_id)->first() : null;

    //     return view('cnam.laborator', compact('pacienti', 'pacient_id', 'analize'));
    // }
    public function create(Request $request)
    {
        $query = Cnam::query();
    
        // Filtrare după căutare
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numele', 'like', "%$search%")
                  ->orWhere('prenumele', 'like', "%$search%")
                  ->orWhere('idnp', 'like', "%$search%");
            });
        }
    
        $pacienti = $query->get();
        $pacient_id = $request->get('pacient_id');
    
        // Dacă există un singur pacient găsit și nu a fost selectat încă
        if (!$pacient_id && $pacienti->count() === 1) {
            $pacient_id = $pacienti->first()->id;
        }
    
        // Preluăm analizele pacientului selectat
        $analize = $pacient_id 
            ? Laborator::with('fisiere')->where('pacient_id', $pacient_id)->first() 
            : null;
    
        // Navigare Anterior / Următor
        $prev_id = $next_id = null;
        if ($pacient_id) {
            $currentIndex = $pacienti->search(fn($p) => $p->id == $pacient_id);
    
            if ($currentIndex !== false) {
                $prev_id = $pacienti[$currentIndex - 1]->id ?? null;
                $next_id = $pacienti[$currentIndex + 1]->id ?? null;
            }
        }
    
        return view('cnam.laborator', compact('pacienti', 'pacient_id', 'analize', 'prev_id', 'next_id'));
    }
    

    public function store(Request $request)
    {
        $data = $request->all();

        // transformăm checkbox-urile în boolean
        foreach (
            [
                'hemograma',
                'proba_hemograma',
                'vsh',
                'coagulograma',
                'hemostaza',
                'proba_hemostaza',
                'mrs_hiv',
                'proba_mrs_hiv',
                'biochimia',
                'proba_biochimia',
                'colesterol_total',
                'hdl_colesterol',
                'ldl_colesterol',
                'trigliceride',
                'ureea',
                'creatina',
                'afp',
                'proba_afp',
                'glucoza',
                'alt',
                'ast',
                'alfa_amilaza',
                'fosfataza_alcalina',
                'ldh',
                'bilirubina_totala',
                'bilirubina_directa',
                'lipaza',
                'proteina_totala',
                'albumina',
                'acid_uric',
                'ggt',
                'magneziu',
                'calciu',
                'ferum',
                'imunologia',
                'proba_imunologia',
                'antistreptolizina_o',
                'factor_reumatic',
                'pcr',
                'tt3',
                'tt4',
                'tsh',
                'psa',
                'hbsag',
                'proba_hbsag',
                'hba1c',
                'proba_hba1c',
                'urograma',
                'proba_urograma',
                'coprologia',
                'proba_coprologia',
                'helminti',
                'sange_ocult'
            ] as $field
        ) {
            $data[$field] = $request->has($field);
        }

        // salvăm laboratorul
        $analize = Laborator::updateOrCreate(
            ['pacient_id' => $request->pacient_id],
            $data
        );

        // gestionăm fișierele (salvate separat în laborator_fisiere)
        foreach (
            [
                'rezultat_hemograma_file' => 'hemograma',
                'rezultat_biochimia_file' => 'biochimia',
                'rezultat_imunologia_file' => 'imunologia',
                'rezultat_urograma_file' => 'urograma',
                'rezultat_coprologia_file' => 'coprologia'
            ] as $fileField => $tip
        ) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('analize', 'public');
                LaboratorFisier::create([
                    'laborator_id' => $analize->id,
                    'tip_rezultat' => $tip,
                    'fisier' => $path,
                ]);
            }
        }
        $fields = ['hemograma','urograma','biochimia','imunologia','hba1c','hbsag','mrs_hiv','afp','hemostaza'];

        $data = [];
        foreach($fields as $field){
            $data[$field] = $request->has($field) ? 1 : 0;
        }
        
        // Salvare laborator
        $laborator = Laborator::updateOrCreate(
            ['pacient_id' => $request->pacient_id],
            $data
        );
        
        // Sincronizare proceduri
        Procedura::updateOrCreate(
            ['pacient_id' => $request->pacient_id],
            $data
        );

        return redirect()->route('laborator.create', ['pacient_id' => $request->pacient_id])
            ->with('success', 'Analizele și fișierele au fost salvate cu succes!');
    }

    public function destroyFisier($id)
    {
        $fisier = LaboratorFisier::findOrFail($id);

        if (\Storage::disk('public')->exists($fisier->fisier)) {
            \Storage::disk('public')->delete($fisier->fisier);
        }

        $fisier->delete();

        return response()->json(['success' => true]);
    }
}
