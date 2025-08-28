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

// Suppression officiel d'un produit
// function deleteProduct(id) {
//     if(confirm("Etes vous sur de vouloir supprimer ce produit ?")) {
//         document.getElementById("delete-product-form-"+id).submit();
//     }
// }

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