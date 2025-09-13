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