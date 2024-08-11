@extends('layouts.app')

@section('title', 'Familie index')

@section('content')
	<h1>Families</h1>

	<!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('families.create') }}" class="actionButton">
            Nieuwe familie aanmaken
        </a>
    </div>

	<!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif

	<!-- Tabel voor het tonen van de families -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="wideColumn">Familienaam</th>
                    <th class="wideColumn">Adres</th>
                    <th>Aantal familieleden</th>
                    <th>Bewerken</th>
                    <th>Verwijderen</th>
                    <th>Familieleden bekijken</th>
                </tr>
            </thead>
            <tbody>
                @forelse($families as $family)
                    <tr>
                        <td>{{ $family->id }}</td>
                        <td>{{ $family->family_name }}</td>
                        <td>{{ $family->address }}</td>
                        <td>{{ $family->family_members_count }}</td>
                        <td class="centeredCell">
                            <a href="{{ route('families.edit', $family->id) }}" class="actionLink">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                        <td class="centeredCell">
                            <form method="POST" action="{{ route('families.destroy', $family->id) }}" onsubmit="return confirm('Weet je zeker dat je deze familie wilt verwijderen? Hiermee verwijder je ook alle gekoppelde familieleden en hun gegevens. Dit kan niet ongedaan worden gemaakt.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="iconButton">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="centeredCell">
                            <a href="{{ route('family_members.index', $family->id) }}" class="navLink">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Geen families gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection