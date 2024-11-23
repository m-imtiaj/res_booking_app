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

function checkout() {
    if (confirm("Are you sure you want to checkout?")) {
        localStorage.removeItem('cart');  // Clear the cart
        loadCart();  // Reload the cart to update display
        updateCartCount();
        alert("Thank you for your purchase! Your order has been placed.");
    }
}
