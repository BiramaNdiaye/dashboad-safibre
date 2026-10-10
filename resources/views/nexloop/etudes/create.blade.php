@extends('layouts.main')

@section('content')
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Ajouter  une Etude de Faisabilite
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>


 @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-6">


<form action="{{ route('etudes-faisabilite.store') }}" method="POST" class="space-y-5">
    @csrf
  
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Commune</label>
       <input type="text" name="commune" value="{{ old('ref_projet', $etudesfai->commune ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Ref Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Code Postal</label>
        <input type="text" name="code_postal" value="{{ old('code_postal', $etudesfai->code_postal ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Site -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Code Ensei</label>
        <input type="text" name="code_ensei" value="{{ old('etudesfai' , $etudesfai->code_ensei ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Date Réception -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Numero Etude</label>
         <input type="text" name="numero_etude" value="{{ old('numero_etude', $etudesfai->numero_etude ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    

</div>

    <div class="flex justify-end pt-3">
            <button type="submit"
                class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg transition transform hover:scale-105 shadow-md">
                Enregistrer
            </button>
        </div>
</form>
</div>
@endsection
