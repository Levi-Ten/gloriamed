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
        // dd(123);
        $pacienti = Cnam::with('procedura')
            ->whereHas('procedura', function ($q) {
                // $q->where('toate_procedurile', 0);
                $q->where(function ($q1) {
                    $q1->where('hemograma', 1)
                        ->orWhere('urograma', 1)
                        ->orWhere('biochimia', 1)
                        ->orWhere('imunologia', 1)
                        ->orWhere('hba1c', 1)
                        ->orWhere('hbsag', 1)
                        ->orWhere('mrs_hiv', 1)
                        ->orWhere('afp', 1)
                        ->orWhere('hemostaza', 1);
                });
            })
            ->orWhereDoesntHave('procedura')
            ->orderByDesc('id')
            ->get();
        $columns = Schema::getColumnListing('proceduri');
        $ignore = ['id', 'pacient_id', 'data_procedurii', 'created_at', 'updated_at', 'toate_procedurile', 'data_analizei'];
        $analizeFields = array_diff($columns, $ignore);

        return view('cnam.proceduri', compact('pacienti', 'analizeFields'));
    }

    public function updateBulk(Request $request)
    {
        $proceduriData = $request->input('proceduri', []);

        foreach ($proceduriData as $pacientId => $fields) {
            $proc = Procedura::firstOrNew(['pacient_id' => $pacientId]);

            $fieldsToCheck = ['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'];
            $areToate = true;

            foreach ($fieldsToCheck as $field) {
                $value = isset($fields[$field]) ? true : false;
                $proc->$field = $value;

                if (!$value) {
                    $areToate = false;
                }
            }
            $proc->save();

            // sincronizare și în laborator
            Laborator::updateOrCreate(
                ['pacient_id' => $pacientId],
                [
                    'hemograma' => $proc->hemograma,
                    'urograma' => $proc->urograma,
                    'biochimia' => $proc->biochimia,
                    'imunologia' => $proc->imunologia,
                    'hba1c' => $proc->hba1c,
                    'hbsag' => $proc->hbsag,
                    'mrs_hiv' => $proc->mrs_hiv,
                    'afp' => $proc->afp,
                    'hemostaza' => $proc->hemostaza,
                ]
            );
        }

        return redirect()->back()->with('success', 'Procedurile au fost actualizate cu succes!');
    }

    public function destroy($id)
    {
        $proc = Procedura::find($id);
        if ($proc) {
            // Șterge procedura
            $proc->delete();
        }
        return redirect()->back()->with('success', 'Pacientul a fost șters!');
    }
    public function create(Request $request)
    {
        $pacienti = Cnam::all();
        $pacient_id = $request->get('pacient_id');

        $analize = $pacient_id
            ? Laborator::where('pacient_id', $pacient_id)->first()
            : null;
        $columns = Schema::getColumnListing('proceduri');
        $exclude = ['id', 'pacient_id', 'data_procedurii', 'created_at', 'updated_at', 'data_analizei'];
        $analizeFields = array_diff($columns, $exclude);

        return view('cnam.proceduri', compact('pacienti', 'pacient_id', 'analize', 'analizeFields'));
    }
}
