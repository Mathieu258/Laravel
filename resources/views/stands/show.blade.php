<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail du stand') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <h3 class="text-2xl font-bold mb-4">{{ $stand->nom }}</h3>
                <p class="mb-4 text-gray-700">{{ $stand->description }}</p>
                <div class="flex space-x-2">
                    <a href="{{ route('stands.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Retour</a>
                    <a href="{{ route('stands.edit', $stand) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">Modifier</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 