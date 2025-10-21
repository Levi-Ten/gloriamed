@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4 text-center">Darea de seamă - Analize pacient</h3>
        <br>
        {{-- Formular de selectare pacient + dată --}}
        <form method="GET" action="{{ route('cnam.dareaDeSeama') }}" class="mb-4">
            <div class="row g-3 align-items-end">

                {{-- Căutare opțională --}}
                <div class="col-md-4">
                    <label for="search" class="form-label">Caută pacient</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Caută pacient după nume, prenume sau IDNP" value="{{ request('search') }}"
                            style="width: 30%">
                        <button class="btn btn-primary" type="submit">Caută</button>
                    </div>
                </div>
                <hr>
                {{-- Selectare dată --}}
                <label for="search" class="form-label">Caută pacient după data</label>
                <input type="date" name="search_date" id="search_date" value="{{ request('search_date') }}"
                    onchange="this.form.submit()" style="font-size: 20px" title="Click pentru a scri o data">
                <br>
                <br>
            </div>
        </form>

        {{-- Afișare rezultate --}}
        @if ($analize->count())
            @foreach ($analize->groupBy('pacient_id') as $pacientId => $analizePacient)
                <div>
                    @php
                        $pacient = $analizePacient->first()->pacient;
                        $primaAnaliza = $analizePacient->first();
                    @endphp

                    <div class="card-header bg-primary text-white">
                        <strong>{{ $pacient->numele ?? '' }} {{ $pacient->prenumele ?? '' }}</strong>
                        <span class="float-end">
                            {{-- ID: {{ $primaAnaliza->id }} | --}}
                            <span class="float-end">| IDNP: {{ $pacient->idnp ?? '' }}</span>
                            | Data: {{ \Carbon\Carbon::parse($primaAnaliza->data_analizei)->format('d-m-Y') }}
                        </span>
                    </div>
                    <br>
                    @foreach ($analizePacient as $a)
                        <div class="analiza-row mb-2">
                            <div class="analiza-col"><strong>ID Analiză:</strong> {{ $a->id }}</div>
                            <div class="analiza-col"><strong>Data Analizei:</strong>
                                {{ \Carbon\Carbon::parse($a->data_analizei)->format('d-m-Y') }}</div>
                        </div>
                        <div class="table-responsive">
                            <div class="analize">
                                <div class="analiza_columns">
                                    {{-- Hemograma --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Hemograma</div>

                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_hemograma ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- VSH --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">VSH</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->vsh ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- Coagulograma --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Coagulograma</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->coagulograma ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- Urograma --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Urograma</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_urograma ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="analiza_columns">
                                    {{-- Imunologia --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Imunologia</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_imunologia ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- Subdetalii Imunologie --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Antistreptolizina O</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->antistreptolizina_o ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">Factor reumatic</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->factor_reumatic ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">PCR</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->pcr ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">TT3</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->tt3 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">TT4</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->tt4 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">TSH</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->tsh ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">PSA</div>
                                        <div class="analiza-col"><input type="checkbox" {{ $a->psa ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- HbA1c --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">HbA1c</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_hba1c ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="analiza_column">
                                    {{-- Biochimia --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Biochimia</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_biochimia ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    {{-- Subdetalii Biochimie --}}
                                    @foreach ([
            'Magneziu' => 'magneziu',
            'Calciu' => 'calciu',
            'Ferum' => 'ferum',
            'AST' => 'ast',
            'Alfa amilază' => 'alfa_amilaza',
            'Lipază' => 'lipaza',
            'Ureea' => 'ureea',
            'Creatina' => 'creatina',
            'LDH' => 'ldh',
            'Glucoza' => 'glucoza',
            'Proteina totală' => 'proteina_totala',
            'Albumina' => 'albumina',
            'Trigliceride' => 'trigliceride',
            'Colesterol total' => 'colesterol_total',
            'HDL Colesterol' => 'hdl_colesterol',
            'LDL Colesterol' => 'ldl_colesterol',
            'Bilirubina directă' => 'bilirubina_directa',
            'Acid uric' => 'acid_uric',
            'GGT' => 'ggt',
        ] as $label => $field)
                                        <div class="analiza-row">
                                            <div class="analiza-col">{{ $label }}</div>
                                            <div class="analiza-col"><input type="checkbox"
                                                    {{ $a->$field ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="analiza_columns">
                                    {{-- Coprologia --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Coprologia</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->proba_coprologia ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    {{-- Diverse --}}
                                    <div class="analiza-row">
                                        <div class="analiza-col">Helminți</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->helminti ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="analiza-row">
                                        <div class="analiza-col">Sânge ocult</div>
                                        <div class="analiza-col"><input type="checkbox"
                                                {{ $a->sange_ocult ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
    </div>
    @endforeach
@elseif(request('search_date') && !$analize->count())
    <div class="alert alert-warning">Nu există analize pentru această dată.</div>
    @endif
    </div>
@endsection
