<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le stand') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded-lg p-8">
            @include('stands._form', [
                'action' => route('stands.update', $stand),
                'method' => 'PUT',
                'buttonText' => 'Mettre à jour',
                'stand' => $stand
            ])
        </div>
    </div>
</x-app-layout> 