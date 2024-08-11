<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3&display=swap');
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="contentHeader">
            <!-- Linkerkant: logo en eventueel andere links -->
            <div>
                <a href="{{ url('/contribution_overview') }}" class="headerItem">
                    <img src="{{ asset('assets/Logo_JesSa.png') }}" width="100px" alt="Logo JesSa Sports Club"/>
                </a>
            </div>

            <!-- Rechterkant: gebruikersnaam en actieknoppen -->
            @auth
            <div>
                <span class="generalContent">{{ Auth::user()->username }}</span> 
                <!--<a href="{{ route('profile.edit') }}">Profiel Bewerken</a>-->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="headerButton headerItem">Uitloggen</button>
                </form>
            </div>
            @endauth
            @guest
            <div>
                <a href="{{ route('login') }}">Inloggen</a>
                <a href="{{ route('register') }}">Registreren</a>
            </div>
            @endguest
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
        </footer>
    </body>
</html>