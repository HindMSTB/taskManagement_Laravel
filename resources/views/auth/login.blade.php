<x-guest-layout>
<x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('admin/img/logo/logoRAD.png') }}" alt="Logo" style="width: 150px; height: auto;">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <!-- Afficher une alerte en rouge si un message d'erreur est présent dans la session -->
        @if(Session::has('error'))
            <div class="alert alert-danger text-red-500" role="alert">
                Votre compte est actuellement désactivé. Veuillez contacter l'administrateur pour obtenir de l'aide.
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if (Session::has('message'))
    <div class="mb-4 font-medium text-sm text-green-600" role="alert">
        {{ Session::get('message') }}
    </div>
@endif



        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
               
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-600">{{ __("vous avez pas de compte?") }} <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('sinscrire') }}</a></p>
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('se connecter') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
