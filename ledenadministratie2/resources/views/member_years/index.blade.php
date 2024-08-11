@extends('layouts.app')

@section('title', 'Contributies familielid bekijken')

@section('content')
    <h1>Contributies van {{ $familyMember->first_name }} {{ $familyMember->family->family_name }}</h1>

    <!-- Navigatie knoppen --> 
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('family_members.index', $familyMember->family_id) }}" class="navButton">
            Terug naar familieleden
        </a>
        <a href="{{ route('member_years.create', ['family_member' => $familyMember->id]) }}" class="actionButton">
            Nieuwe contributie aanmaken
        </a>
    </div>

    <!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif

    <!-- Tabel voor het tonen van de contributies -->
        <table class="narrowTable">
            <thead>
                <tr>
                <th>Boekjaar</th>
                <th>Berekende contributie</th>
                <th>Verwijderen</th>
            </tr>
        </thead>
        @forelse($contributions as $contribution)
                <tr>
                    <td>{{ $contribution->fiscalYear->year }}</td>
                    <td>€ {{ number_format($contribution->calculateContribution(), 2, ',', '.') }}</td>
                    <td class="centeredCell">
                        <form method="post" action="{{ route('member_years.destroy', $contribution->id) }}" onsubmit="return confirm('Weet je zeker dat je deze berekende contributie wilt verwijderen? Dit kan niet ongedaan worden gemaakt.');">
                            @csrf
                            @method('delete')
                            <button type="submit" class="iconButton">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Er zijn geen contributies gevonden voor dit lid.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Opmerkingen --> 
    <p class="infoNote">Deze contributies worden automatisch berekend op basis van elders ingevoerde gegevens. Contributie bewerken? <br>Ga dan via het contributie overzicht naar het beheer van het onderdeel dat je wil bewerken.</p>
@endsection