<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Liste des stands') }}
            </h2>
            <a href="{{ route('stands.create') }}" class="bg-white hover:bg-green-100 text-green-600 font-bold py-2 px-4 rounded shadow text-center border border-green-600">
                + Ajouter un stand
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('stands.index') }}" class="mb-6 flex items-center gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher un stand..."
                    class="w-full sm:w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Rechercher</button>
            </form>
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stands as $stand)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stand->nom_stand }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $stand->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('stands.edit', $stand) }}" style="background-color: #16a34a; color: #fff;" class="inline-block font-bold px-3 py-1 rounded mr-2">
                                        Modifier
                                    </a>
                                    <form action="{{ route('stands.destroy', $stand) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce stand ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun stand trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $stands->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 