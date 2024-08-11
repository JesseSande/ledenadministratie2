@extends('layouts.app')

@section('title', 'Contributie basisbedrag bewerken')

@section('content')
    <h1>Basisbedrag contributie voor boekjaar {{ $contribution->fiscalYear->year }} bewerken</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('contributions.index') }}" class="navButton">
            Terug naar contributie basisbedragen
        </a>
    </div>

    <!-- Formulier voor het bewerken van het basisbedrag -->
    <h2>Wijzig de gegevens:</h2>

    <form method="post" action="{{ route('contributions.update', $contribution->id) }}">
        @csrf
        @method('PUT')

        <!-- Basisbedrag -->
        <div class="formField">
            <label for="amount">Basisbedrag (€):</label>
            <input id="amount" type="number" name="amount" min="0" max="1000" step="0.01" required value="{{ old('amount', $contribution->amount) }}" />
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