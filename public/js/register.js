document.addEventListener('DOMContentLoaded', function() {
    const mainSection = document.getElementById('main-section');
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Récupérer les données depuis les attributs data
    const formType = mainSection.dataset.formType;
    const hasExposantErrors = mainSection.dataset.hasExposantErrors === 'true';
    const hasVisiteurErrors = mainSection.dataset.hasVisiteurErrors === 'true';
    
    // Déterminer l'onglet actif
    let activeTab = 'exposant';
    
    if (hasVisiteurErrors || formType === 'visiteur') {
        activeTab = 'visiteur';
    } else if (hasExposantErrors || formType === 'exposant') {
        activeTab = 'exposant';
    }
    
    showTab(activeTab);
    
    // Gestion des clics sur les onglets
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            showTab(tabName);
        });
    });
    
    function showTab(tabName) {
        // Désactiver tous les onglets
        tabBtns.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Activer l'onglet sélectionné
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        document.getElementById(`${tabName}-tab`).classList.add('active');
    }
            
});

// Gestion de l'URL avec ancre
window.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash;

    if (hash === '#visiteur') {
        document.querySelector('.tab-btn[data-tab="visiteur"]').click();
    } else if (hash === '#exposant') {
        document.querySelector('.tab-btn[data-tab="exposant"]').click();
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



