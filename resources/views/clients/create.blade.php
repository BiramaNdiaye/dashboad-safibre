@extends('layouts.main')

@section('content')
<h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
    <span class="bg-gradient-to-r from-[#45C4EB] to-[#F7881B] text-transparent bg-clip-text ">
       Ajouter un nouveau client
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

    @if ($errors->any())
        <div class="mb-6">
            <ul class="bg-red-500 text-white p-4 rounded-md shadow-md">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6">
            <div class="bg-green-500 text-white p-4 rounded-md shadow-md">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST" class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom client</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            </div>
            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700">Référence</label>
                <input type="text" id="reference" name="reference" value="{{ old('reference') }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone Responsable</label>
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            </div>
            <div>
                <label for="date_integration" class="block text-sm font-medium text-gray-700">Date d'intégration</label>
                <input type="date" id="date_integration" name="date_integration" value="{{ old('date_integration') }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            </div>
        </div>

        <div>
            <label for="responsable" class="block text-sm font-medium text-gray-700">Responsable</label>
            <input type="text" id="responsable" name="responsable" value="{{ old('responsable') }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-2 rounded-lg shadow-md  transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Ajouter
            </button>
        </div>
    </form>
</div>
@endsection