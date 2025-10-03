@extends('layouts.app')
@section('title', 'Sala de proceduri | Tabel')
@section('content')
    <div class="container">
        <h2>Sala de proceduri</h2>
        <button onclick="printTable()" class="btn btn-primary mb-3">🖨️ Imprimă tabelul</button>

        <div id="printableArea">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pacient</th>
                        <th>Data procedurii</th>
                        @foreach ($analizeFields as $field)
                            <th>{{ ucfirst($field) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proceduri as $proc)
                        <tr>
                            <td>{{ $proc->id }}</td>
                            <td>{{ $proc->pacient->numele }} {{ $proc->pacient->prenumele }}</td>
                            <td>{{ $proc->created_at->format('d.m.Y') }}</td>
                            @foreach ($analizeFields as $field)
                                <td>{{ $proc->$field ? '✅' : '❌' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
