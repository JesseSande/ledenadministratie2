<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Bedankt voor het inschrijven! Voordat je verdergaat, kun je je e-mailadres verifiëren door te klikken op de link die we je zojuist hebben gemaild? Geen link ontvangen? We sturen je graag een nieuwe link.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Een nieuwe verificatielink is naar het e-mailadres dat je tijdens registratie hebt opgegeven gestuurd.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Verstuur verificatiemail opnieuw') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Uitloggen') }}
            </button>
        </form>
    </div>
</x-guest-layout>
