@extends('layouts.app')

@section('title', 'Contributie basisbedrag toevoegen')

@section('content')
    <h1>Nieuw basisbedrag contributie toevoegen</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('contributions.index') }}" class="navButton">
            Terug naar contributie basisbedragen
        </a>
    </div>

    <!-- Formulier voor het aanmaken van een nieuw basisbedrag -->
    <h2>Vul de gegevens in:</h2>

    <form method="post" action="{{ route('contributions.store') }}">
        @csrf

        <!-- Boekjaar -->
        <div class="formField">
            <label for="fiscal_year_id">Boekjaar:</label>
            <select id="fiscal_year_id" name="fiscal_year_id" required>
                <option value="" disabled selected>Kies een boekjaar</option>
                @foreach($fiscalYears as $year)
                    <option value="{{ $year->id }}" {{ old('fiscal_year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->year }}
                    </option>
                @endforeach
            </select>
            @error('fiscal_year_id')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Basisbedrag -->
        <div class="formField">
            <label for="amount">Basisbedrag (€):</label>
            <input id="amount" type="number" name="amount" min="0" max="1000" step="0.01" required value="{{ old('amount') }}" />
            @error('amount')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div class="formField">
            <input type="submit" value="Opslaan" class="actionButton formButton" />
        </div>
    </form>
@endsection