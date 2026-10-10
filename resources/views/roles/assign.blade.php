@extends('layouts.main')

@section('content')

<div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-xl font-bold mb-4">Assigner un rôle à un utilisateur</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Utilisateur</label>
            <select name="user_id" class="w-full border-gray-300 rounded-lg p-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Rôle</label>
            <select name="role" class="w-full border-gray-300 rounded-lg p-2">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Assigner le rôle
        </button>
    </form>

    
</div>


@endsection