@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <div class="w-full space-y-8">
        <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
            <span class="bg-gradient-to-r from-[#45C4EB] to-[#F7881B] text-transparent bg-clip-text ">
                {{ isset($user) ? 'Modifier l\'utilisateur' : 'Créer un utilisateur' }}
            </span>
            <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
        </h2>
        
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg">
            <div class="w-full space-y-8">

                <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required autofocus
                            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <input id="password" type="password" name="password" {{ isset($user) ? '' : 'required' }}
                            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <!-- Confirmation du mot de passe -->
                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                            <input id="password-confirm" type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
                            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                        </div>
        
                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select id="role" name="role" required
                            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" 
                                    {{ old('role', isset($user) ? $user->roles->first()->name : '') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
        
                    <!-- Bouton de soumission -->
                    <div class="mt-6 flex justify-center">
                        <button type="submit"
                            class="w-1/4 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#44C4EE] hover:bg-[#F78719] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ isset($user) ? 'Mettre à jour' : 'Créer l\'utilisateur' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
      
    </div>
</div>
@endsection