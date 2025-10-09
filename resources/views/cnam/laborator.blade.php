@extends('layouts.app')
@section('title', 'Laborator | Forma')
@section('content')
    <h2>Laborator</h2>
    <hr>
    <div class="mb-3">
        {{-- Căutare pacient --}}
        <h2>Caută pacient in lista generala</h2>
        <form method="GET" action="{{ route('laborator.create') }}" class="form-search mb-3">
            <input type="search" name="search" class="form-control" placeholder="Caută pacient după nume, prenume sau IDNP"
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary mt-2">Caută</button>
        </form>
        <br>
        {{-- 🔍 Căutare pacienți care au deja analize --}}
        <h2>Caută pacient cu analize</h2>
        <form method="GET" action="{{ route('laborator.create') }}" class="form-search mb-3">
            <input type="text" name="search_analize" class="form-control"
                placeholder="Caută pacient cu analize (nume, prenume sau IDNP)" value="{{ request('search_analize') }}">
            <button type="submit" class="btn btn-primary mt-2">Caută</button>
        </form>
        @if (!empty($searchAnalize))
            @if ($pacientiCuAnalizeFiltrati->count())
                <div class="container-laborator">
                    <ul class="list-group mb-3">
                        @foreach ($pacientiCuAnalizeFiltrati as $p)
                            <li class="list-group-item">
                                <a href="{{ route('laborator.create', ['pacient_id' => $p->id]) }}">
                                    {{ $p->numele }} {{ $p->prenumele }} | {{ $p->idnp }} | {{ $p->data_analizei }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="container-laborator" style="text-align: center; color: red; font-weight: bold">
                    Nu există niciun pacient care să corespundă căutării.
                </div>
            @endif
        @endif

        {{-- Navigare pacient --}}
        {{-- <div class="form-search">
            @if ($prevDate)
                <a href="{{ route('laborator.create', ['pacient_id' => $pacient_id, 'data_analizei' => $prevDate]) }}"
                    class="btn btn-secondary me-2">
                    <i class="fa-solid fa-arrow-left-long"></i> Precedent
                </a>
            @endif
            @if ($next_id)
                <a href="{{ route('laborator.create', ['pacient_id' => $pacient_id, 'data_analizei' => $nextDate]) }}"
                    class="btn btn-secondary">
                    Următor <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            @endif
        </div> --}}

        @if (!$pacient_id && request('search'))
            @if ($pacienti->count())
                <div class="container-laborator">
                    <ul class="list-group mb-3">
                        @foreach ($pacienti as $p)
                            <li class="list-group-item">
                                <a href="{{ route('laborator.create', ['pacient_id' => $p->id]) }}">
                                    {{ $p->numele }} {{ $p->prenumele }} | {{ $p->idnp }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="container-laborator" style="text-align: center; color: red; font-weight: bold">
                    Nu există niciun pacient care să corespundă căutării.
                </div>
            @endif
        @endif

        {{-- Selectare pacient --}}
        <div class="container-laborator mb-3">


            <form method="GET" action="{{ route('laborator.create') }}" id="formDate">
                <div class="mb-3">
                    <label for="pacient_id" class="form-label">Pacient:</label>
                    <select name="pacient_id" id="pacient_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Alege pacient --</option>
                        @foreach ($pacienti as $p)
                            <option value="{{ $p->id }}" {{ $pacient_id == $p->id ? 'selected' : '' }}>
                                {{ $p->numele }} {{ $p->prenumele }} | {{ $p->idnp }}
                            </option>
                        @endforeach
                    </select>

                </div>
                {{-- </form>
            <form method="GET" action="{{ route('laborator.create') }}"> --}}
                <select name="date" id="date" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Alege data --</option>
                    @foreach ($a ?? [] as $analiza)
                        @php
                            $date = \Carbon\Carbon::parse($analiza->data_analizei)->format('Y-m-d');
                        @endphp
                        <option value="{{ $date }}"
                            {{ isset($data_analizei) && $data_analizei == $date ? 'selected' : '' }}>
                            {{ $date }}
                        </option>
                    @endforeach
                </select>

            </form>
        </div>
    </div>

    @if ($pacient_id)
        {{-- <div class="container-laborator"> --}}
        <form method="POST" action="{{ route('laborator.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pacient_id" value="{{ $pacient_id }}">

            <p>Analize pentru: <b>{{ $pacientSelectat->numele }} {{ $pacientSelectat->prenumele }}</b></p>
            <p>Cod pacient: <b> {{ $pacient_id }}</b></p>
            <br>
            <span>Data analizei: <b>{{ $data_analizei }}</b></span>
            <br>
            (selecteaza data analizei, daca nu este selectata, se va prelua automat data actuala)
            <input type="date" name="data_analizei" value="{{ old('data_analizei', date('Y-m-d')) }}" required>
            <br>
            <br>

            @php
                $analize_fields = [
                    'Hemograma' => [
                        'checked' => 'hemograma',
                        'text' => 'rezultat_hemograma_text',
                        'file' => 'hemograma',
                    ],
                    'Proba hemograma' => ['checked' => 'proba_hemograma'],
                    'VSH' => ['checked' => 'vsh', 'text' => 'rezultat_vsh_text'],
                    'Coagulograma' => ['checked' => 'coagulograma', 'text' => 'rezultat_coagulograma_text'],
                    'Hemostaza' => ['checked' => 'hemostaza'],
                    'Proba hemostaza' => ['checked' => 'proba_hemostaza'],
                    'MRS HIV' => ['checked' => 'mrs_hiv', 'proba' => 'proba_mrs_hiv'],
                    'Proba mrs hiv' => ['checked' => 'proba_mrs_hiv'],
                    'Biochimia' => [
                        'checked' => 'biochimia',
                        'text' => 'rezultat_biochimia_text',
                        'file' => 'biochimia',
                    ],
                    'Proba biochimia' => ['checked' => 'proba_biochimia'],
                    'Colesterol total' => ['checked' => 'coletotal'],
                    'HDL-colesterol' => ['checked' => 'hdlcoletotal'],
                    'LDL-colesterol' => ['checked' => 'ldlcoletotal'],
                    'Trigliceride' => ['checked' => 'trigliceride'],
                    'Uree' => ['checked' => 'uree'],
                    'Creatina' => ['checked' => 'creatina'],
                    'AFP' => ['checked' => 'afp'],
                    'Proba afp' => ['checked' => 'proba_afp'],
                    'Glucoza' => ['checked' => 'glucoza'],
                    'ALT' => ['checked' => 'alt'],
                    'AST' => ['checked' => 'ast'],
                    'Alfa-amilaza' => ['checked' => 'alfaamilaza'],
                    'Fosfataza alcalina' => ['checked' => 'fosfatazaalcalina'],
                    'LDH lactat dehidratat' => ['checked' => 'ldhlactatdehidratat'],
                    'Bilirubina totala' => ['checked' => 'bilirubinatotala'],
                    'Bilirubina directa' => ['checked' => 'bilirubinadirecta'],
                    'Lipaza' => ['checked' => 'lipaza'],
                    'Proteina tottala' => ['checked' => 'proteinatottala'],
                    'Albumina (ser)' => ['checked' => 'albumina'],
                    'Acid uric' => ['checked' => 'aciduric'],
                    'GGT' => ['checked' => 'ggt'],
                    'Magneziu' => ['checked' => 'magneziu'],
                    'Calciu' => ['checked' => 'calciu'],
                    'Ferum' => ['checked' => 'ferum'],

                    'Imunologia' => [
                        'checked' => 'imunologia',
                        'text' => 'rezultat_imunologia_text',
                        'file' => 'imunologia',
                    ],
                    'Proba imunologia' => ['checked' => 'proba_imunologia'],
                    'Antistreptolizina-O' => ['checked' => 'antistreptolizinao'],
                    'Factor reumatic' => ['checked' => 'factorreumatic'],
                    'PCR' => ['checked' => 'pcr'],
                    'TT3' => ['checked' => 'tt3'],
                    'TT4' => ['checked' => 'tt4'],
                    'TSH' => ['checked' => 'tsh'],
                    'PSA' => ['checked' => 'psa'],
                    'HBsAg' => ['checked' => 'hbsag'],
                    'Proba HBsAg' => ['checked' => 'proba_hbsag'],
                    'HbA1c' => ['checked' => 'hba1c'],
                    'Proba HbA1c' => ['checked' => 'proba_hba1c'],

                    'Urograma' => ['checked' => 'urograma', 'text' => 'rezultat_urograma_text', 'file' => 'urograma'],
                    'Proba urograma' => ['checked' => 'proba_urograma'],
                    'Coprologia' => [
                        'checked' => 'coprologia',
                        'text' => 'rezultat_coprologia_text',
                        'file' => 'coprologia',
                    ],
                    'Proba coprologia' => ['checked' => 'proba_coprologia'],
                    'Helminti' => ['checked' => 'helminti'],
                    'Sange ocult' => ['checked' => 'sangeocult'],
                    // 'HBsAg' => ['checked'=>'hbsag','text'=>'rezultat_hbsag_text'],
                    // 'HbA1c' => ['checked'=>'hbA1c','text'=>'rezultat_hbA1c_text'],
                ];
            @endphp

            <table border="1" class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Câmp</th>
                        @foreach ($analize_fields as $analiza => $field)
                            <th>{{ $analiza }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- Checkbox realizată --}}
                    <tr>
                        <td>Realizată</td>
                        @foreach ($analize_fields as $analiza => $field)
                            <td>
                                @if (isset($field['checked']))
                                    <input type="checkbox" name="{{ $field['checked'] }}"
                                        {{ $analize?->{$field['checked']} ? 'checked' : '' }}>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Rezultat text</td>
                        @foreach ($analize_fields as $analiza => $field)
                            <td>
                                @if (isset($field['text']))
                                    <textarea class="form-control" name="{{ $field['text'] }}">{{ $analize?->{$field['text']} }}</textarea>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    {{-- Rezultat fișier --}}
                    <tr>
                        <td>Rezultat fișier</td>
                        @foreach ($analize_fields as $analiza => $field)
                            <td>
                                @if (isset($field['file']))
                                    <input type="file" class="form-control" name="rezultat_{{ $field['file'] }}_file">
                                    @if ($analize && $analize->fisiere->where('tip_rezultat', $field['file'])->count())
                                        <ul>
                                            @foreach ($analize->fisiere->where('tip_rezultat', $field['file']) as $f)
                                                <br>
                                                <li id="file-{{ $f->id }}">
                                                    {{-- <a href="{{ asset('storage/' . $f->fisier) }}"
                                                        target="_blank">{{ $f->fisier }}</a> --}}
                                                    <span
                                                        style="border-right: 1px solid grey; padding-right: 5px">{{ $f->created_at->format('Y-m-d') }}</span>
                                                    <a href="{{ asset('storage/' . $f->fisier) }}" target="_blank"
                                                        style="border-right: 1px solid grey">
                                                        <i class="fa-solid fa-file-pdf" title="click pentru vizualizare"
                                                            style="font-size: 25px"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm delete-file"
                                                        data-id="{{ $f->id }}">Șterge</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <br>
            <button type="submit" class="btn btn-primary mt-2">Salvează</button>
        </form>
        <br>
        {{-- </div> --}}
    @endif
    <hr>
    <br>
    <table border="1" width="100%" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pacient</th>
                @foreach ($columns as $col)
                    @if (!in_array($col, ['id', 'pacient_id', 'created_at', 'updated_at']))
                        <th>{{ ucfirst(str_replace('_', ' ', $col)) }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($laborator as $lab)
                <tr>
                    <td>{{ $lab->id }}</td>
                    <td>{{ $lab->pacient->numele }} {{ $lab->pacient->prenumele }}</td>
                    @foreach ($columns as $col)
                        @if (!in_array($col, ['id', 'pacient_id', 'created_at', 'updated_at']))
                            <td>
                                @php $value = $lab->$col; @endphp
                                @if (is_bool($value) || in_array($value, [0, 1]))
                                    {!! $value ? '✅' : '❌' !!}
                                @elseif ($value instanceof \Carbon\Carbon || strtotime($value))
                                    {{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $laborator->links() }}

    <div class="pagination-container">
        {{ $laborator->links() }}
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-file');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-id');
                    if (!confirm('Sigur vrei să ștergi acest fișier?')) return;

                    fetch(`/laborator/fisiere/${fileId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const li = document.getElementById(`file-${fileId}`);
                                if (li) li.remove();
                            } else {
                                alert('Eroare la ștergere!');
                            }
                        }).catch(err => {
                            alert('Eroare la ștergere!');
                            console.error(err);
                        });
                });
            });
        });
    </script>

@endsection
