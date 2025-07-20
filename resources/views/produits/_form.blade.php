<div class="space-y-6">
    <div>
        <x-input-label for="nom" :value="__('Nom du produit')" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" 
                      :value="old('nom', $produit->nom ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="3" 
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  placeholder="Description du produit...">{{ old('description', $produit->description ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div>
        <x-input-label for="prix" :value="__('Prix (€)')" />
        <x-text-input id="prix" name="prix" type="number" step="0.01" min="0" class="mt-1 block w-full" 
                      :value="old('prix', $produit->prix ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('prix')" />
    </div>

    <div>
        <x-input-label for="image" :value="__('Image du produit')" />
        <input type="file" id="image" name="image" accept="image/*" 
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <x-input-error class="mt-2" :messages="$errors->get('image')" />
        @if(isset($produit) && $produit->image)
            <div class="mt-2">
                <img src="{{ asset('images/produits/' . $produit->image) }}" alt="Image actuelle" class="w-32 h-32 object-cover rounded">
                <p class="text-sm text-gray-500 mt-1">Image actuelle</p>
            </div>
        @endif
    </div>

    <div>
        <x-input-label for="stand_id" :value="__('Stand')" />
        <select id="stand_id" name="stand_id" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">Sélectionner un stand</option>
            @foreach($stands as $stand)
                <option value="{{ $stand->id }}" 
                        {{ old('stand_id', $produit->stand_id ?? '') == $stand->id ? 'selected' : '' }}>
                    {{ $stand->nom_stand }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('stand_id')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
        <a href="{{ route('produits.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Annuler
        </a>
    </div>
</div> 