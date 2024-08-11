@extends('layouts.app')

@section('title', 'Familieleden index')

@section('content')
    <h1>Familieleden van familie {{ $family->family_name }}</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('families.index') }}" class="navButton">
            Terug naar families
        </a>
        <a href="{{ route('family_members.create', $family->id) }}" class="actionButton">
            Nieuw familielid toevoegen
        </a>
    </div>

    <!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif

    <!-- Tabel voor het tonen van de familieleden -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Geboortedatum</th>
                    <th>Familierol</th>
                    <th>Lid rol</th>
                    <th>Bewerken</th>
                    <th>Verwijderen</th>
                    <th>Contributies bekijken</th>
                </tr>
            </thead>
            <tbody>
                @forelse($familyMembers as $familyMember)
                    <tr>
                        <td>{{ $familyMember->id }}</td>
                        <td>{{ $familyMember->first_name }}</td>
                        <td>{{ $familyMember->birth_date }}</td>
                        <td>{{ $familyMember->family_role }}</td>
                        <td>{{ $familyMember->memberRole->description ?? 'Geen rol' }}</td>
                        <td class="centeredCell">
                            <a href="{{ route('family_members.edit', ['family' => $family->id, 'familyMember' => $familyMember->id]) }}" class="actionLink">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                        <td class="centeredCell">
                            <form method="POST" action="{{ route('family_members.destroy', ['family' => $family->id, 'familyMember' => $familyMember->id]) }}" onsubmit="return confirm('Weet je zeker dat je dit familielid wilt verwijderen? Hiermee verwijder je ook alle gekoppelde gegevens. Dit kan niet ongedaan worden gemaakt.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="iconButton">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="centeredCell">
                            <a href="{{ route('member_years.index', $familyMember->id) }}" class="navLink">
                                <i class="fas fa-eye"></i>                        
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Geen familieleden gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection