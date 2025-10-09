document.addEventListener('DOMContentLoaded', () => {
    let menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(menuItem => {
        menuItem.addEventListener('click', () => {
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            menuItem.classList.add('active')
        })
    })
})

function toggleProducts(button) {
    const container = button.parentElement;
    const preview = container.querySelector('.products-preview');
    const icon = button.querySelector('.expand-icon');
    const expandText = button.querySelector('.expand-text');
    const allProducts = preview.querySelectorAll('.product-line');
    
    const isExpanded = preview.classList.contains('expanded');
    
    if (isExpanded) {
        // Réduire - masquer les produits après les 2 premiers
        preview.classList.remove('expanded');
        icon.classList.remove('rotated');
        
        // Masquer tous les produits après le 2ème
        allProducts.forEach((product, index) => {
            if (index >= 2) {
                product.style.display = 'none';
            }
        });
        
        const hiddenCount = allProducts.length - 2;
        expandText.textContent = `Voir plus (${hiddenCount} produit${hiddenCount > 1 ? 's' : ''})`;
        
    } else {
        // Étendre - afficher tous les produits
        preview.classList.add('expanded');
        icon.classList.add('rotated');
        
        // Afficher tous les produits
        allProducts.forEach(product => {
            product.style.display = 'flex';
        });
        
        expandText.textContent = 'Voir moins';
    }
}


let currentProductId = null;

function deleteProduct(id) {
    currentProductId = id;
    showModal();
}

function showModal() {
    document.getElementById('deleteModal').classList.add('active');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
    currentProductId = null;
}

function confirmDelete() {
    if (currentProductId) {
        document.getElementById("delete-product-form-" + currentProductId).submit();
    }
    closeModal();
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Fermer avec la touche Échap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Gestion input file
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('.file-input');
    
    fileInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            const info = document.getElementById(`info${index + 1}`);
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                label.classList.add('file-selected');
                
                // Mettre à jour le texte selon le style
                if (label.classList.contains('file-label')) {
                    label.innerHTML = `
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Fichier sélectionné
                    `;
                } else if (label.classList.contains('file-input-flat')) {
                    label.innerHTML = `
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        Sélectionné
                    `;
                } else if (label.classList.contains('file-input-minimal')) {
                    label.innerHTML = `
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Ajouté
                    `;
                } else if (label.classList.contains('file-input-glass')) {
                    label.innerHTML = `
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Attaché
                    `;
                }
                
                // Mettre à jour les informations
                if (fileName.length > 25) {
                    info.textContent = fileName.substring(0, 25) + '...' + ` (${fileSize} MB)`;
                } else {
                    info.textContent = `${fileName} (${fileSize} MB)`;
                }
                
            } else {
                // Réinitialiser si aucun fichier
                label.classList.remove('file-selected');
                // Remettre le texte original...
            }
        });
    });
});


// Requte AJAX pour confirmer une commande 
async function confirmOrder(orderId, buttonElement) {
    const originalText = buttonElement.textContent;
    buttonElement.disabled = true;
    buttonElement.textContent = '...';
    buttonElement.style.opacity = '0.6';
    
    try {
        const response = await fetch(`/orders/${orderId}/confirm`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification(data.message, 'info');

            setTimeout(() => {
                location.reload();
            }, 4500);
        } else {
            // Erreur côté serveur
            throw new Error(data.message || 'Erreur lors de la mise à jour');
        }
        
    } catch (error) {
        console.error('Erreur AJAX:', error);
        
        // Restaurer le bouton
        buttonElement.disabled = false;
        buttonElement.textContent = originalText;
        buttonElement.style.opacity = '1';
        
        showNotification('Une erreur s\'est produite', 'error');
    }
}

// Requte AJAX pour marquer comme pret une commande 
async function markOrderReady(orderId, buttonElement) {
    const originalText = buttonElement.textContent;
    buttonElement.disabled = true;
    buttonElement.textContent = '...';
    buttonElement.style.opacity = '0.6';
    
    try {
        const response = await fetch(`/orders/${orderId}/mark-ready`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showNotification(data.message, 'info');

            setTimeout(() => {
                location.reload();
            }, 4500);
        } else {
            // Erreur côté serveur
            throw new Error(data.message || 'Erreur lors de la mise à jour');
        }
        
    } catch (error) {
        console.error('Erreur AJAX:', error);
        
        // Restaurer le bouton
        buttonElement.disabled = false;
        buttonElement.textContent = originalText;
        buttonElement.style.opacity = '1';
        
        showNotification('Une erreur s\'est produite', 'error');
    }
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
 
    const alertNotification = document.getElementById('alert-notification');
    alertNotification.innerHTML = message;
    alertNotification.className = `alert alert-${type}`;
    alertNotification.style.display = 'block';
    
    // Animation d'entrée
    setTimeout(() => {
        alertNotification.classList.add('show');
    }, 100);

    setTimeout(() => {
        alertNotification.style.display = 'none';
        // location.reload();
    }, 4000);
}

// Validation rapide par recherche de code
async function quickValidate() {
    const quickInput = document.getElementById('quick-code-input');
    const code = quickInput.value.trim();
    
    if (code.length !== 4) {
        showNotification('Le code doit contenir 4 chiffres', 'error');
        return;
    }
    
    try {
        // Chercher la commande par code
        const searchResponse = await fetch(`/orders/find-by-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ pickup_code: code })
        });
        
        const searchData = await searchResponse.json();
        
        if (!searchData.success) {
            showNotification(searchData.message, 'error');
            return;
        }
        
        // Afficher les détails et demander confirmation
        const order = searchData.order;
        const resultDiv = document.getElementById('quick-result');
        
        resultDiv.innerHTML = `
            <div class="order-preview">
                <h4>✅ Commande trouvée</h4>
                <p><strong>Stand:</strong> ${order.stand_name}</p>
                <p><strong>N° Commande:</strong> ${order.order_number}</p>
                <p><strong>Client:</strong> ${order.client_name}</p>
                <p><strong>Articles:</strong> ${order.items_count} produit(s)</p>
                <p><strong>Montant:</strong> ${order.total_amount} CFA</p>
                <p><strong>Code saisi:</strong> ${order.code}</p>
                <div class="preview-actions">
                    <button class="btn-validate-final" onclick="finalizeQuickPickup(${order.id}, '${code}')">
                        <i class="fas fa-check-double"></i> Confirmer la livraison
                    </button>
                    <button class="btn-cancel" onclick="cancelQuickValidation()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                </div>
            </div>
        `;
        
    } catch (error) {
        showNotification('Erreur lors de la recherche', 'error');
    }
}

// Finaliser la validation rapide
async function finalizeQuickPickup(orderId, code) {
    try {
        const response = await fetch(`/orders/${orderId}/validate-pickup-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ pickup_code: code })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Nettoyer l'interface
            document.getElementById('quick-code-input').value = '';
            document.getElementById('quick-result').innerHTML = '';
            
            setTimeout(() => location.reload(), 2000);
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        showNotification('Erreur lors de la validation finale', 'error');
    }
}

function cancelQuickValidation() {
    document.getElementById('quick-result').innerHTML = '';
    document.getElementById('quick-code-input').value = '';
}

// Auto-focus et validation sur Enter
document.addEventListener('DOMContentLoaded', function() {
    // Focus automatique sur les inputs de code
    document.querySelectorAll('.code-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const orderId = this.id.replace('code-input-', '');
                validateCode(orderId);
            }
        });
    });
    
    // Quick validation sur Enter
    document.getElementById('quick-code-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            quickValidate();
        }
    });
});





