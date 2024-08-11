@extends('layouts.app')

@section('title', 'Familielid aanmaken')

@section('content')
    <h1>Nieuw familielid voor familie {{ $family->family_name }}</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('family_members.index', $family->id) }}" class="navButton">
            Terug naar familieleden
        </a>
    </div>

    <!-- Formulier voor het aanmaken van een nieuw familielid -->
    <h2>Vul de gegevens in:</h2>
    
    <form action="{{ route('family_members.store', $family->id) }}" method="POST">
        @csrf

        <!-- Voornaam -->
        <div class="formField">
            <label for="first_name">Voornaam:</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
            @error('first_name')
                <div class="generalContent errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Geboortedatum -->
        <div class="formField">
            <label for="birth_date">Geboortedatum:</label>
            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required>
            @error('birth_date')
                <div class="generalContent errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Familierol -->
        <div class="formField">
            <label for="family_role">Familierol:</label>
            <select name="family_role" id="family_role" required>
                <option value="" disabled selected>Kies een rol</option>
                <option value="Vader" {{ old('family_role') == 'Vader' ? 'selected' : '' }}>Vader</option>
                <option value="Moeder" {{ old('family_role') == 'Moeder' ? 'selected' : '' }}>Moeder</option>
                <option value="Zoon" {{ old('family_role') == 'Zoon' ? 'selected' : '' }}>Zoon</option>
                <option value="Dochter" {{ old('family_role') == 'Dochter' ? 'selected' : '' }}>Dochter</option>
                <option value="Opa" {{ old('family_role') == 'Opa' ? 'selected' : '' }}>Opa</option>
                <option value="Oma" {{ old('family_role') == 'Oma' ? 'selected' : '' }}>Oma</option>
                <option value="Oom" {{ old('family_role') == 'Oom' ? 'selected' : '' }}>Oom</option>
                <option value="Tante" {{ old('family_role') == 'Tante' ? 'selected' : '' }}>Tante</option>
                <option value="Neef" {{ old('family_role') == 'Neef' ? 'selected' : '' }}>Neef</option>
                <option value="Nicht" {{ old('family_role') == 'Nicht' ? 'selected' : '' }}>Nicht</option>
                <option value="Overig" {{ old('family_role') == 'Overig' ? 'selected' : '' }}>Overig</option>
            </select>
            @error('family_role')
                <div class="generalContent errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Lidmaatschapsrol -->
        <div class="formField">
            <label for="member_role_id">Lidmaatschapsrol:</label>
            <select name="member_role_id" id="member_role_id" required>
                <option value="" disabled selected>Kies een rol</option>
                @foreach($memberRoles as $role)
                    <option value="{{ $role->id }}" {{ old('member_role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->description }}
                    </option>
                @endforeach
            </select>
            @error('member_role_id')
                <div class="generalContent errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div class="formField">
            <input type="submit" value="Opslaan" class="actionButton">
        </div>
    </form>
@endsection