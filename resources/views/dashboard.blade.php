<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6">Bienvenue {{ Auth::user()->name }} !</h1>
                    <p class="mb-8 text-gray-600 dark:text-gray-400">
                        @if(Auth::user()->role === 'admin')
                            Vous êtes connecté en tant qu'administrateur.
                        @elseif(Auth::user()->role === 'entrepreneur' && Auth::user()->statut === 'approuve')
                            Vous êtes connecté en tant qu'entrepreneur.
                        @elseif(Auth::user()->role === 'entrepreneur' && Auth::user()->statut === 'en_attente')
                            Votre compte est en attente d'approbation.
                        @else
                            Vous êtes connecté.
                        @endif
                    </p>
                    
                    @if(Auth::user()->role === 'admin' || (Auth::user()->role === 'entrepreneur' && Auth::user()->statut === 'approuve'))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Gestion des Stands -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg border border-blue-200 dark:border-blue-700">
                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">Gestion des Stands</h3>
                                <p class="text-blue-600 dark:text-blue-300 mb-4">Gérez les stands de votre événement</p>
                                <a href="{{ route('stands.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
                                   style="background-color: #3b82f6 !important;">
                                    Gérer les Stands
                                </a>
                            </div>

                            <!-- Gestion des Produits -->
                            <div class="bg-orange-50 dark:bg-orange-900/20 p-6 rounded-lg border border-orange-200 dark:border-orange-700">
                                <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-3">Gestion des Produits</h3>
                                <p class="text-orange-600 dark:text-orange-300 mb-4">Gérez les produits de vos stands</p>
                                <a href="{{ route('produits.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white font-bold rounded transition-colors duration-200"
                                   style="background-color: #f97316 !important;">
                                    Gérer les Produits
                                </a>
                            </div>

                            <!-- Gestion des Commandes -->
                            <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-lg border border-green-200 dark:border-green-700">
                                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">Gestion des Commandes</h3>
                                <p class="text-green-600 dark:text-green-300 mb-4">Suivez et gérez les commandes</p>
                                <a href="{{ route('commandes.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded transition-colors duration-200"
                                   style="background-color: #22c55e !important;">
                                    Gérer les Commandes
                                </a>
                            </div>
                        </div>
                    @elseif(Auth::user()->role === 'entrepreneur' && Auth::user()->statut === 'en_attente')
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-lg border border-yellow-200 dark:border-yellow-700">
                            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-3">Compte en attente</h3>
                            <p class="text-yellow-600 dark:text-yellow-300">
                                Votre compte entrepreneur est en attente d'approbation par l'administrateur. 
                                Vous recevrez un email dès que votre compte sera approuvé.
                            </p>
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Bienvenue !</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Vous êtes connecté à l'application Eat and Drink.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
