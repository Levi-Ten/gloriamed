<?php

namespace App\Http\Controllers;

use App\Models\Cnam;
use App\Models\Laborator;
use App\Models\Procedura;
use Illuminate\Http\Request;

class CnamController extends Controller
{
    /**
     * Afișează lista pacienților
     */
    public function index()
    {
        // $records = Cnam::all();
        $records = Cnam::orderBy('id', 'desc')->get();
        return view('cnam.index', compact('records'));
    }

    /**
     * Formular pentru adăugare pacient nou
     */
    public function create()
    {
        return view('cnam.create');
    }

    /**
     * Salvează un pacient nou
     */
    public function store(Request $request, Cnam $cnam)
    {
        $request->validate([
            'numele' => 'required|string|max:255',
            'prenumele' => 'required|string|max:255',
            'data_nasterii' => 'required|date',
            // 'idnp' => 'required|string|max:20|unique:cnam',
            'idnp' => 'required|regex:/^[0-9]{13}$/|unique:cnam,idnp,' . $cnam->id,
        ], [
            'idnp.unique' => 'Acest IDNP există deja în sistem.',
            'idnp.regex' => 'IDNP-ul trebuie sa fie format din 13 cifre',
            'idnp.required' => 'Câmpul IDNP este obligatoriu.',
        ]
    );

        Cnam::create($request->all());

        return redirect()->route('cnam.index')->with('success', 'Pacient adăugat cu succes!');
    }

    /**
     * Afișează detalii pacient
     */
    public function show(Cnam $cnam)
    {
        return view('cnam.show', compact('cnam'));
    }

    /**
     * Formular editare pacient
     */
    public function edit(Cnam $cnam)
    {
        return view('cnam.edit', compact('cnam'));
    }

    /**
     * Actualizează datele pacientului
     */
    public function update(Request $request, Cnam $cnam)
    {
        $request->validate([
            'numele' => 'required|string|max:255',
            'prenumele' => 'required|string|max:255',
            'data_nasterii' => 'required|date',
            'idnp' => 'required|regex:/^[0-9]{13}$/|unique:cnam,idnp,' . $cnam->id,
        ], [
            'idnp.unique' => 'Acest IDNP există deja în sistem.',
            'idnp.regex' => 'IDNP-ul trebuie sa fie format din 13 cifre',
            'idnp.required' => 'Câmpul IDNP este obligatoriu.',
        ]
    
    );

        $cnam->update($request->all());

        return redirect()->route('cnam.index')->with('success', 'Date actualizate cu succes!');
    }

    /**
     * Șterge pacient
     */
    public function destroy(Cnam $cnam)
    {
        Laborator::where('pacient_id', $cnam->id)->delete();
        Procedura::where('pacient_id', $cnam->id)->delete();
        $cnam->delete();
        return redirect()->route('cnam.index')->with('success', 'Pacient șters cu succes!');
    }
    public function __construct()
    {
        $this->middleware('auth.cnam');
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        });
    }
    public function dareaDeSeama(Request $request)
    {
        // Toți pacienții din baza de date CNAM
        $pacienti = Cnam::select('id', 'numele', 'prenumele', 'idnp')->orderBy('numele')->get();

        // Pacientul selectat
        $pacient_id = $request->get('pacient_id');
        $pacientSelectat = $pacient_id ? Cnam::find($pacient_id) : null;

        // Datele disponibile pentru pacientul selectat
        $dateDisponibile = collect();
        if ($pacient_id) {
            $dateDisponibile = Laborator::where('pacient_id', $pacient_id)
                ->select('data_analizei')
                ->distinct()
                ->orderBy('data_analizei', 'desc')
                ->get();
        }

        // Data selectată
        $data_analizei = $request->get('data_analizei');

        // Analizele efective
        $analize = collect();
        if ($pacient_id && $data_analizei) {
            $analize = Laborator::where('pacient_id', $pacient_id)
                ->whereDate('data_analizei', $data_analizei)
                ->get();
        }
        // dd($analize);
        return view('cnam.dareaDeSeama', compact(
            'pacienti',
            'pacientSelectat',
            'pacient_id',
            'dateDisponibile',
            'data_analizei',
            'analize'
        ));
    }



    public function getDates($pacientId)
    {
        // Extrage datele distincte pentru care există analize
        $dates = Laborator::where('pacient_id', $pacientId)
            ->select('data_analiza')
            ->distinct()
            ->orderBy('data_analiza', 'desc')
            ->get();

        return response()->json($dates);
    }


    public function getAnalize($pacientId, $data)
    {
        $analize = Laborator::where('pacient_id', $pacientId)
            ->where('data_analiza', $data)
            ->get(['nume_analiza', 'rezultat', 'activ']);

        return response()->json($analize);
    }
}
