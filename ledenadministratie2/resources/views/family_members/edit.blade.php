@extends('layouts.app')

@section('title', 'Familielid bewerken')

@section('content')
    <h1>Familielid {{ $familyMember->first_name }} {{ $family->family_name }} bewerken</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('family_members.index', $family->id) }}" class="navButton">
            Terug naar familieleden
        </a>
    </div>

    <!-- Formulier voor het bewerken van het familielid -->
    <h2>Wijzig de gegevens:</h2>

    <form method="post" action="{{ route('family_members.update', ['family' => $family->id, 'familyMember' => $familyMember->id]) }}">
        @csrf
        @method('put')

        <!-- Voornaam -->
        <div class="formField">
            <label for="first_name">Voornaam:</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $familyMember->first_name) }}" required />
            @error('first_name')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Geboortedatum -->
        <div class="formField">
            <label for="birth_date">Geboortedatum:</label>
            <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $familyMember->birth_date) }}" required />
            @error('birth_date')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Familierol -->
        <div class="formField">
            <label for="family_role">Familierol:</label>
            <select id="family_role" name="family_role" required>
                <option value="" disabled>Selecteer een familierol</option>
                <option value="Vader" {{ old('family_role', $familyMember->family_role) == 'Vader' ? 'selected' : '' }}>Vader</option>
                <option value="Moeder" {{ old('family_role', $familyMember->family_role) == 'Moeder' ? 'selected' : '' }}>Moeder</option>
                <option value="Zoon" {{ old('family_role', $familyMember->family_role) == 'Zoon' ? 'selected' : '' }}>Zoon</option>
                <option value="Dochter" {{ old('family_role', $familyMember->family_role) == 'Dochter' ? 'selected' : '' }}>Dochter</option>
                <option value="Opa" {{ old('family_role', $familyMember->family_role) == 'Opa' ? 'selected' : '' }}>Opa</option>
                <option value="Oma" {{ old('family_role', $familyMember->family_role) == 'Oma' ? 'selected' : '' }}>Oma</option>
                <option value="Oom" {{ old('family_role', $familyMember->family_role) == 'Oom' ? 'selected' : '' }}>Oom</option>
                <option value="Tante" {{ old('family_role', $familyMember->family_role) == 'Tante' ? 'selected' : '' }}>Tante</option>
                <option value="Neef" {{ old('family_role', $familyMember->family_role) == 'Neef' ? 'selected' : '' }}>Neef</option>
                <option value="Nicht" {{ old('family_role', $familyMember->family_role) == 'Nicht' ? 'selected' : '' }}>Nicht</option>
                <option value="Overig" {{ old('family_role', $familyMember->family_role) == 'Overig' ? 'selected' : '' }}>Overig</option>
            </select>
            @error('family_role')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Lidmaatschapsrol -->
        <div class="formField">
            <label for="member_role_id">Lidmaatschapsrol:</label>
            <select id="member_role_id" name="member_role_id" required>
                <option value="" disabled>Selecteer een lidmaatschapsrol</option>
                @foreach($memberRoles as $role)
                    <option value="{{ $role->id }}" {{ old('member_role_id', $familyMember->member_role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->description }}
                    </option>
                @endforeach
            </select>
            @error('member_role_id')
                <div class="errorMessage">{{ $message }}</div>
            @enderror
        </div>

        <!-- Opslaan -->
        <div class="formField">
            <input type="submit" value="Opslaan" class="actionButton formButton" />
        </div>
    </form>
@endsection