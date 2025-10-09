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
        $records = Cnam::all();
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
    public function store(Request $request)
    {
        $request->validate([
            'numele' => 'required|string|max:255',
            'prenumele' => 'required|string|max:255',
            'data_nasterii' => 'required|date',
            'idnp' => 'required|string|max:20|unique:cnam',
        ]);

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
            'idnp' => 'required|string|max:20|unique:cnam,idnp,' . $cnam->id,
        ]);

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
}
