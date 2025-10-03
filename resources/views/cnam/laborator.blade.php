@extends('layouts.app')
@section('title', 'Laborator | Forma')
@section('content')

    <div class="mb-3">
        {{-- Căutare pacient --}}
        <form method="GET" action="{{ route('laborator.create') }}" class="form-search">
            <input type="search" name="search" class="form-control" placeholder="Caută pacient după nume, prenume sau IDNP"
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Caută</button>
        </form>
        <div class="container-laborator" style="display: flex; justify-content: center; align-items: center;">
            @if ($prev_id)
                <a href="{{ route('laborator.create', ['pacient_id' => $prev_id, 'search' => request('search')]) }}"
                    class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left-long"></i>
                    precedent
                </a>
            @endif

            @if ($next_id)
                <a href="{{ route('laborator.create', ['pacient_id' => $next_id, 'search' => request('search')]) }}"
                    class="btn btn-secondary">
                    urmator
                    <i class="fa-solid fa-arrow-right-long"></i>

                </a>
            @endif
        </div>

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


        <div class="container-laborator">
            <h2>Laborator - Selectează pacient</h2>
            <form method="GET" action="{{ route('laborator.create') }}">
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
            </form>
            {{-- Căutare pacient --}}


            @if ($pacient_id)
                <hr>
                {{-- <p>Analize pentru: <b>{{ $pacienti->find($pacient_id)->numele }}
                        {{ $pacienti->find($pacient_id)->prenumele }}</b></p> --}}
                @if ($pacientSelectat)
                    <p>Analize pentru:
                        <b>{{ $pacientSelectat->numele }} {{ $pacientSelectat->prenumele }}</b>
                    </p>
                @else
                    <p><b>Niciun pacient selectat</b></p>
                @endif


                <span>cod: {{ $pacient_id }}</span>
                <span>data: {{ $analize?->created_at->format('d.m.Y') }}</span>

                <form method="POST" action="{{ route('laborator.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pacient_id" value="{{ $pacient_id }}">

                    {{-- HEMOGRAMA --}}
                    <div class="card mb-3">
                        <div class="card-header">Hemograma</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="hemograma" {{ $analize?->hemograma ? 'checked' : '' }}>
                                Hemograma</label><br>
                            <label><input type="checkbox" name="proba_hemograma"
                                    {{ $analize?->proba_hemograma ? 'checked' : '' }}> Proba Hemograma</label><br><br>
                            <label>Rezultat text:</label><br>
                            <textarea class="form-control" name="rezultat_hemograma_text">{{ $analize?->rezultat_hemograma_text }}</textarea>
                            <br><br>
                            <label>Rezultat fișier:</label>
                            <input type="file" class="form-control" name="rezultat_hemograma_file">
                            @if ($analize && $analize->fisiere->where('tip_rezultat', 'hemograma')->count())
                                <ul>
                                    @foreach ($analize->fisiere->where('tip_rezultat', 'hemograma') as $f)
                                        <li>
                                            @php
                                                $ext = pathinfo($f->fisier, PATHINFO_EXTENSION);
                                            @endphp

                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <img src="{{ asset('storage/' . $f->fisier) }}" width="200">
                                            @elseif(strtolower($ext) === 'pdf')
                                                {{-- <embed src="{{ asset('storage/'.$f->fisier) }}" type="application/pdf" width="100%" height="600px" /> --}}
                                                <br>
                                                <a href="{{ asset('storage/' . $f->fisier) }}" target="_blank">
                                                    Deschide PDF
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $f->fisier) }}"
                                                    target="_blank">{{ $f->fisier }}</a>
                                            @endif
                                            {{-- Buton ștergere --}}
                                            {{-- <form action="{{ route('laborator.fisiere.destroy', $f->id) }}" method="POST"
                                        class="ms-2">
                                        @csrf
                                        @method('DELETE') --}}
                                            <button class="btn-danger" data-id="{{ $f->id }}">
                                                delete
                                            </button>
                                            {{-- </form> --}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- VSH --}}
                    <div class="card mb-3">
                        <div class="card-header">VSH</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="vsh" {{ $analize?->vsh ? 'checked' : '' }}>
                                VSH</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_vsh_text">{{ $analize?->rezultat_vsh_text }}</textarea>
                        </div>
                    </div>

                    {{-- COAGULOGrama --}}
                    <div class="card mb-3">
                        <div class="card-header">Coagulograma</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="coagulograma"
                                    {{ $analize?->coagulograma ? 'checked' : '' }}>
                                Coagulograma</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_coagulograma_text">{{ $analize?->rezultat_coagulograma_text }}</textarea>
                        </div>
                    </div>

                    {{-- HEMOSTAZA --}}
                    <div class="card mb-3">
                        <div class="card-header">Hemostaza</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="hemostaza" {{ $analize?->hemostaza ? 'checked' : '' }}>
                                Hemostaza</label><br>
                            <label><input type="checkbox" name="proba_hemostaza"
                                    {{ $analize?->proba_hemostaza ? 'checked' : '' }}> Proba Hemostaza</label>
                        </div>
                    </div>

                    {{-- MRS HIV --}}
                    <div class="card mb-3">
                        <div class="card-header">MRS HIV</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="mrs_hiv" {{ $analize?->mrs_hiv ? 'checked' : '' }}> MRS
                                HIV</label><br>
                            <label><input type="checkbox" name="proba_mrs_hiv"
                                    {{ $analize?->proba_mrs_hiv ? 'checked' : '' }}>
                                Proba MRS HIV</label>
                        </div>
                    </div>

                    {{-- BIOCHIMIA --}}
                    <div class="card mb-3">
                        <div class="card-header">Biochimia</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="biochimia" {{ $analize?->biochimia ? 'checked' : '' }}>
                                Biochimia</label><br>
                            <label><input type="checkbox" name="proba_biochimia"
                                    {{ $analize?->proba_biochimia ? 'checked' : '' }}> Proba Biochimia</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_biochimia_text">{{ $analize?->rezultat_biochimia_text }}</textarea>
                            <label>Rezultat fișier (pdf/doc/img):</label>
                            <input type="file" class="form-control" name="rezultat_biochimia_file">
                            @if ($analize && $analize->fisiere->where('tip_rezultat', 'biochimia')->count())
                                <ul>
                                    @foreach ($analize->fisiere->where('tip_rezultat', 'biochimia') as $f)
                                        <li><a href="{{ asset('storage/' . $f->fisier) }}"
                                                target="_blank">{{ $f->fisier }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- BIOCHIMIE DETALIATĂ --}}
                    <div class="card mb-3">
                        <div class="card-header">Biochimie detaliată</div>
                        <div class="card-body">
                            @foreach (['colesterol_total' => 'Colesterol total', 'hdl_colesterol' => 'HDL-Colesterol', 'ldl_colesterol' => 'LDL-Colesterol', 'trigliceride' => 'Trigliceride', 'ureea' => 'Ureea', 'creatina' => 'Creatina'] as $field => $label)
                                <label><input type="checkbox" name="{{ $field }}"
                                        {{ $analize?->$field ? 'checked' : '' }}> {{ $label }}</label><br>
                            @endforeach
                        </div>
                    </div>

                    {{-- AFP --}}
                    <div class="card mb-3">
                        <div class="card-header">AFP</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="afp" {{ $analize?->afp ? 'checked' : '' }}>
                                AFP</label><br>
                            <label><input type="checkbox" name="proba_afp" {{ $analize?->proba_afp ? 'checked' : '' }}>
                                Proba
                                AFP</label>
                        </div>
                    </div>

                    {{-- ENZIME ȘI ALTELE --}}
                    <div class="card mb-3">
                        <div class="card-header">Enzime și altele</div>
                        <div class="card-body">
                            @foreach (['glucoza' => 'Glucoza', 'alt' => 'ALT', 'ast' => 'AST', 'alfa_amilaza' => 'Alfa-amilaza', 'fosfataza_alcalina' => 'Fosfataza alcalina', 'ldh' => 'LDH', 'bilirubina_totala' => 'Bilirubina totala', 'bilirubina_directa' => 'Bilirubina directa', 'lipaza' => 'Lipaza', 'proteina_totala' => 'Proteina totala', 'albumina' => 'Albumina (ser)', 'acid_uric' => 'Acid uric', 'ggt' => 'GGT', 'magneziu' => 'Magneziu', 'calciu' => 'Calciu', 'ferum' => 'Ferum'] as $field => $label)
                                <label><input type="checkbox" name="{{ $field }}"
                                        {{ $analize?->$field ? 'checked' : '' }}> {{ $label }}</label><br>
                            @endforeach
                        </div>
                    </div>

                    {{-- IMUNOLOGIA --}}
                    <div class="card mb-3">
                        <div class="card-header">Imunologia</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="imunologia" {{ $analize?->imunologia ? 'checked' : '' }}>
                                Imunologia</label><br>
                            <label><input type="checkbox" name="proba_imunologia"
                                    {{ $analize?->proba_imunologia ? 'checked' : '' }}> Proba Imunologia</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_imunologia_text">{{ $analize?->rezultat_imunologia_text }}</textarea>
                            <label>Rezultat fișier:</label>
                            <input type="file" class="form-control" name="rezultat_imunologia_file">
                            @if ($analize && $analize->fisiere->where('tip_rezultat', 'imunologia')->count())
                                <ul>
                                    @foreach ($analize->fisiere->where('tip_rezultat', 'imunologia') as $f)
                                        <li><a href="{{ asset('storage/' . $f->fisier) }}"
                                                target="_blank">{{ $f->fisier }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <hr>
                            @foreach (['antistreptolizina_o' => 'Antistreptolizina-O', 'factor_reumatic' => 'Factor reumatic', 'pcr' => 'PCR', 'tt3' => 'TT3', 'tt4' => 'TT4', 'tsh' => 'TSH', 'psa' => 'PSA'] as $field => $label)
                                <label><input type="checkbox" name="{{ $field }}"
                                        {{ $analize?->$field ? 'checked' : '' }}> {{ $label }}</label><br>
                            @endforeach
                        </div>
                    </div>

                    {{-- HBsAg --}}
                    <div class="card mb-3">
                        <div class="card-header">HBsAg</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="hbsag" {{ $analize?->hbsag ? 'checked' : '' }}>
                                HBsAg</label><br>
                            <label><input type="checkbox" name="proba_hbsag"
                                    {{ $analize?->proba_hbsag ? 'checked' : '' }}>
                                Proba HBsAg</label>
                        </div>
                    </div>

                    {{-- HbA1c --}}
                    <div class="card mb-3">
                        <div class="card-header">HbA1c</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="hba1c" {{ $analize?->hba1c ? 'checked' : '' }}>
                                HbA1c</label><br>
                            <label><input type="checkbox" name="proba_hba1c"
                                    {{ $analize?->proba_hba1c ? 'checked' : '' }}>
                                Proba HbA1c</label>
                        </div>
                    </div>

                    {{-- UROGRAMA --}}
                    <div class="card mb-3">
                        <div class="card-header">Urograma</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="urograma" {{ $analize?->urograma ? 'checked' : '' }}>
                                Urograma</label><br>
                            <label><input type="checkbox" name="proba_urograma"
                                    {{ $analize?->proba_urograma ? 'checked' : '' }}> Proba Urograma</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_urograma_text">{{ $analize?->rezultat_urograma_text }}</textarea>
                            <label>Rezultat fișier:</label>
                            <input type="file" class="form-control" name="rezultat_urograma_file">
                            @if ($analize && $analize->fisiere->where('tip_rezultat', 'urograma')->count())
                                <ul>
                                    @foreach ($analize->fisiere->where('tip_rezultat', 'urograma') as $f)
                                        <li><a href="{{ asset('storage/' . $f->fisier) }}"
                                                target="_blank">{{ $f->fisier }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- COPROLOGIA --}}
                    <div class="card mb-3">
                        <div class="card-header">Coprologia</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="coprologia" {{ $analize?->coprologia ? 'checked' : '' }}>
                                Coprologia</label><br>
                            <label><input type="checkbox" name="proba_coprologia"
                                    {{ $analize?->proba_coprologia ? 'checked' : '' }}> Proba Coprologia</label><br>
                            <label>Rezultat text:</label>
                            <textarea class="form-control" name="rezultat_coprologia_text">{{ $analize?->rezultat_coprologia_text }}</textarea>
                            <label>Rezultat fișier:</label>
                            <input type="file" class="form-control" name="rezultat_coprologia_file">
                            @if ($analize && $analize->fisiere->where('tip_rezultat', 'coprologia')->count())
                                <ul>
                                    @foreach ($analize->fisiere->where('tip_rezultat', 'coprologia') as $f)
                                        <li><a href="{{ asset('storage/' . $f->fisier) }}"
                                                target="_blank">{{ $f->fisier }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- ALTE ANALIZE --}}
                    <div class="card mb-3">
                        <div class="card-header">Altele</div>
                        <div class="card-body">
                            <label><input type="checkbox" name="helminti" {{ $analize?->helminti ? 'checked' : '' }}>
                                Helminți</label><br>
                            <label><input type="checkbox" name="sange_ocult"
                                    {{ $analize?->sange_ocult ? 'checked' : '' }}>
                                Sânge ocult</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Salvează</button>
                </form>
            @endif
        </div>
    @endsection
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
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // eliminăm elementul din DOM
                                const li = document.getElementById(`file-${fileId}`);
                                if (li) li.remove();
                            } else {
                                alert('Eroare la ștergere!');
                            }
                        })
                        .catch(error => {
                            console.error('Eroare:', error);
                            alert('Eroare la ștergere!');
                        });
                });
            });
        });

        // search
        // document.getElementById('search').addEventListener('keyup', function() {
        //     let query = this.value;
        //     fetch(`{{ route('laborator.create') }}?search=${query}`)
        //         .then(response => response.text())
        //         .then(html => {
        //             // Înlocuiește doar selectul cu lista de pacienți
        //             let parser = new DOMParser();
        //             let doc = parser.parseFromString(html, 'text/html');
        //             document.getElementById('pacient_id').innerHTML = doc.getElementById('pacient_id')
        //             .innerHTML;
        //         });
        // });

        //     document.addEventListener('DOMContentLoaded', function() {
        //     const searchForm = document.getElementById('searchForm');
        //     const pacientSelect = document.getElementById('pacient_id');

        //     searchForm.addEventListener('submit', function() {
        //         // folosim setTimeout ca să așteptăm ca pagina să se reîncarce și selectul să fie populat
        //         setTimeout(() => {
        //             if (pacientSelect.options.length > 2) { // mai mult de 1 opțiune + placeholder
        //                 pacientSelect.size = pacientSelect.options.length; // afișează toate opțiunile
        //                 pacientSelect.focus();
        //             }
        //         }, 100);
        //     });
        // });
    </script>





