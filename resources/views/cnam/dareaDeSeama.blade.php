@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Darea de seamă - Analize pacient</h3>

    {{-- Formular de selectare pacient + dată --}}
    <form method="GET" action="{{ route('cnam.dareaDeSeama') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="pacient_id" class="form-label">Pacient</label>
                <select name="pacient_id" id="pacient_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Selectează pacientul</option>
                    @foreach ($pacienti as $pacient)
                        <option value="{{ $pacient->id }}" {{ $pacient_id == $pacient->id ? 'selected' : '' }}>
                            {{ $pacient->numele }} {{ $pacient->prenumele }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($dateDisponibile->count())
                <div class="col-md-4">
                    <label for="data_analizei" class="form-label">Data analizei</label>
                    <select name="data_analizei" id="data_analizei" class="form-select" onchange="this.form.submit()">
                        <option value="">Selectează data</option>
                        @foreach ($dateDisponibile as $data)
                            <option value="{{ $data->data_analizei }}" {{ $data_analizei == $data->data_analizei ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($data->data_analizei)->format('d.m.Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </form>

    {{-- Afișare rezultate --}}
    @if($analize->count())
        @php $a = $analize->first(); @endphp
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Analiza</th>
                        <th>Are</th>
                        <th>Proba</th>
                        <th>Rezultat</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Hemograma --}}
                    <tr>
                        <td>Hemograma</td>
                        <td><input type="checkbox" {{ $a->hemograma ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_hemograma ? 'checked' : '' }} disabled></td>
                        <td>{{ $a->rezultat_hemograma_text ?? '' }}</td>
                    </tr>

                    {{-- VSH --}}
                    <tr>
                        <td>VSH</td>
                        <td><input type="checkbox" {{ $a->vsh ? 'checked' : '' }} disabled></td>
                        <td></td>
                        <td>{{ $a->rezultat_vsh_text ?? '' }}</td>
                    </tr>

                    {{-- Coagulograma --}}
                    <tr>
                        <td>Coagulograma</td>
                        <td><input type="checkbox" {{ $a->coagulograma ? 'checked' : '' }} disabled></td>
                        <td></td>
                        <td>{{ $a->rezultat_coagulograma_text ?? '' }}</td>
                    </tr>

                    {{-- Urograma --}}
                    <tr>
                        <td>Urograma</td>
                        <td><input type="checkbox" {{ $a->urograma ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_urograma ? 'checked' : '' }} disabled></td>
                        <td>{{ $a->rezultat_urograma_text ?? '' }}</td>
                    </tr>

                    {{-- Imunologia --}}
                    <tr>
                        <td>Imunologia</td>
                        <td><input type="checkbox" {{ $a->imunologia ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_imunologia ? 'checked' : '' }} disabled></td>
                        <td>{{ $a->rezultat_imunologia_text ?? '' }}</td>
                    </tr>

                    {{-- Subdetalii Imunologie --}}
                    <tr><td>Antistreptolizina O</td><td><input type="checkbox" {{ $a->antistreptolizina_o ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Factor reumatic</td><td><input type="checkbox" {{ $a->factor_reumatic ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>PCR</td><td><input type="checkbox" {{ $a->pcr ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>TT3</td><td><input type="checkbox" {{ $a->tt3 ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>TT4</td><td><input type="checkbox" {{ $a->tt4 ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>TSH</td><td><input type="checkbox" {{ $a->tsh ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>PSA</td><td><input type="checkbox" {{ $a->psa ? 'checked' : '' }} disabled></td><td></td><td></td></tr>

                    {{-- HbA1c --}}
                    <tr>
                        <td>HbA1c</td>
                        <td><input type="checkbox" {{ $a->hba1c ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_hba1c ? 'checked' : '' }} disabled></td>
                        <td></td>
                    </tr>

                    {{-- Biochimia --}}
                    <tr>
                        <td>Biochimia</td>
                        <td><input type="checkbox" {{ $a->biochimia ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_biochimia ? 'checked' : '' }} disabled></td>
                        <td>{{ $a->rezultat_biochimia_text ?? '' }}</td>
                    </tr>

                    {{-- Subdetalii Biochimie --}}
                    <tr><td>Magneziu</td><td><input type="checkbox" {{ $a->magneziu ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Calciu</td><td><input type="checkbox" {{ $a->calciu ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Ferum</td><td><input type="checkbox" {{ $a->ferum ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>AST</td><td><input type="checkbox" {{ $a->ast ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Alfa amilază</td><td><input type="checkbox" {{ $a->alfa_amilaza ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Lipază</td><td><input type="checkbox" {{ $a->lipaza ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Ureea</td><td><input type="checkbox" {{ $a->ureea ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Creatina</td><td><input type="checkbox" {{ $a->creatina ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>LDH</td><td><input type="checkbox" {{ $a->ldh ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Glucoza</td><td><input type="checkbox" {{ $a->glucoza ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Proteina totală</td><td><input type="checkbox" {{ $a->proteina_totala ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Albumina</td><td><input type="checkbox" {{ $a->albumina ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Trigliceride</td><td><input type="checkbox" {{ $a->trigliceride ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Colesterol total</td><td><input type="checkbox" {{ $a->colesterol_total ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>HDL Colesterol</td><td><input type="checkbox" {{ $a->hdl_colesterol ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>LDL Colesterol</td><td><input type="checkbox" {{ $a->ldl_colesterol ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Bilirubina directă</td><td><input type="checkbox" {{ $a->bilirubina_directa ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Acid uric</td><td><input type="checkbox" {{ $a->acid_uric ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>GGT</td><td><input type="checkbox" {{ $a->ggt ? 'checked' : '' }} disabled></td><td></td><td></td></tr>

                    {{-- Coprologia --}}
                    <tr>
                        <td>Coprologia</td>
                        <td><input type="checkbox" {{ $a->coprologia ? 'checked' : '' }} disabled></td>
                        <td><input type="checkbox" {{ $a->proba_coprologia ? 'checked' : '' }} disabled></td>
                        <td>{{ $a->rezultat_coprologia_text ?? '' }}</td>
                    </tr>

                    {{-- Diverse --}}
                    <tr><td>Helminți</td><td><input type="checkbox" {{ $a->helminti ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                    <tr><td>Sânge ocult</td><td><input type="checkbox" {{ $a->sange_ocult ? 'checked' : '' }} disabled></td><td></td><td></td></tr>
                </tbody>
            </table>
        </div>
    @elseif($pacient_id && !$analize->count())
        <div class="alert alert-warning">Nu există analize pentru această dată.</div>
    @endif
</div>
@endsection
