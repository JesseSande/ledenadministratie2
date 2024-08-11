@extends('layouts.app')

@section('title', 'Contributies index')

@section('content')
    <h1>Contributie basisbedragen</h1>

    <!-- Navigatie knoppen -->
    <div>
        <a href="{{ route('contribution.overview') }}" class="navButton">
            Terug naar contributie overzicht
        </a>
        <a href="{{ route('contributions.create') }}" class="actionButton">
            Nieuw basisbedrag toevoegen
        </a>
    </div>

    <!-- Succesmeldingen -->
    @if(session('success'))
        <div class="successMessage">{{ session('success') }}</div>
    @endif
    
    <!-- Contributies basisbedrag tonen-->
    <table>
        <thead>
            <tr>
                <th>Jaar</th>
                <th>Basisbedrag</th>
                <th>Bewerken</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contributions as $contribution)     
                <tr>
                    <td>{{ $contribution->fiscalYear->year }}</td>
                    <td>€ {{ number_format($contribution->amount, 2, ',', '.') }}</td>
                    <td class="centeredCell">
                        <a href="{{ route('contributions.edit', $contribution->id) }}" class="actionLink">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Geen contributies gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Opmerkingen --> 
    <p class="infoNote">Basisbedragen voor contributies kunnen op dit moment niet worden verwijderd. Vraag de beheerder om dit handmatig te doen of kies voor 'Bewerken'.</p>
@endsection