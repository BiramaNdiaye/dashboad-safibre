@extends('layouts.main')

@section('content')
<h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-gradient-to-r from-[#45C4EB] to-[#F7881B] text-transparent bg-clip-text uppercase">
        Créer un utilisateur
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">
    <div class="w-full space-y-8">
        
        <form method="POST" action="{{ route('users.store') }}" class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
               
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
        
               
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
        
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('password') border-red-500 @enderror">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
        
            
                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                </div>
        
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select id="role" name="role" required
                        class="uppercase mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('role') border-red-500 @enderror">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" class="uppercase">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
        
                <div id="client-field" style="display: none;">
                    <label for="clients_id" class="block text-sm font-medium text-gray-700">Clients</label>
                    <select name="clients_id" id="clients_id"
                        class="uppercase mt-1 block w-full px-4 py-2 border  rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 @error('clients_id') border-red-500 @enderror">
                        <option value="">Sélectionnez un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom }}</option>
                        @endforeach
                    </select>
                    @error('clients_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        
          
            <div class="flex justify-end">
                <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-2 rounded-lg shadow-md  transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    document.getElementById('role').addEventListener('change', function() {
        const clientField = document.getElementById('client-field');
        if (this.value === 'client') {
            clientField.style.display = 'block';
        } else {
            clientField.style.display = 'none';
        }
    });

    
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        roleSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
