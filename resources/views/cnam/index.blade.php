@extends('layouts.app')

@section('title', 'Lista pacientilor CNAM')

@section('content')

    <div class="container">
        <h2>Lista pacienți CNAM</h2>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('cnam.create') }}" class="btn-add">
                <i class="fa-solid fa-user-plus"></i>
                Adaugă pacient nou
            </a>
        </div>
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
                    <th>Localitate</th>
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
                                <button type="submit" class="">💾 Salvează</button>
                        </form>

                        <form method="POST" action="{{ route('cnam.destroy', $r->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class=""
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
@endsection
