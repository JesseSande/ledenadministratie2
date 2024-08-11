@extends('layouts.app')

@section('title', 'Contributie voor lid aanmaken')

@section('content')
    <h1>Contributie voor {{ $familyMember->first_name }} {{ $familyMember->family->family_name }} aanmaken</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('member_years.index', $familyMember->id) }}" class="navButton">
            Terug naar contributies van {{ $familyMember->first_name }} {{ $familyMember->family->family_name }}
        </a>
    </div>

    <!-- Formulier voor het aanmaken van een contributie --> 
    <h2>Kies een boekjaar:</h2>

    <form action="{{ route('member_years.store', ['family_member' => $familyMember->id]) }}" method="POST">
        @csrf

        <!-- Boekjaar kiezen -->
        <div class="formField">
            <label for="fiscal_year_id">Kies een Boekjaar:</label>
            <select name="fiscal_year_id" id="fiscal_year_id" required>
                <option value="" disabled selected>Kies boekjaar</option>
                @foreach($fiscalYears as $fiscalYear)
                    <option value="{{ $fiscalYear->id }}" {{ old('fiscal_year_id') == $fiscalYear->id ? 'selected' : '' }}>
                        {{ $fiscalYear->year }}
                    </option>
                @endforeach
            </select>
            @error('fiscal_year_id')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div class="formField">
            <input type="submit" value="Opslaan" class="actionButton" />
        </div>
    </form>
@endsection