@extends('layouts.app')
@section('title', 'Laborator | Tabel')
@section('content')
<div class="container">
    <h2>Laborator</h2>
    <div style="overflow-x:auto;">
        <table border="1" width="100%" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Pacient</th>
                    @foreach($columns as $col)
                        @if(!in_array($col, ['id','pacient_id','created_at','updated_at']))
                            <th>{{ ucfirst(str_replace('_',' ',$col)) }}</th>
                        @endif
                    @endforeach
                    
                </tr>
            </thead>
            <tbody>
                @foreach($laborator as $lab)
                    <tr>
                        <td>{{ $lab->id }}</td>
                        <td>{{ $lab->created_at->format('d.m.Y') }}</td>
                        <td>{{ $lab->pacient->numele }} {{ $lab->pacient->prenumele }}</td>
                        @foreach($columns as $col)
                            @if(!in_array($col, ['id','pacient_id','created_at','updated_at']))
                            <td>
                                @php $value = $lab->$col; @endphp
                                @if(is_bool($value) || in_array($value, [0,1]))
                                    {!! $value ? '✅' : '❌' !!}
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
    </div>
</div>
@endsection
