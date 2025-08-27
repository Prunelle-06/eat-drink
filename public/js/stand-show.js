 document.addEventListener('DOMContentLoaded', function() {
    // Gestion des quantités
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const minusBtns = document.querySelectorAll('.quantity-btn.minus');
    const plusBtns = document.querySelectorAll('.quantity-btn.plus');
    const checkoutBtn = document.getElementById('checkout-btn');
    const cartCount = document.querySelector('.cart-count');
    const cartItemsEl = document.querySelector('.cart-items');
    const cartTotalEl = document.querySelector('.cart-total span:last-child');
    const totalPlusCoasts = document.querySelector('.total-plus-coasts span:last-child');
    const emptyCartMsg = document.querySelector('.empty-cart-message');
    const msgOrderSuccess = document.querySelector('.msg-order-success');
    const clearCartBtn = document.getElementById('clear-cart');

    // Récupérer l'ID du stand depuis la page
    const standId = document.querySelector('[data-stand-id]')?.dataset.standId;
    // const userId = document.querySelector('[data-user-id]')?.dataset.userId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    let cart = [];

    const savedCart = localStorage.getItem('shoppingCart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        cart.forEach(item => {
            const productEl = document.querySelector(`[data-id="${item.id}"]`);
            if (productEl) {
                productEl.querySelector('.quantity-input').value = item.quantity;
            }
        });

        updateCartUI();
    }

    // Mise à jour du panier
    function updateCart() {
        // Filtrer les produits avec quantité > 0
        cart = Array.from(document.querySelectorAll('.product-card'))
            .map(productEl => {
                const input = productEl.querySelector('.quantity-input');
        
                return {
                    id: productEl.dataset.id,
                    name: productEl.querySelector('.product-title').textContent,
                    description: productEl.querySelector('.product-description').textContent,
                    price: parseInt(productEl.querySelector('.product-price').textContent),
                    quantity: parseInt(input.value)
                };
            })
            .filter(item => item.quantity > 0);
        
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
        updateCartUI();
    }

    function updateCartUI() {
        // Mettre à jour le compteur
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = `${totalItems} article(s)`;
        
        // Mettre à jour la liste des articles
        if (cart.length > 0) {
            emptyCartMsg.style.display = 'none';
            cartItemsEl.innerHTML = '';
            
            cart.forEach(item => {
                const cartItemEl = document.createElement('div');
                cartItemEl.className = 'cart-item';
                cartItemEl.innerHTML = `
                    <span class="cart-item-name">${item.name} × ${item.quantity}</span>
                    <span class="cart-item-price">${(item.price * item.quantity).toFixed(2)} CFA</span>
                `;
                cartItemsEl.appendChild(cartItemEl);
            });
            
            // Calculer le total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotalEl.textContent = `${total.toFixed(2)} CFA`;
            totalPlusCoasts.textContent = `${(parseInt(total) + 500).toFixed(2)} CFA`;
            
            // Activer le bouton de commande
            checkoutBtn.disabled = false;
            checkoutBtn.className = 'btn btn-primary';

            clearCartBtn.className = 'btn btn-clear';
            clearCartBtn.disabled = false
        } else {
            emptyCartMsg.style.display = 'block';
            cartTotalEl.textContent = '0.00 CFA';
            checkoutBtn.disabled = true;
            checkoutBtn.className = 'btn btn-disabled';

            clearCartBtn.className = 'btn btn-disabled';
            clearCartBtn.disabled = true
        }
    }

    minusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                msgOrderSuccess.style.display = "none";
                updateCart();
            }
        });
    });

    plusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            msgOrderSuccess.style.display = "none";
            updateCart();
        });
    });

    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 0) this.value = 0;
            updateCart();
        });
    });


    // Envoi de la commande
    checkoutBtn.addEventListener('click', async function() {
        if (cart.length === 0) return;

        this.disabled = true;
        this.textContent = 'Envoi en cours...';

        try {
            const orderData = {
                stand_id: standId,
                items: cart.map(item => ({
                    product_id: parseInt(item.id),
                    quantity: item.quantity
                }))
            };

            const response = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (result.success) {
                msgOrderSuccess.style.display = "block";
                msgOrderSuccess.className = "msg-order-success success";
                msgOrderSuccess.innerHTML = `
                    <div class="order-success-content">
                        <div class="display: flex">
                            <i class="fas fa-check-circle"></i>
                            <h4>Commande passée avec succès !</h4>
                        </div>
                        <small>Vous pouvez suivre votre commande dans votre <a href="">tableau de bord</a>.</small>
                    </div>
                `;
                
                clearCart();
                
                // Masquer le message après 5 secondes
                // setTimeout(() => {
                //     msgOrderSuccess.style.display = "none";
                // }, 5000);
                
            } else {
                msgOrderSuccess.style.display = "block";
                msgOrderSuccess.className = "msg-order-success error";
                msgOrderSuccess.innerHTML = `
                    <div class="order-error-content">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Erreur lors de la commande</h4>
                        <p>${result.message}</p>
                    </div>
                `;
            }

        } catch (error) {
            console.error('Erreur:', error);
            msgOrderSuccess.style.display = "block";
            msgOrderSuccess.className = "msg-order-success error";
            msgOrderSuccess.innerHTML = `
                <div class="order-error-content">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Erreur de connexion</h4>
                    <p>Impossible de passer la commande. Veuillez réessayer.</p>
                </div>
            `;
        } finally {
            // Réactiver le bouton
            this.disabled = false;
            this.textContent = 'Passer la commande';
        }
    });

    // Vider le panier
    function clearCart() {
        cart = [];
        localStorage.removeItem('shoppingCart');
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.value = 0;
        });

        updateCartUI();
    }

    clearCartBtn.addEventListener('click', clearCart);

});