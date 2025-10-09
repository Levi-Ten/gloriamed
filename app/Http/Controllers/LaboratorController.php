<?php

namespace App\Http\Controllers;

use App\Models\Cnam;
use App\Models\Laborator;
use App\Models\LaboratorFisier;
use App\Models\Procedura;
use Carbon\Carbon;
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
    public function index()
    {
        // preluăm toate analizele cu pacientul asociat
        $laborator = Laborator::with('pacient')->get();
        $columns = \Schema::getColumnListing('laborator');
        return view('cnam.laborator', compact('laborator', 'columns'));
    }

   
    public function create(Request $request)
    {
        // $laborator = Laborator::with('pacient')->get();
        $laborator = Laborator::with('pacient')->orderBy('id', 'desc')->paginate(10);
        $columns = \Schema::getColumnListing('laborator');
        $last = array_pop($columns); // remove last
        array_unshift($columns, $last);

        $query = Cnam::query();

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


        $data_analizei = Carbon::parse($request->get('date'))->format('Y-m-d');


        if (!$pacient_id && $pacienti->count() === 1) {
            $pacient_id = $pacienti->first()->id;
        }

        $query = Laborator::with('fisiere')
            ->where('pacient_id', $pacient_id)
            ->when($data_analizei, function ($q) use ($data_analizei) {
                return $q->where('data_analizei', $data_analizei);
            })
            ->first();

        $analize = $pacient_id
            ? $query
            : null;

        $a = $pacient_id
            ? Laborator::with('fisiere')->where('pacient_id', $pacient_id)->get()
            : null;

        // FILTRARE DUPĂ DATĂ + NAVIGARE ÎNTRE ANALIZE
        $pacientiCuAnalize = Laborator::with('pacient')
            ->select('pacient_id')
            ->distinct()
            ->get()
            ->pluck('pacient');
        $searchAnalize = $request->get('search_analize');

        $pacientiCuAnalizeFiltrati = $pacientiCuAnalize;

        if ($searchAnalize) {
            $pacientiCuAnalizeFiltrati = $pacientiCuAnalizeFiltrati->filter(function ($p) use ($searchAnalize) {
                $fullName = strtolower($p->numele . ' ' . $p->prenumele);
                return str_contains($fullName, strtolower($searchAnalize));
            });
        }

        // $data_analizei = $request->get('data_analizei');
        $dateDisponibile = collect();

        $pacientSelectat = $pacient_id ? Cnam::find($pacient_id) : null;

        // dd($data_analizei);
        return view('cnam.laborator', compact(
            'pacienti',
            'pacient_id',
            'analize',
            // 'prev_id',
            // 'next_id',
            'pacientSelectat',

            'pacientiCuAnalize',
            'data_analizei',
            'dateDisponibile',
            // 'prevDate',
            // 'nextDate',
            'searchAnalize',
            'pacientiCuAnalizeFiltrati',
            'a',
            'laborator',
            'columns'
        ));
    }

    // public function store(Request $request)
    // {
    //     $data = $request->all();
    //     $data['data_analizei'] = $request->input('data_analizei');
    //     // transformăm checkbox-urile în boolean
    //     foreach (
    //         [
    //             'hemograma',
    //             'proba_hemograma',
    //             'vsh',
    //             'coagulograma',
    //             'hemostaza',
    //             'proba_hemostaza',
    //             'mrs_hiv',
    //             'proba_mrs_hiv',
    //             'biochimia',
    //             'proba_biochimia',
    //             'colesterol_total',
    //             'hdl_colesterol',
    //             'ldl_colesterol',
    //             'trigliceride',
    //             'ureea',
    //             'creatina',
    //             'afp',
    //             'proba_afp',
    //             'glucoza',
    //             'alt',
    //             'ast',
    //             'alfa_amilaza',
    //             'fosfataza_alcalina',
    //             'ldh',
    //             'bilirubina_totala',
    //             'bilirubina_directa',
    //             'lipaza',
    //             'proteina_totala',
    //             'albumina',
    //             'acid_uric',
    //             'ggt',
    //             'magneziu',
    //             'calciu',
    //             'ferum',
    //             'imunologia',
    //             'proba_imunologia',
    //             'antistreptolizina_o',
    //             'factor_reumatic',
    //             'pcr',
    //             'tt3',
    //             'tt4',
    //             'tsh',
    //             'psa',
    //             'hbsag',
    //             'proba_hbsag',
    //             'hba1c',
    //             'proba_hba1c',
    //             'urograma',
    //             'proba_urograma',
    //             'coprologia',
    //             'proba_coprologia',
    //             'helminti',
    //             'sange_ocult'
    //         ] as $field
    //     ) {
    //         $data[$field] = $request->has($field);
    //     }

    //     // salvăm laboratorul
    //     $analize = Laborator::updateOrCreate(
    //         ['pacient_id' => $request->pacient_id],
    //         $data
    //     );

    //     // gestionăm fișierele (salvate separat în laborator_fisiere)
    //     foreach (
    //         [
    //             'rezultat_hemograma_file' => 'hemograma',
    //             'rezultat_biochimia_file' => 'biochimia',
    //             'rezultat_imunologia_file' => 'imunologia',
    //             'rezultat_urograma_file' => 'urograma',
    //             'rezultat_coprologia_file' => 'coprologia'
    //         ] as $fileField => $tip
    //     ) {
    //         if ($request->hasFile($fileField)) {
    //             $path = $request->file($fileField)->store('analize', 'public');
    //             LaboratorFisier::create([
    //                 'laborator_id' => $analize->id,
    //                 'tip_rezultat' => $tip,
    //                 'fisier' => $path,
    //             ]);
    //         }
    //     }
    //     $fields = ['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'];
    //     $areToate = 1;

    //     $data = [];
    //     foreach ($fields as $field) {
    //         $data[$field] = $request->has($field) ? 1 : 0;
    //         if (empty($data[$field])) {
    //             $areToate = 0;
    //             break;
    //         }
    //     }
    //     $data['data_analizei'] = $request->input('data_analizei');
    //     $data['pacient_id'] = $request->pacient_id;
    //     // Salvare laborator
    //     // $laborator = Laborator::updateOrCreate(
    //     //     ['pacient_id' => $request->pacient_id],
    //     //     $data
    //     // );
    //     $analiza = Laborator::create($data);
    //     // Sincronizare proceduri
    //     Procedura::updateOrCreate(
    //         ['pacient_id' => $request->pacient_id],
    //         // $data
    //         array_merge($data, ['toate_procedurile' => $areToate])
    //     );
    //     // dd(['toate_procedurile' => $areToate]);
    //     return redirect()->route('laborator.create', ['pacient_id' => $request->pacient_id])
    //         ->with('success', 'Analizele și fișierele au fost salvate cu succes!');
    // }
    public function store(Request $request)
    {
        $data = $request->all();
    
        // Transformăm checkbox-urile în boolean
        $checkboxFields = [
            'hemograma','proba_hemograma','vsh','coagulograma','hemostaza','proba_hemostaza',
            'mrs_hiv','proba_mrs_hiv','biochimia','proba_biochimia','colesterol_total','hdl_colesterol',
            'ldl_colesterol','trigliceride','ureea','creatina','afp','proba_afp','glucoza','alt','ast',
            'alfa_amilaza','fosfataza_alcalina','ldh','bilirubina_totala','bilirubina_directa','lipaza',
            'proteina_totala','albumina','acid_uric','ggt','magneziu','calciu','ferum','imunologia',
            'proba_imunologia','antistreptolizina_o','factor_reumatic','pcr','tt3','tt4','tsh','psa',
            'hbsag','proba_hbsag','hba1c','proba_hba1c','urograma','proba_urograma','coprologia',
            'proba_coprologia','helminti','sange_ocult'
        ];
    
        foreach ($checkboxFields as $field) {
            $data[$field] = $request->has($field);
        }
    
        $pacient_id = $request->pacient_id;
        $data_analizei = $request->input('data_analizei');
    
        // Verificăm dacă există deja o analiză pentru pacient și data respectivă
        $analizaExistenta = Laborator::where('pacient_id', $pacient_id)
            ->where('data_analizei', $data_analizei)
            ->first();
    
        if ($analizaExistenta) {
            // Dacă există, facem update
            $analizaExistenta->update($data);
            $analiza = $analizaExistenta;
        } else {
            // Dacă nu există, creăm un nou rând
            $data['pacient_id'] = $pacient_id;
            $data['data_analizei'] = $data_analizei;
            $analiza = Laborator::create($data);
        }
    
        // Gestionăm fișierele
        $fileFields = [
            'rezultat_hemograma_file' => 'hemograma',
            'rezultat_biochimia_file' => 'biochimia',
            'rezultat_imunologia_file' => 'imunologia',
            'rezultat_urograma_file' => 'urograma',
            'rezultat_coprologia_file' => 'coprologia'
        ];
    
        foreach ($fileFields as $fileField => $tip) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('analize', 'public');
                LaboratorFisier::create([
                    'laborator_id' => $analiza->id,
                    'tip_rezultat' => $tip,
                    'fisier' => $path,
                ]);
            }
        }
    
        // Verificăm dacă pacientul are toate procedurile
        $fieldsToCheck = ['hemograma','urograma','biochimia','imunologia','hba1c','hbsag','mrs_hiv','afp','hemostaza'];
        $areToate = collect($fieldsToCheck)->every(fn($f) => $request->has($f)) ? 1 : 0;
    
        // Sincronizare proceduri
        Procedura::updateOrCreate(
            ['pacient_id' => $pacient_id],
            array_merge($data, ['toate_procedurile' => $areToate])
        );
    
        return redirect()->route('laborator.create', ['pacient_id' => $pacient_id])
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
    public function storeMultiple(Request $request)
    {
        $labs = $request->input('labs', []); // preluăm toate analizele trimise

        foreach ($labs as $id => $data) {
            $lab = Laborator::find($id);
            if (!$lab) continue;

            // lista câmpurilor booleene
            $booleanFields = [
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
            ];

            // transformăm checkbox-urile în 0/1
            foreach ($booleanFields as $field) {
                $data[$field] = isset($data[$field]) && $data[$field] ? 1 : 0;
            }
            // if (isset($data['data_analizei']) && $data['data_analizei']) {
            //     $data['data_analizei'] = $data['data_analizei'];
            // }
            // salvăm fiecare analiză
            $lab->update($data);

            // Dacă vrei, poți actualiza și Procedura pentru fiecare pacient
            $fieldsProcedura = ['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'];
            $areToate = 1;
            foreach ($fieldsProcedura as $field) {
                if (empty($data[$field])) {
                    $areToate = 0;
                    break;
                }
            }

            Procedura::updateOrCreate(
                ['pacient_id' => $lab->pacient_id],
                array_merge(array_intersect_key($data, array_flip($fieldsProcedura)), ['toate_procedurile' => $areToate])
            );
        }

        return redirect()->back()->with('success', 'Modificările au fost salvate cu succes!');
    }
}
