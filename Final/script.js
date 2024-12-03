document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    updateCartCount();
});

function addToCart(itemName, itemPrice) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({ name: itemName, price: itemPrice });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    document.getElementById('cart-count').textContent = cart.length;
}

function loadCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsDiv = document.getElementById('cart-items');
    const cartTotalSpan = document.getElementById('cart-total');
    let total = 0;

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = "<p>Your cart is empty.</p>";
        cartTotalSpan.textContent = "0.00";
    } else {
        cartItemsDiv.innerHTML = cart.map((item, index) => {
            total += item.price;
            return `
                <div class="cart-item">
                    <h4>${item.name}</h4>
                    <span>$${item.price.toFixed(2)}</span>
                    <button onclick="removeFromCart(${index})" class="remove-btn">Remove</button>
                </div>
            `;
        }).join('');
        cartTotalSpan.textContent = total.toFixed(2);
    }
}

function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);  
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart(); 
    updateCartCount();
}

// Display the payment form modal
function checkout() {
    const paymentFormModal = document.getElementById('paymentFormModal');
    paymentFormModal.style.display = 'flex';
}

// Close the payment form modal
function closePaymentForm() {
    const paymentFormModal = document.getElementById('paymentFormModal');
    paymentFormModal.style.display = 'none';
}

// Handle Payment Form Submission
document.getElementById('paymentForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent actual form submission

    // Close the payment form modal
    closePaymentForm();

    // Show the thanks message modal
    const thanksMessageModal = document.getElementById('thanksMessageModal');
    thanksMessageModal.style.display = 'flex';
});

// Close the thanks message modal
function closeThanksMessage() {
    const thanksMessageModal = document.getElementById('thanksMessageModal');
    thanksMessageModal.style.display = 'none';
    localStorage.removeItem('cart'); 
    loadCart();  // Reload the cart to update display
    updateCartCount(); // Clear the cart
}


