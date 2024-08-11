@extends('layouts.app')

@section('title', 'Boekjaren index')

@section('content')
    <h1>Boekjaren</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('fiscal_years.create') }}" class="actionButton">
            Nieuw boekjaar toevoegen
        </a>
    </div>

    <!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif

    <!-- Tabel voor het tonen van de boekjaren -->
    <table>
        <thead>
            <tr>
                <th>Boekjaar</th>
                <th>Aantal geregistreerde contributies</th>
                <th>Totaalbedrag contributies</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fiscalYears as $year)
                <tr>
                    <td>{{ $year->year }}</td>
                    <td>{{ $year->contributions_count }}</td>
                    <td>€ {{ number_format($year->total_contributions, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="centeredCell">Geen boekjaren gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Opmerkingen --> 
    <p class="infoNote">Deze contributies worden automatisch berekend op basis van elders ingevoerde gegevens. Contributies binnen een boekjaar bewerken? <br>Ga dan via het contributie overzicht naar het beheer van het onderdeel dat je wil bewerken.</p>
    <p class="infoNote">Boekjaren kunnen op dit moment niet worden bewerkt of verwijderd. Vraag de beheerder om dit indien toch nodig handmatig te doen.</p>
@endsection