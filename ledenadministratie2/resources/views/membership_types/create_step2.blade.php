@extends('layouts.app')

@section('title', 'Lidmaatschappen Aanmaken')

@section('content')
    <h1>Lidmaatschappen aanmaken - Boekjaar {{ $fiscalYear->year }}</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('membership_types.index') }}" class="navButton">
            Terug naar lidmaatschappen
        </a>
    </div>

    <!-- Formulier voor het aanmaken van lidmaatschappen voor het gekozen boekjaar -->
    <h2>Vul de gegevens in:</h2>

    @if(!empty($errors))
        <div>
            <ul>
                @foreach ($errors as $error)
                    <li class="errorMessage">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('membership_types.store') }}" method="POST">
        @csrf

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
                        <td>{{ ucfirst($title) }}</td>
                        <td>
                            <input type="number" name="age_min[{{ $title }}]" required
                                   value="{{ old('age_min.'.$title) }}">
                        </td>
                        <td>
                            <input type="number" name="age_max[{{ $title }}]" required
                                   value="{{ old('age_max.'.$title) }}">
                        </td>
                        <td>
                            <input type="number" name="discount[{{ $title }}]" required
                                   value="{{ old('discount.'.$title) }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <input type="submit" class="actionButton" value="Opslaan" />
    </form>
@endsection