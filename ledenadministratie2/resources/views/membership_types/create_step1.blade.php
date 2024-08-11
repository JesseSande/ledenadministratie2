@extends('layouts.app')

@section('title', 'Kies een Boekjaar')

@section('content')
    <h1>Lidmaatschap aanmaken - Kies een Boekjaar</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('membership_types.index') }}" class="navButton">
            Terug naar lidmaatschappen
        </a>
    </div>

    <!-- Formulier voor het kiezen van een boekjaar -->
    <h2>Kies een boekjaar:</h2>

    <form action="{{ route('membership_types.create_step2') }}" method="POST">
        @csrf

        <!-- Boekjaar kiezen -->
        <div class="formField">
            <label for="fiscal_year_id">Boekjaar:</label>
            <select name="fiscal_year_id" id="fiscal_year_id" required>
                <option value="" disabled selected>Kies boekjaar</option>
                @foreach($fiscalYears as $fiscalYear)
                    <option value="{{ $fiscalYear->id }}">{{ $fiscalYear->year }}</option>
                @endforeach
            </select>
            @error('fiscal_year_id')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Volgende pagina -->
        <div class="formField">
            <input type="submit" value="Volgende" class="actionButton" />
        </div>
    </form>
@endsection