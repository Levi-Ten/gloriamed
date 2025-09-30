@extends('layouts.app')
@section('title', 'Sala de proceduri | Forma')
@section('content')
    <div style="text-align: left">
        <h2>Sala de proceduri</h2>

        <form method="GET" action="{{ route('proceduri.create') }}" class="form-cnam">
            <label for="pacient_id">Pacient:</label>
            <select name="pacient_id" id="pacient_id" onchange="this.form.submit()">
                <option value="">-- Alege pacient --</option>
                @foreach ($pacienti as $p)
                    <option value="{{ $p->id }}" {{ $pacient_id == $p->id ? 'selected' : '' }}>
                        {{ $p->numele }} {{ $p->prenumele }} ({{ $p->idnp }})
                    </option>
                @endforeach
            </select>
        </form>
        <br>
        @if ($pacient_id)
            <form method="POST" action="{{ route('proceduri.store') }}" class="form-cnam">
                @csrf
                <input type="hidden" name="pacient_id" value="{{ $pacient_id }}">
                {{-- <input type="date" name="data" value="{{ old('data', date('Y-m-d')) }}"> --}}
                <p>Data: {{ old('data', date('Y-m-d')) }}</p>
                <p>Cod: {{ $pacient_id }}</p>
                <br>
                <h4>Analize:</h4>
                {{-- <div> --}}
                {{-- @foreach (['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'] as $field)
                    <label>
                        <input type="checkbox" name="{{ $field }}" {{ $analize?->$field ? 'checked' : '' }}>
                        {{ ucfirst($field) }}
                    </label><br>
                @endforeach --}}
                @foreach ($analizeFields as $field)
                    <label>
                        <input type="checkbox" name="{{ $field }}" {{ $analize?->$field ? 'checked' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                    </label><br>
                @endforeach
                {{-- </div> --}}
                <br>
                <hr>
                <br>
                <button type="submit" class="btn btn-success mt-2">Salvează</button>
            </form>
        @endif
    </div>
@endsection
