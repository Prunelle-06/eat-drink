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


// function showAlert(message, type = 'success') {
//     // Créer l'alerte si elle n'existe pas encore
//     let alertBox = document.getElementById('alertBox');
//     if (!alertBox) {
//         alertBox = document.createElement('div');
//         alertBox.id = 'alertBox';
//         alertBox.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1000; padding: 15px; border-radius: 5px; max-width: 300px;';
//         document.body.appendChild(alertBox);
//     }
    
//     alertBox.textContent = message;
//     alertBox.className = `alert alert-${type}`;
//     alertBox.style.display = 'block';
    
//     setTimeout(() => {
//         alertBox.style.display = 'none';
//     }, 3000);
// }

// function toggleFavorite(standId, event) {
//     // Empêcher la navigation vers le détail du stand
//     event.preventDefault();
//     event.stopPropagation();
    
//     const button = document.querySelector(`.stand-card[data-stand-id="${standId}"] .favorite-btn`);
//     const isCurrentlyFavorite = button.classList.contains('favorited');
    
//     // Optimistic UI update
//     if (isCurrentlyFavorite) {
//         button.classList.remove('favorited');
//         button.classList.add('not-favorited');
//     } else {
//         button.classList.remove('not-favorited');
//         button.classList.add('favorited');
//     }
    
//     // Envoyer la requête au serveur
//     const url = `/stands/${standId}/favorite`;
//     const method = isCurrentlyFavorite ? 'DELETE' : 'POST';
    
//     fetch(url, {
//         method: method,
//         headers: {
//             'X-Requested-With': 'XMLHttpRequest',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         }
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             showAlert(data.message, 'success');
//             // Mettre à jour l'état du bouton en fonction de la réponse
//             if (data.is_favorite) {
//                 button.classList.remove('not-favorited');
//                 button.classList.add('favorited');
//             } else {
//                 button.classList.remove('favorited');
//                 button.classList.add('not-favorited');
//             }
//         } else {
//             showAlert(data.message, 'error');
//             // Revenir à l'état précédent en cas d'erreur
//             if (isCurrentlyFavorite) {
//                 button.classList.remove('not-favorited');
//                 button.classList.add('favorited');
//             } else {
//                 button.classList.remove('favorited');
//                 button.classList.add('not-favorited');
//             }
//         }
//     })
//     .catch(error => {
//         console.error('Erreur:', error);
//         showAlert('Une erreur s\'est produite', 'error');
//         // Revenir à l'état précédent en cas d'erreur
//         if (isCurrentlyFavorite) {
//             button.classList.remove('not-favorited');
//             button.classList.add('favorited');
//         } else {
//             button.classList.remove('favorited');
//             button.classList.add('not-favorited');
//         }
//     });
// }




// Fonction pour afficher les alertes
function showAlert(message, type = 'success') {
    const alertBox = document.getElementById('alertBox');
    alertBox.innerHTML = message;
    alertBox.className = `alert alert-${type}`;
    alertBox.style.display = 'block';
    
    setTimeout(() => {
        alertBox.style.display = 'none';
    }, 5000);
}

// Fonction pour basculer l'état favori
function toggleFavorite(standId, event) {

    // Empêcher la navigation vers le détail du stand
    event.preventDefault();
    event.stopPropagation();

    const button = document.querySelector(`.stand-card[data-stand-id="${standId}"] .favorite-btn`);
    const countElement = document.querySelector(`.stand-card[data-stand-id="${standId}"] .favorites-count`);
    
    // Optimistic UI update
    const isCurrentlyFavorite = button.classList.contains('favorited');
    let newCount = parseInt(countElement.textContent);
    
    if (isCurrentlyFavorite) {
        button.classList.remove('favorited');
        newCount--;
    } else {
        button.classList.add('favorited');
        newCount++;
    }
    countElement.textContent = `${newCount}`;
    
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
            countElement.textContent = `${data.favorites_count}`;
        } else {
            showAlert(data.message, 'error');
            // Revenir à l'état précédent en cas d'erreur
            if (isCurrentlyFavorite) {
                button.classList.add('favorited');
                countElement.textContent = `${newCount + 1}`;
            } else {
                button.classList.remove('favorited');
                countElement.textContent = `${newCount - 1}`;
            }
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showAlert('Une erreur s\'est produite', 'error');
        // Revenir à l'état précédent en cas d'erreur
        if (isCurrentlyFavorite) {
            button.classList.add('favorited');
            countElement.textContent = `${newCount + 1}`;
        } else {
            button.classList.remove('favorited');
            countElement.textContent = `${newCount - 1}`;
        }
    });
}