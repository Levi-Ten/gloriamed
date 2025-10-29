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
                            <th>Data procedurii</th>
                            <th>Pacient</th>
                            <th>Data nasterii</th>
                            {{-- @foreach ($analizeFields as $field)
                                <th>{{ ucfirst($field) }}</th>
                            @endforeach --}}
                            @foreach ($analizeFields as $field)
                                <th>
                                    @switch($field)
                                        @case('hbsag')
                                            HBsAg
                                        @break

                                        @case('mrs_hiv')
                                            MRS HIV
                                        @break

                                        @case('mrs_hiv')
                                            MRS HIV
                                        @break

                                        @case('afp')
                                            AFP
                                        @break

                                        @default
                                            {{ ucfirst($field) }}
                                    @endswitch
                                </th>
                            @endforeach
                            <th>Actiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pacienti as $p)
                            @php $proc = $p->proceduri; @endphp
                            @foreach ($proc as $procedura)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($procedura->data_analizei)->format('Y-m-d') }}</td>
                                    <td>{{ $p->numele }} {{ $p->prenumele }}</td>
                                    <td>{{ $p->data_nasterii }}</td>
                                    @foreach ($analizeFields as $field)
                                        <td>
                                            <input type="checkbox" name="proceduri[{{ $p->id }}][{{ $field }}]"
                                                {{ $procedura && $procedura->$field ? 'checked' : '' }}
                                                class="readonly-checkbox">
                                        </td>
                                    @endforeach
                                    <td>
                                        @if ($proc)
                                            <a href="{{ route('proceduri.destroy', $procedura->id) }}"
                                                style="border: 1px solid; padding: 3px;color: white; background-color: red;"
                                                onclick="return confirm('Sigur vrei să ștergi acest pacient?')">
                                                🗑 Șterge
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
