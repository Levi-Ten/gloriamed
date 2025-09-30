<?php

namespace App\Http\Controllers;

use App\Models\Cnam;
use App\Models\Procedura;
use App\Models\Laborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProceduraController extends Controller
{
    public function index()
    {
        $proceduri = Procedura::with('pacient')->get(); // grupează toate procedurile pe pacient

        return view('cnam.proceduriShow', compact('proceduri'));
    }

    // public function create()
    // {
    //     $pacienti = Cnam::all();
    //     return view('cnam.proceduri', compact('pacienti'));
    // }

    public function create(Request $request)
    {
        $pacienti = Cnam::all();
        $pacient_id = $request->get('pacient_id');

        $analize = $pacient_id
            ? Laborator::where('pacient_id', $pacient_id)->first()
            : null;

        // Preluăm coloanele dinamice (analizele)
        $columns = Schema::getColumnListing('proceduri');
        $exclude = ['id', 'pacient_id', 'created_at', 'updated_at'];
        $analizeFields = array_diff($columns, $exclude);

        return view('cnam.proceduri', compact('pacienti', 'pacient_id', 'analize', 'analizeFields'));
    }
    public function store(Request $request)
{
    $data = $request->all();

    // transformăm checkboxurile în boolean
    foreach (['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'] as $field) {
        $data[$field] = $request->has($field);
    }

    // salvăm sau actualizăm procedura
    $procedura = Procedura::updateOrCreate(
        ['pacient_id' => $request->pacient_id], // criteriu de căutare
        $data // datele de actualizat
    );

    // actualizăm și în laborator
    Laborator::updateOrCreate(
        ['pacient_id' => $request->pacient_id],
        [
            'hemograma'   => $data['hemograma'],
            'urograma'    => $data['urograma'],
            'biochimia'   => $data['biochimia'],
            'imunologia'  => $data['imunologia'],
            'hba1c'       => $data['hba1c'],
            'hbsag'       => $data['hbsag'],
            'mrs_hiv'     => $data['mrs_hiv'],
            'afp'         => $data['afp'],
            'hemostaza'   => $data['hemostaza'],
        ]
    );

    return redirect()->route('proceduri.create')->with('success', 'Procedura salvată și laborator actualizat!');
}

}
