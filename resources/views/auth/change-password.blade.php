@extends('layouts.app') {{-- dacă folosești un layout general --}}
@section('content')
    <div class="container mt-5"
        style="max-width: 500px; border: 1px solid #ccc; border-radius: 10px; padding: 20px; margin: 50px auto;">
        <h3 class="mb-4 text-center">Schimbă parola</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.updatePassword') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="current_password">Parola actuală</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="new_password">Parola nouă</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="new_password_confirmation">Confirmă parola nouă</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Actualizează parola</button>
        </form>
    </div>
@endsection
