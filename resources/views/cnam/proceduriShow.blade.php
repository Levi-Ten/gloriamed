@extends('layouts.app')
@section('title', 'Sala de proceduri | Tabel')
@section('content')
    <div class="container">
        <h2>Lista procedurilor</h2>
        <!-- Buton pentru print -->
        <button onclick="printTable()" class="btn btn-primary mb-3">🖨️ Imprimă tabelul</button>

        <div id="printableArea">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pacient</th>
                        <th>Data procedurii</th>
                        <th>Hemograma</th>
                        <th>Urograma</th>
                        <th>Biochimia</th>
                        <th>Imunologia</th>
                        <th>HbA1c</th>
                        <th>HBsAg</th>
                        <th>MRS HIV</th>
                        <th>AFP</th>
                        <th>Hemostaza</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proceduri as $proc)
                        <tr>
                            <td>{{ $proc->id }}</td>
                            <td>{{ $proc->pacient->numele }} {{ $proc->pacient->prenumele }}</td>
                            {{-- <td>{{ \Carbon\Carbon::parse($proc->data)->format('d.m.Y') }}</td> --}}
                            <td>{{ $proc->created_at->format('d.m.Y') }}</td>
                            @foreach (['hemograma', 'urograma', 'biochimia', 'imunologia', 'hba1c', 'hbsag', 'mrs_hiv', 'afp', 'hemostaza'] as $field)
                                <td>
                                    @if ($proc->$field)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </td>
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
