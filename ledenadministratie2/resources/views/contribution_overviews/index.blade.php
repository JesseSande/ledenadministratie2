@extends('layouts.app')

@section('title', 'Contributie overzicht index')

@section('content')
    <h1>Contributie overzicht</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('families.index') }}" class="navButton">
            Beheer families
        </a>
        <a href="{{ route('membership_types.index') }}" class="navButton">
            Beheer lidmaatschappen
        </a>
        <a href="{{ route('contributions.index') }}" class="navButton">
            Beheer basisbedragen
        </a>
        <a href="{{ route('fiscal_years.index') }}" class="navButton">
            Beheer boekjaren
        </a>
    </div>

    <!-- Formulier voor het selecteren van filters -->
    <form action="{{ route('contribution_overviews.index') }}" method="GET">
        <label for="year">Filter op boekjaar:</label>
        <select class="filterText" name="year" id="year" onchange="this.form.submit()">
            <option value="">Alle boekjaren</option>
            @foreach($fiscalYears as $year)
                <option value="{{ $year->id }}" {{ $selectedYear == $year->id ? 'selected' : '' }}>
                    {{ $year->year }}
                </option>
            @endforeach
        </select>

        <label for="family_id">Filter op familie:</label>
        <select class="filterText" name="family_id" id="family_id" onchange="this.form.submit()">
            <option value="">Alle families</option>
            @foreach($families as $family)
                <option value="{{ $family->id }}" {{ $selectedFamily == $family->id ? 'selected' : '' }}>
                    {{ $family->id }} - {{ $family->family_name }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Tabel voor het tonen van de contributies op basis van de filters. Code m.b.v. ChatGPT4o Laravel GPT. -->
    <table>
        <thead>
            <tr>
                <th>Familie ID</th>
                <th>Familienaam</th>
                <th>Boekjaar</th>
                <th>Aantal geregistreerde contributies</th>
                <th>Contributiebedrag</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contributions as $group => $contributionItems)
                @php
                    list($familyId, $familyName, $fiscalYear) = explode(' - ', $group);
                @endphp
                <tr>
                    <td>{{ $familyId }}</td>
                    <td>{{ $familyName }}</td>
                    <td>{{ $fiscalYear }}</td>
                    <td>{{ $contributionItems->count() }}</td>
                    <td>€ {{ number_format($contributionItems->sum(function ($contribution) {
                        return $contribution->calculateContribution();
                    }), 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Geen contributies gevonden voor de geselecteerde filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Opmerkingen --> 
    <p class="infoNote">De gegevens in dit overzicht worden automatisch berekend op basis van elders ingevoerde gegevens. Iets bewerken? <br>Ga dan via de navigatieknoppen naar het beheer van het onderdeel dat je wil bewerken.</p>
@endsection