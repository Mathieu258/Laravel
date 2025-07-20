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
                    <h1 class="text-2xl font-bold mb-6">Bienvenue sur le dashboard administrateur !</h1>
                    <p class="mb-8 text-gray-600">Vous êtes connecté en tant qu'administrateur.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Gestion des Stands -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-3">Gestion des Stands</h3>
                            <p class="text-blue-600 mb-4">Gérez les stands de votre événement</p>
                            <a href="{{ route('stands.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #3b82f6 !important;">
                                Gérer les Stands
                            </a>
                        </div>

                        <!-- Gestion des Produits -->
                        <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                            <h3 class="text-lg font-semibold text-orange-800 mb-3">Gestion des Produits</h3>
                            <p class="text-orange-600 mb-4">Gérez les produits de vos stands</p>
                            <a href="{{ route('produits.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #f97316 !important;">
                                Gérer les Produits
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 