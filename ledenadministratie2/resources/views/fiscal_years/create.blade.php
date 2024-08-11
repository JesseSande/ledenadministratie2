@extends('layouts.app')

@section('title', 'Boekjaar aanmaken')

@section('content')
    <h1>Boekjaar aanmaken</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
    </div>

    <!-- Formulier voor het aanmaken van een nieuw boekjaar -->
    <h2>Vul de gegevens in:</h2>

    <form method="post" action="{{ route('fiscal_years.store') }}">
        @csrf

        <!-- Boekjaar -->
        <div class="formField">
            <label for="year">Jaar:</label>
            <input id="year" type="number" name="year" min="1900" max="{{ date('Y') + 5 }}" required />
            @error('year')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div>
            <input type="submit" value="Opslaan" class="actionButton formButton" />
        </div>
    </form>
@endsection