@extends('layouts.app')

@section('title', 'Lista pacientilor CNAM')

@section('content')

    <div class="container">
        <h2>Lista pacienți CNAM</h2>
        <br><br>
        @error('idnp')
            <div style="color: red">
                {{ $message }}
            </div>
        @enderror

        <div style="margin: 20px 0;">
            <input type="search" id="searchInput" placeholder="Caută pacient după nume, prenume sau IDNP" class="form-control"
                style="width: 30%">
            <button id="searchBtn" class="btn btn-primary mt-2">Caută</button>
        </div>
        {{-- Modal pentru afișarea informațiilor pacientului --}}
        <div id="patientModal" class="modal hidden">
            <div class="modal-content">
                <span id="closeModal" class="close">X</span>
                <h3>Detalii pacient</h3>
                <div id="modalBody"></div>
            </div>
        </div>

        <table class="patients-table" id="patientsTable" border="1">
            <thead>
                <tr>
                    <th>Cod</th>
                    <th>Nume <span style="color: red">*</span></th>
                    <th>Prenume <span style="color: red">*</span></th>
                    <th>Data nașterii <span style="color: red">*</span></th>
                    <th>IDNP <span style="color: red">*</span></th>
                    <th>Localitate</th>
                    <th>Sector</th>
                    <th>Stradă</th>
                    <th>Casă</th>
                    <th>Bloc</th>
                    <th>Apartament</th>
                    <th>Full Info</th>
                    <th>Acțiuni</th>
                    <th><i class="fa-solid fa-info"></i></th>
                </tr>
            </thead>

            <tbody id="patientsBody">
                @foreach ($records as $r)
                    <tr>
                        <form method="POST" action="{{ route('cnam.update', $r->id) }}">
                            @csrf
                            @method('PUT')
                            <td>{{ $r->id }}</td>
                            <td><input class="input-field" type="text" name="numele" value="{{ $r->numele }}"
                                    required></td>
                            <td><input class="input-field" type="text" name="prenumele" value="{{ $r->prenumele }}"
                                    required></td>
                            <td><input class="input-field" type="date" name="data_nasterii"
                                    value="{{ $r->data_nasterii }}" required></td>
                            <td>
                                <input class="input-field" type="text" name="idnp"
                                    value="{{ $r->idnp }}"required>
                            </td>

                            <td><input class="input-field" type="text" name="localitatea" value="{{ $r->localitatea }}"
                                    style="width:60px;">
                            </td>
                            <td><input class="input-field" type="text" name="sectorul" value="{{ $r->sectorul }}"
                                    style="width:60px;"></td>
                            <td><input class="input-field" type="text" name="strada" value="{{ $r->strada }}"
                                    style="width:60px;"></td>
                            <td><input class="input-small" type="text" name="casa" value="{{ $r->casa }}"
                                    style="width:60px;"></td>
                            <td><input class="input-small" type="text" name="blocul" value="{{ $r->blocul }}"
                                    style="width:60px;"></td>
                            <td><input class="input-small" type="text" name="apartamentul"
                                    value="{{ $r->apartamentul }}" style="width:60px;"></td>
                            <td>
                                {{-- <input class="input-field readonly" type="text" value="{{ $r->full_info }}" readonly> --}}
                                <input class="input-field readonly" type="text" value="{{ $r->full_info }}" readonly
                                    style="width: {{ strlen($r->full_info) + 1 }}ch;">
                            </td>
                            <td class="actions">
                                <button type="submit" class="">💾 Salvează</button>
                        </form>
                        <form method="POST" action="{{ route('cnam.destroy', $r->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class=""
                                onclick="return confirm('Ești sigur că vrei să ștergi?')">🗑 Șterge</button>
                        </form>
                        </td>
                        <td><i class="fa-solid fa-circle-info"
                                title="Adăugat: {{ $r->created_at }}&#10;Editat: {{ $r->updated_at }}"></i></td>
                    </tr>
                @endforeach
            </tbody>
            <!-- Rând nou pentru adăugare -->
            <tr id="newPatientRow" class="new-row hidden">
                <form method="POST" action="{{ route('cnam.store') }}" id="cnamForm">
                    @csrf
                    <td>—</td>
                    <td><input class="input-field" type="text" name="numele" required></td>
                    <td><input class="input-field" type="text" name="prenumele" required></td>
                    <td><input class="input-field" type="date" name="data_nasterii" required></td>
                    <td>
                        <input class="input-field" type="text" name="idnp" id="idnp1" required>
                        <span id="charCount"></span>
                    </td>
                    <td><input class="input-field" type="text" name="localitatea" style="width:60px;"></td>
                    <td><input class="input-field" type="text" name="sectorul" style="width:60px;"></td>
                    <td><input class="input-field" type="text" name="strada" style="width:60px;"></td>
                    <td><input class="input-small" type="text" name="casa" style="width:60px;"></td>
                    <td><input class="input-small" type="text" name="blocul" style="width:60px;"></td>
                    <td><input class="input-small" type="text" name="apartamentul" style="width:60px;"></td>
                    <td><input class="input-field readonly" type="text" readonly placeholder="—"></td>
                    <td class="actions">
                        <button type="submit" class="">💾 Salvează</button>
                        {{-- <button type="button" id="cancelAddBtn" class="">🗑 Șterge</button> --}}
                    </td>
                    <td></td>
                </form>
            </tr>
        </table>


        <!-- Script -->
        <script>
            document.getElementById('searchBtn').addEventListener('click', function() {
                const query = document.getElementById('searchInput').value.trim();
                if (!query) return alert("Introduceți numele pacientului!");

                fetch(`{{ route('cnam.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            document.getElementById('modalBody').innerHTML =
                                `<p style="color:red;">${data.message}</p>`;
                        } else {
                            let html = '';
                            data.forEach(p => {
                                html += `
                    <div style="border-bottom:1px solid #ccc; margin-bottom:10px; padding-bottom:5px;">
                        <p style="display:flex;"><strong>Nume:</strong> ${p.numele}</p>
                        <p style="display:flex;"><strong>Prenume:</strong> ${p.prenumele}</p>
                        <p style="display:flex;"><strong>Data nașterii:</strong> ${p.data_nasterii}</p>
                        <p style="display:flex;"><strong>IDNP:</strong> ${p.idnp}</p>
                        <p style="display:flex;"><strong>Adresa:</strong> ${p.localitatea || ''}, ${p.strada || ''}, ${p.casa || ''}</p>
                        <p style="display:flex;"><strong>Full Info:</strong> ${p.full_info || '-'}</p>
                    </div>`;
                            });
                            document.getElementById('modalBody').innerHTML = html;
                        }
                        document.getElementById('patientModal').style.display = 'block';
                    })

            });

            // Închidere modal
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('patientModal').style.display = 'none';
            });

            // Închide modal la click în afara ferestrei
            window.addEventListener('click', function(e) {
                if (e.target === document.getElementById('patientModal')) {
                    document.getElementById('patientModal').style.display = 'none';
                }
            });


            const input = document.getElementById('idnp1');
            const charCount = document.getElementById('charCount');

            input.addEventListener('input', () => {
                if (input.value.length > 13) {
                    charCount.textContent = "prea multe caractere";

                } else {
                    charCount.textContent = input.value.length;
                }
            });

            document.getElementById('addPatientBtn').addEventListener('click', function() {
                document.getElementById('newPatientRow').classList.remove('hidden');
                this.disabled = true;
            });

            document.getElementById('cancelAddBtn').addEventListener('click', function() {
                document.getElementById('newPatientRow').classList.add('hidden');
                document.getElementById('addPatientBtn').disabled = false;
            });
        </script>

    </div>
@endsection
