<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des Commandes') }}
            </h2>
            <a href="{{ route('commandes.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
               style="background-color: #3b82f6 !important; color: white !important;">
                Nouvelle Commande
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Filtres -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('commandes.index') }}" class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-64">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Nom du stand...">
                            </div>
                            
                            <div class="min-w-48">
                                <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="statut" id="statut" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les statuts</option>
                                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                                    <option value="en_preparation" {{ request('statut') == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                    <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                                    <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                                </select>
                            </div>
                            
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded transition-colors duration-200"
                                        style="background-color: #6b7280 !important; color: white !important;">
                                    Filtrer
                                </button>
                                <a href="{{ route('commandes.index') }}" 
                                   class="ml-2 inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded transition-colors duration-200"
                                   style="background-color: #d1d5db !important; color: #1f2937 !important;">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Messages de succès/erreur -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Tableau des commandes -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Stand
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($commandes as $commande)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">#{{ $commande->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">{{ $commande->stand->nom_stand }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">{{ $commande->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900 font-semibold">{{ number_format($commande->total_prix, 2) }} €</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            @php
                                                $statutColors = [
                                                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmee' => 'bg-blue-100 text-blue-800',
                                                    'en_preparation' => 'bg-orange-100 text-orange-800',
                                                    'livree' => 'bg-green-100 text-green-800',
                                                    'annulee' => 'bg-red-100 text-red-800'
                                                ];
                                                $statutLabels = [
                                                    'en_attente' => 'En attente',
                                                    'confirmee' => 'Confirmée',
                                                    'en_preparation' => 'En préparation',
                                                    'livree' => 'Livrée',
                                                    'annulee' => 'Annulée'
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statutColors[$commande->statut] }}">
                                                {{ $statutLabels[$commande->statut] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 text-gray-900">{{ $commande->created_at->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('commandes.show', $commande) }}" 
                                                   class="text-blue-600 hover:text-blue-900 font-medium px-2 py-1 rounded hover:bg-blue-50 transition-colors">
                                                   Voir
                                                </a>
                                                <span class="text-gray-300">|</span>
                                                <a href="{{ route('commandes.edit', $commande) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 font-medium px-2 py-1 rounded hover:bg-indigo-50 transition-colors">
                                                   Modifier
                                                </a>
                                                <span class="text-gray-300">|</span>
                                                <form action="{{ route('commandes.destroy', $commande) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                            <div class="text-sm leading-5 text-gray-500">Aucune commande trouvée</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $commandes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 