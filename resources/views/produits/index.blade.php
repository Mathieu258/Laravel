<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des Produits') }}
            </h2>
            <a href="{{ route('produits.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200" style="background-color: #3b82f6 !important;">
                Nouveau Produit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Messages de succès -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulaire de recherche et filtres -->
                    <form method="GET" action="{{ route('produits.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Nom ou description...">
                            </div>
                            <div>
                                <label for="stand_id" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par Stand</label>
                                <select name="stand_id" id="stand_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Tous les stands</option>
                                    @foreach($stands as $stand)
                                        <option value="{{ $stand->id }}" {{ request('stand_id') == $stand->id ? 'selected' : '' }}>
                                            {{ $stand->nom_stand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 transition-colors duration-200" style="background-color: #6b7280 !important;">
                                    Rechercher
                                </button>
                                <a href="{{ route('produits.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200" style="background-color: #d1d5db !important;">
                                    Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tableau des produits -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Nom & Description
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Stand
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Prix
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($produits as $produit)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            @if($produit->image)
                                                <img src="{{ asset('images/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" 
                                                     class="rounded object-cover" style="width: 34px; height: 34px;">
                                            @else
                                                <div class="rounded bg-gray-200 flex items-center justify-center" style="width: 34px; height: 34px;">
                                                    <span class="text-gray-500 text-xs">📦</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <div>
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ $produit->nom }}
                                                </div>
                                                @if($produit->description)
                                                    <div class="text-sm leading-5 text-gray-500">
                                                        {{ Str::limit($produit->description, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 bg-blue-100 text-blue-800 rounded-full">
                                                {{ $produit->stand->nom_stand }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            <span class="text-sm leading-5 text-gray-900 font-semibold">
                                                {{ number_format($produit->prix, 2) }} €
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('produits.show', $produit) }}" 
                                                   class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded transition-colors duration-200" style="background-color: #dbeafe !important;">
                                                    Voir
                                                </a>
                                                <a href="{{ route('produits.edit', $produit) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 px-2 py-1 rounded transition-colors duration-200" style="background-color: #fef3c7 !important;">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-2 py-1 rounded transition-colors duration-200" style="background-color: #fee2e2 !important;"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Aucun produit trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $produits->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 