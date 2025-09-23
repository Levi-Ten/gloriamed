<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gloriamed</title>
    <link rel="icon" type="image/png" sizes="84x84" href="{{ asset('favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div class="container">
        <h2>Lista pacienți CNAM</h2>

        <a href="{{ route('cnam.create') }}" class="btn-add">
            <i class="fa-solid fa-user-plus"></i>
            Adaugă pacient nou
        </a>
        {{-- <button id="addRow" class="btn btn-success">Adaugă pacient nou</button> --}}
        <br><br>

        <table border="1" width="100%" id="patientsTable">
            <thead>
                <tr>
                    <th>Cod</th>
                    <th>Nume <span style="color:red;">*</span></th>
                    <th>Prenume <span style="color:red;">*</span></th>
                    <th>Data nașterii <span style="color:red;">*</span></th>
                    <th>IDNP <span style="color:red;">*</span></th>
                    <th>Localitate <span style="color:red;">*</span></th>
                    <th>Sector</th>
                    <th>Stradă</th>
                    <th>Casă</th>
                    <th>Bloc</th>
                    <th>Apartament</th>
                    <th>Full Info</th>
                    <th>Acțiuni</th>
                    <th>
                        <i class="fa-solid fa-info"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $r)
                    <tr>
                        <form method="POST" action="{{ route('cnam.update', $r->id) }}">
                            @csrf
                            @method('PUT')
                            <td>{{ $r->id }}</td>
                            <td><input type="text" name="numele" value="{{ $r->numele }}"></td>
                            <td><input type="text" name="prenumele" value="{{ $r->prenumele }}"></td>
                            <td><input type="date" name="data_nasterii" value="{{ $r->data_nasterii }}"></td>
                            <td><input type="text" name="idnp" value="{{ $r->idnp }}"></td>
                            <td><input type="text" name="localitatea" value="{{ $r->localitatea }}"></td>
                            <td><input type="text" name="sectorul" value="{{ $r->sectorul }}"></td>
                            <td><input type="text" name="strada" value="{{ $r->strada }}"></td>
                            <td><input type="text" name="casa" value="{{ $r->casa }}" style="width:60px;">
                            </td>
                            <td><input type="text" name="blocul" value="{{ $r->blocul }}" style="width:60px;">
                            </td>
                            <td><input type="text" name="apartamentul" value="{{ $r->apartamentul }}"
                                    style="width:60px;"></td>
                            <td><input type="text" value="{{ $r->full_info }}" readonly></td>
                            <td>
                                <button type="submit" class="btn btn-primary">💾 Salvează</button>
                        </form>

                        <form method="POST" action="{{ route('cnam.destroy', $r->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Ești sigur că vrei să ștergi?')">🗑 Șterge</button>
                        </form>
                        </td>
                        <td>
                            <i class="fa-solid fa-circle-info"
                                title="Adăugat: {{ $r->created_at }}&#10;Editat: {{ $r->updated_at }}"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

{{-- <script>
    document.getElementById('addRow').addEventListener('click', function() {
        const table = document.getElementById('patientsTable').getElementsByTagName('tbody')[0];
    
        const newRow = document.createElement('tr');
    
        newRow.innerHTML = `
        <form id="patientsForm" method="POST" action="{{ route('cnam.store') }}">
            @csrf
            <td></td>
            <td><input type="text" name="numele" required></td>
            <td><input type="text" name="prenumele" required></td>
            <td><input type="date" name="data_nasterii" required></td>
            <td><input type="text" name="idnp" required></td>
            <td><input type="text" name="localitatea" required></td>
            <td><input type="text" name="sectorul"></td>
            <td><input type="text" name="strada"></td>
            <td><input type="text" name="casa"></td>
            <td><input type="text" name="blocul"></td>
            <td><input type="text" name="apartamentul"></td>
            <td><input type="text" class="full_info" readonly></td>
            <td>
                <button type="submit" class="btn btn-primary">💾 Salvează</button>
                <button type="button" class="btn btn-danger removeRow">🗑 Șterge</button>
            </td>
        </form>
        `;
    
        table.appendChild(newRow);
    
        // Actualizare full_info live
        const inputs = newRow.querySelectorAll('input[name="numele"], input[name="prenumele"], input[name="data_nasterii"]');
        const fullInfo = newRow.querySelector('.full_info');
    
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const nume = newRow.querySelector('input[name="numele"]').value;
                const prenume = newRow.querySelector('input[name="prenumele"]').value;
                const data = newRow.querySelector('input[name="data_nasterii"]').value;
                fullInfo.value = `${nume} ${prenume} ${data}`;
            });
        });
    
        // Buton remove rând
        newRow.querySelector('.removeRow').addEventListener('click', () => {
            newRow.remove();
        });
    });
    </script> --}}

</html>
