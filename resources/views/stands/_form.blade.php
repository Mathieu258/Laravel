<form method="POST" action="{{ $action }}">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="mb-4">
        <label for="nom_stand" class="block text-gray-700 font-bold mb-2">Nom du stand</label>
        <input type="text" name="nom_stand" id="nom_stand" value="{{ old('nom_stand', $stand->nom_stand ?? '') }}" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        @error('nom_stand')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-4">
        <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
        <textarea name="description" id="description" rows="3"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $stand->description ?? '') }}</textarea>
        @error('description')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex justify-end">
        <button type="submit" style="background-color: #16a34a; color: #fff;" class="font-bold py-2 px-6 rounded shadow">
            {{ $buttonText }}
        </button>
    </div>
</form> 