@extends('layouts.app')

@section('title', 'Familie aanmaken')

@section('content')
    <h1>Familie aanmaken</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('families.index') }}" class="navButton">
            Terug naar families
        </a>
    </div>

    <!-- Formulier voor het aanmaken van een nieuwe familie -->
    <h2>Vul de gegevens in:</h2>

    <form method="post" action="{{ route('families.store') }}">
        @csrf 
        @method('post')

        <!-- Familienaam -->
        <div class="formField">  
            <label for="family_name">Familienaam:</label>
            <input id="family_name" type="text" name="family_name" placeholder="Achternaam" />
            @error('family_name')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Adres -->
        <div class="formField">  
            <label for="address">Adres (postcode + huisnummer):</label>
            <input id="address" type="text" name="address" placeholder="1234AB 55" />
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