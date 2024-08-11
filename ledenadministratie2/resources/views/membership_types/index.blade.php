@extends('layouts.app')

@section('title', 'Lidmaatschapstypen index')

@section('content')
    <h1>Lidmaatschappen</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('membership_types.create_step1') }}" class="actionButton">
            Nieuwe lidmaatschappen aanmaken
        </a>
    </div>

    <!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif

    <!-- Formulier voor het selecteren van een boekjaar -->
    <form action="{{ route('membership_types.index') }}" method="GET">
        <label for="fiscal_year_id">Kies een boekjaar:</label>
        <select class="filterText" name="fiscal_year_id" id="fiscal_year_id" onchange="this.form.submit()">
            <option value="" disabled selected>Kies een boekjaar:</option>
            @foreach($fiscalYears as $fiscalYear)
                <option value="{{ $fiscalYear->id }}" {{ $selectedYearId == $fiscalYear->id ? 'selected' : '' }}>
                    {{ $fiscalYear->year }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Lidmaatschappen van het gekozen boekjaar tonen -->
    <table>
        <thead>
            <tr>
                <th>Lidmaatschapstype</th>
                <th>Min. leeftijd</th>
                <th>Max. leeftijd</th>
                <th>Korting</th>
                <th>Bewerken</th>
            </tr>
        </thead>
        <tbody>
            @forelse($membershipTypes as $index => $membershipType)
                <tr>
                    <td>{{ $membershipType->title }}</td>
                    <td>{{ $membershipType->age_min }}</td>
                    <td>{{ $membershipType->age_max }}</td>
                    <td>{{ $membershipType->discount }}%</td>
                    @if($index === 0)
                        <!-- De eerste keer dat de loop loopt, plaats de bewerk-knop -->
                        <td rowspan="{{ $membershipTypes->count() }}" class="centeredCell">
                            <a href="{{ route('membership_types.edit', $selectedYearId) }}" class="actionLink">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5">Geen lidmaatschappen gevonden voor dit boekjaar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Opmerkingen --> 
    <p class="infoNote">Lidmaatschappen kunnen op dit moment niet worden verwijderd. Vraag de beheerder om dit handmatig te doen of kies voor 'Bewerken'.</p>
@endsection