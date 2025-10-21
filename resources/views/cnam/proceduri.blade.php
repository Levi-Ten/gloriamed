{{-- @extends('layouts.app')
@section('title', 'Sala de proceduri | Tabel')
@section('content')
<div class="container">
    <h2>Sala de proceduri</h2>

    <form method="POST" action="{{ route('proceduri.updateBulk') }}">
        @csrf
        <table border="1" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pacient</th>
                    <th>Data procedurii</th>
                    @foreach ($analizeFields as $field)
                        <th>{{ ucfirst($field) }}</th>
                    @endforeach
                    <th>Ștergere</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proceduri as $proc)
                    <tr>
                        <td>{{ $proc->id }}</td>
                        <td>{{ $proc->pacient->numele }} {{ $proc->pacient->prenumele }}</td>
                        <td>{{ $proc->created_at->format('d.m.Y') }}</td>

                        @foreach ($analizeFields as $field)
                            <td>
                                <input type="checkbox" name="proceduri[{{ $proc->id }}][{{ $field }}]" 
                                    {{ $proc->$field ? 'checked' : '' }}>
                            </td>
                        @endforeach

                        <td>
                            <a href="{{ route('proceduri.destroy', $proc->id) }}" class=""
                               onclick="return confirm('Sigur vrei să ștergi acest pacient?')">
                                🗑️
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success mt-3">Salvează modificările</button>
    </form>
</div>
@endsection --}}
@extends('layouts.app')
@section('title', 'Sala de proceduri')
@section('content')

    <div class="container">
        <h2>Sala de proceduri</h2>
        <button onclick="printTable()" class="btn btn-primary mb-3">🖨️ Imprimă tabelul</button>
        <br>
        <br>
        <form method="POST" action="{{ route('proceduri.updateBulk') }}">
            @csrf

            <div id="printableArea" style="margin-right: 10px">
                <table border="1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pacient</th>
                            <th>Data nasterii</th>
                            <th>Data procedurii</th>
                            @foreach ($analizeFields as $field)
                                <th>{{ ucfirst($field) }}</th>
                            @endforeach
                            {{-- <th>Ștergere</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pacienti as $p)
                            @php $proc = $p->procedura; @endphp
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->numele }} {{ $p->prenumele }}</td>
                                <td>{{ $p->data_nasterii }}</td>
                                <td>{{ $proc ? \Carbon\Carbon::parse($proc->updated_at)->format('d.m.Y') : '-' }}</td>

                                @foreach ($analizeFields as $field)
                                    <td>
                                        <input type="checkbox" name="proceduri[{{ $p->id }}][{{ $field }}]"
                                            {{ $proc && $proc->$field ? 'checked' : '' }} class="readonly-checkbox">
                                    </td>
                                @endforeach
                                {{-- <td>
                                @if ($proc)
                                <a href="{{ route('proceduri.destroy', $proc->id) }}" class=""
                                    onclick="return confirm('Sigur vrei să ștergi acest pacient?')">
                                     🗑️
                                 </a>
                                @endif
                            </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            {{-- <button type="submit" class="btn btn-primary mt-3">Salvează modificările</button> --}}
        </form>
    </div>
    <script>
        function printTable() {
            let printContents = document.getElementById("printableArea").innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
