@extends('layouts.app')

@section('title', 'Familie bewerken')

@section('content')
    <h1>Familie bewerken</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('families.index') }}" class="navButton">
            Terug naar families
        </a>
    </div>

    <!-- Formulier om de familie te bewerken -->
    <h2>Wijzig de gegevens:</h2>

    <form method="post" action="{{ route('families.update', $family->id) }}">
        @csrf
        @method('PUT')

        <!-- Familienaam -->
        <div class="formField">  
            <label for="family_name">Familienaam:</label>
            <input id="family_name" type="text" name="family_name" value="{{ old('family_name', $family->family_name) }}" />
            @error('family_name')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Adres -->
        <div class="formField">  
            <label for="address">Adres (postcode + huisnummer):</label>
            <input id="address" type="text" name="address" value="{{ old('address', $family->address) }}" />
            @error('address')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div>
            <input type="submit" value="Opslaan" class="actionButton formButton" />
        </div>
    </form>
@endsection