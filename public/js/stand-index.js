// Animation au chargement
document.addEventListener('DOMContentLoaded', function() {
    const standCards = document.querySelectorAll('.stand-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
            }
        });
    }, { threshold: 0.1 });

    standCards.forEach(card => {
        observer.observe(card);
    });
});


// Fonction pour afficher les alertes
function showAlert(message, type = 'success') {
    const alertBox = document.getElementById('alertBox');
    if(alertBox) {
        alertBox.innerHTML = message;
        alertBox.className = `alert alert-${type}`;
        alertBox.style.display = 'block';
        
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 5000);
    }
}

// Fonction pour basculer l'état favori
function toggleFavorite(standId, event) {

    // Empêcher la navigation vers le détail du stand
    event.preventDefault();
    event.stopPropagation();

    const button = document.querySelector(`.stand-card[data-stand-id="${standId}"] .favorite-btn`);
    const countElement = document.querySelector(`.stand-card[data-stand-id="${standId}"] .favorites-count`);
    
    const isCurrentlyFavorite = button.classList.contains('favorited');

    if(countElement) {
        newCount = parseInt(countElement.textContent);  
    }
    
    if (isCurrentlyFavorite) {
        button.classList.remove('favorited');
        if(countElement) {
            newCount--;
        }
    } else {
        button.classList.add('favorited');
        if(countElement) {
            newCount++;
        }
    }
    if(countElement) {
        countElement.textContent = `${newCount}`
    }    
    
    // Envoyer la requête au serveur
    fetch(`/stands/${standId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        
        if (data.success) {
            showAlert(data.message, 'success');
            if(countElement) {
                countElement.textContent = `${data.favorites_count}`;
            }

            let favoriteStandCard = document.querySelector('.favorite-stand-card')
            if(favoriteStandCard) {
                setTimeout(() => {
                    document.querySelector(`.stand-card[data-stand-id="${standId}"]`).style.display = 'none';
                }, 3000);
            }
         } else {
            showAlert(data.message, 'error');
            // Revenir à l'état précédent en cas d'erreur
            if (isCurrentlyFavorite) {
                button.classList.add('favorited');
                if(countElement) {
                    countElement.textContent = `${newCount + 1}`
                }
            } else {
                button.classList.remove('favorited');
                if(countElement) {
                    countElement.textContent = `${newCount - 1}`
                }
            }
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showAlert('Une erreur s\'est produite', 'error');
        // Revenir à l'état précédent en cas d'erreur
        if (isCurrentlyFavorite) {
            button.classList.add('favorited');
            if(countElement) {
                countElement.textContent = `${newCount + 1}`
            }
        } else {
            button.classList.remove('favorited');
            if(countElement) {
                countElement.textContent = `${newCount - 1}`
            }
        }
    });
}