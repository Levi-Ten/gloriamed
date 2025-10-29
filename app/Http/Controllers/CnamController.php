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
        $request->validate(
            [
                'numele' => 'required|string|max:255',
                'prenumele' => 'required|string|max:255',
                'data_nasterii' => 'required|date',
                // 'idnp' => 'required|string|max:20|unique:cnam',
                'idnp' => 'required|regex:/^[0-9]{13}$/|unique:cnam,idnp,' . $cnam->id,
            ],
            [
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
        $request->validate(
            [
                'numele' => 'required|string|max:255',
                'prenumele' => 'required|string|max:255',
                'data_nasterii' => 'required|date',
                'idnp' => 'required|regex:/^[0-9]{13}$/|unique:cnam,idnp,' . $cnam->id,
            ],
            [
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
        $search = $request->get('search');
        $search_date = $request->get('search_date');

        // 🔹 Normalizează data (dacă e selectată)
        if ($search_date) {
            $search_date = \Carbon\Carbon::parse($search_date)->toDateString();
        }

        // 🔹 Inițializăm colecția goală
        $analize = collect();

        // 🔹 Dacă există search sau search_date, atunci căutăm analize
        if ($search_date || $search) {
            $analize = Laborator::query()
                ->with('pacient')
                ->when($search_date, function ($query, $search_date) {
                    $query->whereDate('data_analizei', $search_date);
                })
                ->when($search, function ($query, $search) {
                    $query->whereHas('pacient', function ($q) use ($search) {
                        $q->where('numele', 'like', "%{$search}%")
                            ->orWhere('prenumele', 'like', "%{$search}%")
                            ->orWhere('idnp', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(numele, ' ', prenumele) LIKE ?", ["%{$search}%"]);
                    });
                })
                ->orderBy('data_analizei', 'desc')
                ->get();
        }

        // 🔹 Lista pacienților (pentru dropdown sau select, dacă e nevoie)
        $pacienti = Cnam::select('id', 'numele', 'prenumele', 'idnp')
            ->orderBy('numele')
            ->get();

        return view('cnam.dareaDeSeama', compact('analize', 'pacienti', 'search', 'search_date'));
    }


    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        if (!$query) {
            return response()->json(['message' => 'Introduceți un text pentru căutare.'], 400);
        }

        // Transformăm căutarea în litere mici pentru compatibilitate
        $queryLower = mb_strtolower($query);

        // Căutăm potriviri multiple: nume, prenume, combinație nume+prenume, idnp
        $records = \App\Models\Cnam::whereRaw('LOWER(numele) LIKE ?', ["%{$queryLower}%"])
            ->orWhereRaw('LOWER(prenumele) LIKE ?', ["%{$queryLower}%"])
            ->orWhereRaw("LOWER(CONCAT(numele, ' ', prenumele)) LIKE ?", ["%{$queryLower}%"])
            ->orWhereRaw("LOWER(CONCAT(prenumele, ' ', numele)) LIKE ?", ["%{$queryLower}%"])
            ->orWhere('idnp', 'like', "%{$query}%")
            ->orderBy('numele')
            ->limit(10)
            ->get();

        if ($records->isNotEmpty()) {
            return response()->json($records);
        } else {
            return response()->json(['message' => 'Nu a fost găsit niciun pacient.'], 404);
        }
    }
}
