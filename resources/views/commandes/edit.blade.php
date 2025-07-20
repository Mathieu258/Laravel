<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier la Commande #') }}{{ $commande->id }}
            </h2>
            <div class="flex space-x-2">
                        <a href="{{ route('commandes.show', $commande) }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
           style="background-color: #3b82f6 !important; color: white !important;">
            Voir
        </a>
        <a href="{{ route('commandes.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded transition-colors duration-200"
           style="background-color: #6b7280 !important; color: white !important;">
            Retour
        </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('commandes.update', $commande) }}" method="POST" id="commandeForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Sélection du stand -->
                        <div class="mb-6">
                            <label for="stand_id" class="block text-sm font-medium text-gray-700 mb-2">Stand *</label>
                            <select name="stand_id" id="stand_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionner un stand</option>
                                @foreach($stands as $stand)
                                    <option value="{{ $stand->id }}" {{ (old('stand_id', $commande->stand_id) == $stand->id) ? 'selected' : '' }}>
                                        {{ $stand->nom_stand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Statut -->
                        <div class="mb-6">
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                            <select name="statut" id="statut" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="en_attente" {{ (old('statut', $commande->statut) == 'en_attente') ? 'selected' : '' }}>En attente</option>
                                <option value="confirmee" {{ (old('statut', $commande->statut) == 'confirmee') ? 'selected' : '' }}>Confirmée</option>
                                <option value="en_preparation" {{ (old('statut', $commande->statut) == 'en_preparation') ? 'selected' : '' }}>En préparation</option>
                                <option value="livree" {{ (old('statut', $commande->statut) == 'livree') ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ (old('statut', $commande->statut) == 'annulee') ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>

                        <!-- Sélection des produits -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Produits *</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div id="produits-container">
                                    <!-- Les produits seront ajoutés ici dynamiquement -->
                                </div>
                                
                                <button type="button" id="ajouter-produit" 
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded transition-colors duration-200"
                                        style="background-color: #22c55e !important; color: white !important;">
                                    + Ajouter un produit
                                </button>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Notes spéciales pour cette commande...">{{ old('notes', $commande->notes) }}</textarea>
                        </div>

                        <!-- Résumé de la commande -->
                        <div class="mb-6 bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Résumé de la commande</h3>
                            <div id="resume-commande">
                                <p class="text-gray-600">Sélectionnez des produits pour voir le résumé</p>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('commandes.show', $commande) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded transition-colors duration-200"
                               style="background-color: #6b7280 !important; color: white !important;">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded transition-colors duration-200"
                                    style="background-color: #3b82f6 !important; color: white !important;">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produitsContainer = document.getElementById('produits-container');
            const ajouterProduitBtn = document.getElementById('ajouter-produit');
            const resumeCommande = document.getElementById('resume-commande');
            const standSelect = document.getElementById('stand_id');
            const produits = @json($produits);
            const produitsParStand = @json($produitsParStand);
            const commandeProduits = @json($commande->details_commande['produits'] ?? []);
            let produitIndex = 0;

            // Fonction pour obtenir les produits du stand sélectionné
            function getProduitsDuStand(standId) {
                if (!standId) return [];
                return produitsParStand[standId] || [];
            }

            // Fonction pour créer les options de produits
            function creerOptionsProduits(produitsDuStand, selectedId = '') {
                if (produitsDuStand.length === 0) {
                    return '<option value="">Aucun produit disponible pour ce stand</option>';
                }
                
                return produitsDuStand.map(produit => `
                    <option value="${produit.id}" data-prix="${produit.prix}" ${selectedId == produit.id ? 'selected' : ''}>
                        ${produit.nom_produit} - ${produit.prix}€
                    </option>
                `).join('');
            }

            // Ajouter un produit
            function ajouterProduit(produitId = '', quantite = 1) {
                const standId = standSelect.value;
                const produitsDuStand = getProduitsDuStand(standId);
                
                const produitDiv = document.createElement('div');
                produitDiv.className = 'flex items-center space-x-4 mb-4 p-3 bg-white rounded border';
                produitDiv.innerHTML = `
                    <div class="flex-1">
                        <select name="details_commande[produits][produit_${produitIndex}]" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionner un produit</option>
                            ${creerOptionsProduits(produitsDuStand, produitId)}
                        </select>
                    </div>
                    <div class="w-24">
                        <input type="number" name="details_commande[quantites][produit_${produitIndex}]" 
                               min="1" value="${quantite}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Qté">
                    </div>
                    <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove(); updateResume();">
                        ✕
                    </button>
                `;
                
                produitsContainer.appendChild(produitDiv);
                produitIndex++;
                
                // Ajouter event listeners pour le nouveau produit
                const select = produitDiv.querySelector('select');
                const quantiteInput = produitDiv.querySelector('input[type="number"]');
                select.addEventListener('change', updateResume);
                quantiteInput.addEventListener('input', updateResume);
            }

            // Ajouter un produit vide
            ajouterProduitBtn.addEventListener('click', function() {
                ajouterProduit();
            });

            // Event listener pour le changement de stand
            standSelect.addEventListener('change', function() {
                const standId = this.value;
                const produitsDuStand = getProduitsDuStand(standId);
                
                // Mettre à jour tous les selects de produits existants
                const selects = produitsContainer.querySelectorAll('select');
                selects.forEach(select => {
                    const currentValue = select.value;
                    select.innerHTML = `
                        <option value="">Sélectionner un produit</option>
                        ${creerOptionsProduits(produitsDuStand)}
                    `;
                    select.value = currentValue; // Restaurer la valeur si possible
                });
                
                updateResume();
            });

            // Mettre à jour le résumé
            function updateResume() {
                let total = 0;
                let resume = '<div class="space-y-2">';
                
                const produitsDivs = produitsContainer.querySelectorAll('div');
                produitsDivs.forEach(div => {
                    const select = div.querySelector('select');
                    const quantite = div.querySelector('input[type="number"]');
                    
                    if (select.value && quantite.value) {
                        const produit = produits.find(p => p.id == select.value);
                        const qte = parseInt(quantite.value);
                        const sousTotal = produit.prix * qte;
                        total += sousTotal;
                        
                        resume += `
                            <div class="flex justify-between text-sm">
                                <span>${produit.nom_produit} x${qte}</span>
                                <span>${sousTotal.toFixed(2)}€</span>
                            </div>
                        `;
                    }
                });
                
                resume += `
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold">
                        <span>Total</span>
                        <span>${total.toFixed(2)}€</span>
                    </div>
                </div>`;
                
                resumeCommande.innerHTML = resume;
            }

            // Charger les produits existants
            Object.entries(commandeProduits).forEach(([produitId, quantite]) => {
                ajouterProduit(produitId, quantite);
            });

            // Si aucun produit, ajouter un produit vide
            if (Object.keys(commandeProduits).length === 0) {
                ajouterProduit();
            }

            // Mettre à jour le résumé initial
            setTimeout(updateResume, 100);
        });
    </script>
</x-app-layout> 