document.addEventListener('DOMContentLoaded', () => {
    let menuItems = document.querySelectorAll('.nav-item:not(.logout-item)');

    menuItems.forEach(menuItem => {
        menuItem.addEventListener('click', (e) => {
            // Empêche le déclenchement sur le menu déroulant
            if (e.target.closest('.sidebar-section')) return;
            
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            menuItem.classList.add('active');
        });
    });
});


// Sliders commandes confirmées et pretes
let sliders = [];

document.addEventListener('DOMContentLoaded', function() {
    initAllSliders();
});

function initAllSliders() {
    initSlider('ordersReadySlider');
    initSlider('ordersConfirmedSlider');
}

function initSlider(containerId) {
    const container = document.getElementById(containerId);
    
    const slider = container.querySelector('.orders-slider');
    
    const sliderCards = slider.querySelectorAll('.slider-card');
    
    const sliderState = {
        id: containerId,
        currentSlide: 0,
        totalSlides: sliderCards.length,
        element: slider,        
        container: container    
    };
    
    sliders.push(sliderState);
    toggleNavigation(sliderState, sliderState.totalSlides > 1);
    updateSlides(sliderState);
    updateIndicators(sliderState);
    
    if (sliderState.totalSlides > 1) {
        attachSliderEvents(sliderState);
    }
}

function attachSliderEvents(sliderState) {

    const container = sliderState.container;
    
    const chevronPrev = container.querySelector('.slider-nav.prev');
    const chevronNext = container.querySelector('.slider-nav.next');
    const indicators = container.querySelector('.slider-indicators');

    if (chevronPrev) {
        chevronPrev.addEventListener('click', () => {
            slideTo(sliderState, sliderState.currentSlide - 1);
        });
    }

    if (chevronNext) {
        chevronNext.addEventListener('click', () => {
            slideTo(sliderState, sliderState.currentSlide + 1);
        });
    }

    if (indicators) {
        const indicatorItems = indicators.querySelectorAll('.indicator');
        
        indicatorItems.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                slideTo(sliderState, index);
            });
        });
    }
}

function slideTo(sliderState, index) {
    const { totalSlides } = sliderState;
    if (totalSlides <= 1) return;
    
    // Gestion des limites avec boucle
    if (index < 0) {
        sliderState.currentSlide = totalSlides - 1;
    } else if (index >= totalSlides) {
        sliderState.currentSlide = 0;
    } else {
        sliderState.currentSlide = index;
    }
    
    updateSlides(sliderState);
    updateIndicators(sliderState);
}

function updateSlides(sliderState) {

    const slides = sliderState.element.querySelectorAll('.slider-card');
    slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === sliderState.currentSlide);
    });
}

function updateIndicators(sliderState) {

    const indicators = sliderState.container.querySelectorAll('.slider-indicators .indicator');
    indicators.forEach((indicator, index) => {
        indicator.classList.toggle('active', index === sliderState.currentSlide);
    });
}

function toggleNavigation(sliderState, show) {
    const prevBtn = sliderState.container.querySelector('.slider-nav.prev');
    const nextBtn = sliderState.container.querySelector('.slider-nav.next');
    const indicators = sliderState.container.querySelector('.slider-indicators');
    
    if (prevBtn) prevBtn.style.display = show ? 'flex' : 'none';
    if (nextBtn) nextBtn.style.display = show ? 'flex' : 'none';
    if (indicators) indicators.style.display = show ? 'flex' : 'none';
}

// Navigation au clavier
document.addEventListener('keydown', function(e) {
    if (sliders.length === 0) return;
    
    if (e.key === 'ArrowLeft') {
        if (e.shiftKey) {

            slideTo(sliders[0], sliders[0].currentSlide - 1);
        } else if (e.ctrlKey) {

            if (sliders[1]) slideTo(sliders[1], sliders[1].currentSlide - 1);
        } else {

            sliders.forEach(slider => {
                slideTo(slider, slider.currentSlide - 1);
            });
        }
    } else if (e.key === 'ArrowRight') {
        if (e.shiftKey) {
            slideTo(sliders[0], sliders[0].currentSlide + 1);

        } else if (e.ctrlKey) {
            if (sliders[1]) slideTo(sliders[1], sliders[1].currentSlide + 1);

        } else {

            sliders.forEach(slider => {
                slideTo(slider, slider.currentSlide + 1);
            });
        }
    }

});


// Gestion ouverture section sidebar commandes actives
function openOrdersMenu() {
    const submenu = document.getElementById('orders-submenu');
    const toggleIcon = document.getElementById('orders-toggle-icon');
    const logoutItem = document.querySelector('.logout-item');
    const sidebarSection = document.querySelector('.sidebar-section');
    
    submenu.style.display = 'block';
    toggleIcon.classList.add('active');
    sidebarSection.style.height = "auto";
    logoutItem.style.marginTop = "-20px";
}

function closeOrdersMenu() {
    const submenu = document.getElementById('orders-submenu');
    const toggleIcon = document.getElementById('orders-toggle-icon');
    const logoutItem = document.querySelector('.logout-item');
    const sidebarSection = document.querySelector('.sidebar-section');
    
    submenu.style.display = 'none';
    toggleIcon.classList.remove('active');
    sidebarSection.style.height = "38px";
    logoutItem.style.marginTop = "auto";
}

function toggleOrdersMenu() {
    const submenu = document.getElementById('orders-submenu');
    
    if (submenu.style.display === 'none' || window.getComputedStyle(submenu).display === 'none') {
        openOrdersMenu();
    } else {
        closeOrdersMenu();
    }
}

// Ouvrir automatiquement si une sous-section est active
document.addEventListener('DOMContentLoaded', function() {
    const activeSubItem = document.querySelector('.submenu-item.active');
    if (activeSubItem) {
        openOrdersMenu(); 
    } else {
        closeOrdersMenu();
    }
});


// Commander à nouveau une commande déjà faite
async function reorder(orderId) {

    showConfirmModal({
        title: 'Commander à nouveau',
        message: 'Voulez-vous recommander les mêmes produits ?',
        confirmText: 'Oui, recommander',
        cancelText: 'Non, annuler',
        confirmClass: 'btn-primary',

        onConfirm: async () => {
            // Afficher loader
            showLoadingModal('Création de la commande en cours...');
            
            try {
                const response = await fetch(`/orders/${orderId}/reorder`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                // Fermer loader
                closeLoadingModal();
                
                if (data.success) {
                    showNotification(data.message, 'success');
    
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                closeLoadingModal();
                showNotification('Erreur lors de la recommande', 'error');
            }
        }
    });
}

// Annuler une commande déjà faite
async function cancelOrder(orderId) {

    showConfirmModal({
        title: 'Annuler la commande',
        message: 'Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.',
        confirmText: 'Oui, annuler',
        cancelText: 'Non, garder',
        confirmClass: 'btn-danger',

        onConfirm: async () => {
            showLoadingModal('Annulation en cours...');
            
            try {
                const response = await fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                closeLoadingModal();
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                closeLoadingModal();
                showNotification('Erreur lors de l\'annulation', 'error');
            }
        }
    });
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
        location.reload();
    }, 4000);
}

// Fonction générique pour afficher modal de confirmation
function showConfirmModal(options) {
    const {
        title,
        message,
        confirmText = 'Confirmer',
        cancelText = 'Annuler',
        confirmClass = 'btn-primary',
        onConfirm,
        onCancel
    } = options;
    
    // Supprimer modal existant si présent
    const existingModal = document.querySelector('.confirm-modal');
    if (existingModal) existingModal.remove();
    
    // Créer le modal
    const modal = document.createElement('div');
    modal.className = 'confirm-modal';
    modal.innerHTML = `
        <div class="modal-overlay"></div>
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="modal-title">${title}</h3>
            <p class="modal-message">${message}</p>
            <div class="modal-buttons">
                <button class="modal-btn btn-cancel" id="modalCancel">
                    ${cancelText}
                </button>
                <button class="modal-btn ${confirmClass}" id="modalConfirm">
                    ${confirmText}
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Animation d'entrée
    setTimeout(() => modal.classList.add('show'), 10);
    
    // Gestion des événements
    const confirmBtn = modal.querySelector('#modalConfirm');
    const cancelBtn = modal.querySelector('#modalCancel');
    const overlay = modal.querySelector('.modal-overlay');
    
    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => modal.remove(), 300);
    }
    
    confirmBtn.onclick = () => {
        closeModal();
        if (onConfirm) onConfirm();
    };
    
    cancelBtn.onclick = () => {
        closeModal();
        if (onCancel) onCancel();
    };
    
    overlay.onclick = () => {
        closeModal();
        if (onCancel) onCancel();
    };
    
    // Fermer avec Escape
    document.addEventListener('keydown', function escapeHandler(e) {
        if (e.key === 'Escape') {
            closeModal();
            if (onCancel) onCancel();
            document.removeEventListener('keydown', escapeHandler);
        }
    });
}

// Modal de chargement
function showLoadingModal(message) {
    const loading = document.createElement('div');
    loading.className = 'loading-modal';
    loading.id = 'loadingModal';
    loading.innerHTML = `
        <div class="modal-overlay"></div>
        <div class="loading-box">
            <div class="spinner"></div>
            <p>${message}</p>
        </div>
    `;
    document.body.appendChild(loading);
    setTimeout(() => loading.classList.add('show'), 10);
}

function closeLoadingModal() {
    const loading = document.getElementById('loadingModal');
    if (loading) {
        loading.classList.remove('show');
        setTimeout(() => loading.remove(), 300);
    }
}











