@extends('layouts.main')

@section('content')

{{-- Styles --}}
<style>
    .proj-page { padding: 2rem 0; }
    .proj-header { text-align: center; margin-bottom: 2.5rem; }
    .proj-header h2 { font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 8px; letter-spacing: -0.3px; }
    .proj-header .accent-bar { width: 40px; height: 3px; background: #F7881B; border-radius: 999px; margin: 0 auto; }

    .proj-wrap { max-width: 1200px; margin: 0 auto; }

    /* Nom + badges */
    .proj-name { font-size: 22px; font-weight: 700; color: #111827; margin: 0 0 0.75rem; }
    .badge-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 1.75rem; }
    .badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600;
             padding: 3px 11px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-blue  { background: #dbeafe; color: #1e40af; }
    .badge-orange{ background: #fff4e8; color: #c2560a; }
    .badge-green { background: #dcfce7; color: #15803d; }
    .badge-gray  { background: #f3f4f6; color: #4b5563; }

    /* Cards */
    .proj-card { background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px;
                 padding: 1.4rem 1.5rem; margin-bottom: 1.25rem;
                 box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
                 transition: box-shadow 0.2s ease; }
    .proj-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.10), 0 2px 6px rgba(0,0,0,0.06); }
    .proj-card-header { display: flex; align-items: center; gap: 10px;
                        padding-bottom: 1rem; margin-bottom: 1.25rem;
                        border-bottom: 0.5px solid #e5e7eb; }
    .card-icon { width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
                 display: flex; align-items: center; justify-content: center; }
    .card-icon-orange { background: #fff4e8; color: #F7881B; }
    .card-icon-teal   { background: #e0f2fe; color: #0284c7; }
    .card-icon-green  { background: #dcfce7; color: #15803d; }
    .card-icon svg { width: 18px; height: 18px; }
    .card-label { font-size: 12px; font-weight: 700; letter-spacing: 0.8px;
                  text-transform: uppercase; color: #F7881B; }
    .card-label-teal  { color: #0284c7; }
    .card-label-green { color: #15803d; }

    /* Fields grid */
    .fields-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
    .field { display: flex; flex-direction: column; gap: 5px; }
    .field label { font-size: 10px; font-weight: 700; text-transform: uppercase;
                   letter-spacing: 0.7px; color: #6b7280; }
    .field-val { font-size: 13px; color: #111827; background: #f9fafb;
                 border: 0.5px solid #e5e7eb; border-radius: 8px;
                 padding: 8px 12px; text-transform: uppercase; }

    /* Footer */
    .proj-footer { display: flex; justify-content: flex-end; margin-top: 1.75rem; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px;
                background: #45C4EB; color: #fff; border: none; border-radius: 8px;
                padding: 10px 22px; font-size: 13px; font-weight: 600;
                cursor: pointer; text-decoration: none;
                transition: background 0.2s ease; }
    .btn-back:hover { background: #F7881B; color: #fff; }
    .btn-back svg { width: 16px; height: 16px; }
</style>

<div class="proj-page">
    <div class="proj-header">
        <h2>Détail du projet</h2>
        <div class="accent-bar"></div>
    </div>

    <div class="proj-wrap">

        {{-- Nom du projet + badges --}}
        <p class="proj-name">{{ $projet->nom }}</p>
        <div class="badge-row">
            <span class="badge badge-blue">{{ $projet->reference }}</span>
            <span class="badge badge-orange">{{ $projet->type_projet }}</span>
            @php
                $statutClass = match(strtolower($projet->statut_projet)) {
                    'terminé', 'livré'   => 'badge-green',
                    'en cours'           => 'badge-blue',
                    'annulé'             => 'badge-gray',
                    default              => 'badge-gray',
                };
            @endphp
            <span class="badge {{ $statutClass }}">{{ $projet->statut_projet }}</span>
        </div>

        {{-- Carte projet --}}
        <div class="proj-card">
            <div class="proj-card-header">
                <div class="card-icon card-icon-orange">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                    </svg>
                </div>
                <span class="card-label">Projet</span>
            </div>

            <div class="fields-grid">
                <div class="field">
                    <label>Référence</label>
                    <div class="field-val">{{ $projet->reference }}</div>
                </div>
                <div class="field">
                    <label>Client</label>
                    <div class="field-val">{{ $projet->client->nom }}</div>
                </div>
                <div class="field">
                    <label>Chef de projet</label>
                    <div class="field-val">{{ $projet->chefProjet->name }}</div>
                </div>
                <div class="field">
                    <label>Date de commande</label>
                    <div class="field-val">{{ $projet->date_commande }}</div>
                </div>
                <div class="field">
                    <label>Date de livraison</label>
                    <div class="field-val">{{ $projet->date_livraison }}</div>
                </div>
                <div class="field">
                    <label>Statut projet</label>
                    <div class="field-val">{{ $projet->statut_projet }}</div>
                </div>
                <div class="field">
                    <label>Type projet</label>
                    <div class="field-val">{{ $projet->type_projet }}</div>
                </div>
                
                <div class="field">
                <label>Code site</label>
                <div class="field-val">
                    {{ $projet->code_site ?? '—' }}
                </div>
                </div>
            </div>
        </div>

        {{-- Cartes tâches --}}
        @php
            $tacheColors = [
                ['icon' => 'card-icon-teal',  'label' => 'card-label-teal'],
                ['icon' => 'card-icon-green', 'label' => 'card-label-green'],
                ['icon' => 'card-icon-orange','label' => ''],
            ];
        @endphp

        @foreach($projet->taches as $i => $tache)
            @php $color = $tacheColors[$i % count($tacheColors)]; @endphp
            <div class="proj-card">
                <div class="proj-card-header">
                    <div class="card-icon {{ $color['icon'] }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                     M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2
                                     m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <span class="card-label {{ $color['label'] }}">
                        {{ $tache->typeTache->nom ?? 'Inconnu' }}
                    </span>
                </div>

                <div class="fields-grid">
                    @foreach($tache->informations as $key => $value)
                        @if($key === 'moment_annulation' && ($tache->informations['statut_rop'] ?? '') !== 'Annulation ROP')
                            @continue
                        @endif
                        <div class="field">
                            <label>{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                            <div class="field-val">{{ $value ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Footer --}}
        <div class="proj-footer">
            @role('client')
                @php $routeProjet = url()->previous(); @endphp
                <a href="{{ $routeProjet }}" class="btn-back">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à mes projets
                </a>
            @else
                <a href="{{ route('projets.index') }}" class="btn-back">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>
            @endrole
        </div>

    </div>
</div>

@endsection
