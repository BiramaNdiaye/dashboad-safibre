@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg mt-10"> 
    <div class="w-full space-y-6"> 
        <div class="text-center">
            <h2 class="mt-4 text-4xl font-extrabold text-gray-900"> 
                {{ __('Bienvenue sur notre portail client') }}
            </h2>
            <img src="{{ asset('images/csma.png') }}" alt="Logo" class="w-64 h-auto mx-auto">
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4"> 
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ __('Email') }}
                </label>
                <div class="mt-1">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1" role="alert"> 
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ __('Mot de passe') }}
                </label>
                <div class="mt-1">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <span class="text-red-500 text-xs mt-1" role="alert"> 
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            

            <!-- Submit Button -->
            <div class="text-center"> 
                <button type="submit"
                    class="w-1/2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#F78719] hover:bg-[#F78719] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> <!-- Changé w-1/4 en w-1/2 et ajusté le padding -->
                    {{ __('Se connecter') }}
                </button>
            </div>

           
        </form>
    </div>
</div>
@endsection