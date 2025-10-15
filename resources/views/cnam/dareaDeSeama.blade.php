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

                @if ($dateDisponibile->count())
                    <div class="col-md-4">
                        <label for="data_analizei" class="form-label">Data analizei</label>
                        <select name="data_analizei" id="data_analizei" class="form-select" onchange="this.form.submit()">
                            <option value="">Selectează data</option>
                            @foreach ($dateDisponibile as $data)
                                <option value="{{ $data->data_analizei }}"
                                    {{ $data_analizei == $data->data_analizei ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($data->data_analizei)->format('d.m.Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </form>

        {{-- Afișare rezultate --}}
        @if ($analize->count())
            @php $a = $analize->first(); @endphp
            <div class="table-responsive">
                <div class="analize">
                    <div class="analiza_columns">
                        {{-- Hemograma --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Hemograma</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->hemograma ? 'checked' : '' }}>
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox" {{ $a->proba_hemograma ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col">{{ $a->rezultat_hemograma_text ?? '' }}</div> --}}
                        </div>

                        {{-- VSH --}}
                        <div class="analiza-row">
                            <div class="analiza-col">VSH</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->vsh ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div> --}}
                            {{-- <div class="analiza-col">{{ $a->rezultat_vsh_text ?? '' }}</div> --}}
                        </div>

                        {{-- Coagulograma --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Coagulograma</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->coagulograma ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col"></div> --}}
                            {{-- <div class="analiza-col">{{ $a->rezultat_coagulograma_text ?? '' }}</div> --}}
                        </div>

                        {{-- Urograma --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Urograma</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->urograma ? 'checked' : '' }} >
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox" {{ $a->proba_urograma ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col">{{ $a->rezultat_urograma_text ?? '' }}</div> --}}
                        </div>
                    </div>
                    <div class="analiza_columns">
                        {{-- Imunologia --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Imunologia</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->imunologia ? 'checked' : '' }} >
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox" {{ $a->proba_imunologia ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col">{{ $a->rezultat_imunologia_text ?? '' }}</div> --}}
                        </div>

                        {{-- Subdetalii Imunologie --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Antistreptolizina O</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->antistreptolizina_o ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">Factor reumatic</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->factor_reumatic ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">PCR</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->pcr ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">TT3</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->tt3 ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">TT4</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->tt4 ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">TSH</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->tsh ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">PSA</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->psa ? 'checked' : '' }} ></div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>

                        {{-- HbA1c --}}
                        <div class="analiza-row">
                            <div class="analiza-col">HbA1c</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->hba1c ? 'checked' : '' }} >
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox" {{ $a->proba_hba1c ? 'checked' : '' }}
                                    >
                            </div>
                            {{-- <div class="analiza-col"></div> --}}
                        </div>
                    </div>
                    <div class="analiza_column">
                        {{-- Biochimia --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Biochimia</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->biochimia ? 'checked' : '' }}
                                    >
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox"
                                    {{ $a->proba_biochimia ? 'checked' : '' }} ></div>

                            {{-- <div class="analiza-col">{{ $a->rezultat_biochimia_text ?? '' }}</div> --}}
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
                                {{-- <div class="analiza_column2"> --}}
                                <div class="analiza-col">{{ $label }}</div>
                                <div class="analiza-col"><input type="checkbox" {{ $a->$field ? 'checked' : '' }} >
                                </div>
                                {{-- </div> --}}
                                {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                            </div>
                        @endforeach
                    </div>
                    <div class="analiza_columns">
                        {{-- Coprologia --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Coprologia</div>
                            {{-- <div class="analiza-col"><input type="checkbox" {{ $a->coprologia ? 'checked' : '' }}
                                    >
                            </div> --}}
                            <div class="analiza-col"><input type="checkbox" {{ $a->proba_coprologia ? 'checked' : '' }}
                                    ></div>
                            {{-- <div class="analiza-col">{{ $a->rezultat_coprologia_text ?? '' }}</div> --}}
                        </div>

                        {{-- Diverse --}}
                        <div class="analiza-row">
                            <div class="analiza-col">Helminți</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->helminti ? 'checked' : '' }} >
                            </div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                        <div class="analiza-row">
                            <div class="analiza-col">Sânge ocult</div>
                            <div class="analiza-col"><input type="checkbox" {{ $a->sange_ocult ? 'checked' : '' }}
                                    >
                            </div>
                            {{-- <div class="analiza-col"></div>
                            <div class="analiza-col"></div> --}}
                        </div>
                    </div>
                </div>

            </div>
        @elseif($pacient_id && !$analize->count())
            <div class="alert alert-warning">Nu există analize pentru această dată.</div>
        @endif
    </div>
@endsection
