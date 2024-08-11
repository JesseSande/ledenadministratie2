@extends('layouts.app')

@section('title', 'Lidmaatschappen bewerken')

@section('content')
    <h1>Lidmaatschappen voor boekjaar {{ $fiscalYear->year }} bewerken</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('membership_types.index') }}" class="navButton">
            Terug naar lidmaatschappen
        </a>
    </div>

    <!-- Formulier voor het bewerken van de lidmaatschappen -->
    <h2>Wijzig de gegevens:</h2>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="errorMessage">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ route('membership_types.update', $fiscalYear->id) }}">
        @csrf
        @method('put')

        <!-- Verborgen veld voor fiscal_year_id -->
        <input type="hidden" name="fiscal_year_id" value="{{ $fiscalYear->id }}" />

        <!-- Invultabel -->
        <table>
            <thead>
                <tr>
                    <th>Lidmaatschapstype</th>
                    <th>Min. leeftijd</th>
                    <th>Max. leeftijd</th>
                    <th>Korting (%)</th>
                </tr>
            </thead>
            <tbody>
            @foreach(['jeugd', 'aspirant', 'junior', 'senior', 'oudere'] as $title)
                    <tr>
                        <td>
                            {{ ucfirst($title) }}
                            <input type="hidden" name="title[{{ $title }}]" value="{{ $title }}">
                        </td>
                        <td>
                            <input type="number" name="age_min[{{ $title }}]" required
                                value="{{ old('age_min.'.$title, $membershipTypes[$title]->age_min ?? '') }}">
                        </td>
                        <td>
                            <input type="number" name="age_max[{{ $title }}]" required
                                value="{{ old('age_max.'.$title, $membershipTypes[$title]->age_max ?? '') }}">
                        </td>
                        <td>
                            <input type="number" name="discount[{{ $title }}]" required
                                value="{{ old('discount.'.$title, $membershipTypes[$title]->discount ?? '') }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Opslaan -->
        <div>
            <input type="submit" value="Opslaan" class="actionButton formButton" />
        </div>
    </form>
@endsection