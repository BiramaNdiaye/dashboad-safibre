@extends('layouts.main')

@section('content')

<div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-xl font-bold mb-4">Gestion des Permissions</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Rôle</label>
            <select name="role_id" class="w-full border-gray-300 rounded-lg p-2">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Permissions</label>
            @foreach($permissions as $permission)
                <div class="flex items-center">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="mr-2" id="permission_{{ $permission->id }}">
                    <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Attribuer les Permissions
        </button>
    </form>
</div>


@endsection