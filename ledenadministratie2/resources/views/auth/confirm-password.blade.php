<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Dit is een beveiligd deel van de applicatie. Bevestig je wachtwoord voordat je verdergaat.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Wachtwoord -->
        <div>
            <x-input-label for="password" :value="__('Wachtwoord')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Bevestig') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
