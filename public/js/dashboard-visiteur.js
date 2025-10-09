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












