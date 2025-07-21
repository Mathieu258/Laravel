<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Administration - {{ Auth::user()->name }}</h1>
                    <p class="mb-8 text-gray-600">Interface d'administration complète</p>
                    
                    <!-- Statistiques rapides -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800">Total Stands</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Stand::count() }}</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                            <h4 class="text-sm font-semibold text-orange-800">Total Produits</h4>
                            <p class="text-2xl font-bold text-orange-600">{{ \App\Models\Produit::count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="text-sm font-semibold text-green-800">Total Commandes</h4>
                            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Commande::count() }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h4 class="text-sm font-semibold text-purple-800">Utilisateurs</h4>
                            <p class="text-2xl font-bold text-purple-600">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Gestion des Stands -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-3">Gestion des Stands</h3>
                            <p class="text-blue-600 mb-4">Administration complète des stands</p>
                            <a href="{{ route('stands.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #3b82f6 !important;">
                                Gérer les Stands
                            </a>
                        </div>

                        <!-- Gestion des Produits -->
                        <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                            <h3 class="text-lg font-semibold text-orange-800 mb-3">Gestion des Produits</h3>
                            <p class="text-orange-600 mb-4">Administration complète des produits</p>
                            <a href="{{ route('produits.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #f97316 !important;">
                                Gérer les Produits
                            </a>
                        </div>

                        <!-- Gestion des Commandes -->
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                            <h3 class="text-lg font-semibold text-green-800 mb-3">Gestion des Commandes</h3>
                            <p class="text-green-600 mb-4">Suivi et administration des commandes</p>
                            <a href="{{ route('admin.commandes') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #22c55e !important;">
                                Gérer les Commandes
                            </a>
                        </div>
                    </div>

                    <!-- Actions d'administration -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions d'Administration</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">Gestion des Utilisateurs</h4>
                                <p class="text-sm text-gray-600 mb-3">Approuver les entrepreneurs, gérer les rôles</p>
                                <a href="{{ route('admin.demandes') }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-700 text-white rounded text-sm transition-colors duration-200">
                                    Gérer les Demandes
                                </a>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-2">Statistiques Avancées</h4>
                                <p class="text-sm text-gray-600 mb-3">Rapports détaillés et analyses</p>
                                <a href="{{ route('admin.commandes') }}" 
                                   class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-700 text-white rounded text-sm transition-colors duration-200">
                                    Voir les Statistiques
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 