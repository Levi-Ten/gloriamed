<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adaugare pacient CNAM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="container">
        <h2>Adaugă pacient CNAM</h2>
<br><br>
        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cnam.store') }}" class="form-cnam">
            @csrf

            <div class="form-group">
                <label>Numele <span style="color:red;">*</span></label>
                <input type="text" name="numele" value="{{ old('numele') }}" required>
            </div>

            <div class="form-group">
                <label>Prenumele <span style="color:red;">*</span></label>
                <input type="text" name="prenumele" value="{{ old('prenumele') }}" required>
            </div>

            <div class="form-group">
                <label>Data nașterii <span style="color:red;">*</span></label>
                <input type="date" name="data_nasterii" value="{{ old('data_nasterii') }}" required>
            </div>

            <div class="form-group">
                <label>IDNP <span style="color:red;">*</span></label>
                <input type="text" name="idnp" value="{{ old('idnp') }}" required>
            </div>

            <div class="form-group">
                <label>Localitatea <span style="color:red;">*</span></label>
                <input type="text" name="localitatea" value="{{ old('localitatea') }}" required>
            </div>

            <div class="form-group">
                <label>Sector</label>
                <input type="text" name="sectorul" value="{{ old('sectorul') }}">
            </div>

            <div class="form-group">
                <label>Strada</label>
                <input type="text" name="strada" value="{{ old('strada') }}">
            </div>

            <div class="form-group">
                <label>Casa</label>
                <input type="text" name="casa" value="{{ old('casa') }}">
            </div>

            <div class="form-group">
                <label>Bloc</label>
                <input type="text" name="blocul" value="{{ old('blocul') }}">
            </div>

            <div class="form-group">
                <label>Apartamentul</label>
                <input type="text" name="apartamentul" value="{{ old('apartamentul') }}">
            </div>

            <br>
            <div class="form-group">
                <button type="submit">💾 Salvează</button>
                <a href="{{ route('cnam.index') }}" style="margin-left:10px;">⬅ Înapoi la listă</a>
            </div>
        </form>

    </div>


</body>

</html>
