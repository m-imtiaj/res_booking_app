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
        cartItemsDiv.innerHTML = "<p>Your Order is empty.</p>";
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

// Stripe Checkout Integration
async function checkout() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert("Your cart is empty. Please add items before checking out.");
        return;
    }

    // Calculate total amount in cents (required by Stripe)
    const totalAmount = cart.reduce((total, item) => total + item.price, 0) * 100; // Convert to cents

    try {
        // Create PaymentIntent on the server
        const response = await fetch('create_payment_intent.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ amount: totalAmount })
        });

        const { clientSecret } = await response.json();

        // Initialize Stripe
        const stripe = Stripe('pk_test_51QOmkVFJMTSsn8gcOWaFtvScmMsI3OPhEDWpTHHqLOKSlVytKcrdkYU1hTpovTLehhbyNrcbJHV9sN6K8DXtt8Vv00KJbBae6l'); // Replace with your Stripe Publishable Key

        // Confirm Payment
        const { error } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: stripe.elements().create('card'),
                billing_details: {
                    name: 'Customer Name', // You can dynamically populate this
                    email: 'customer@example.com' // Use real customer email if available
                },
            },
        });

        if (error) {
            alert(`Payment failed: ${error.message}`);
        } else {
            alert('Payment successful! Thank you for your order.');
            localStorage.removeItem('cart'); // Clear cart after successful payment
            loadCart();
            updateCartCount();
        }
    } catch (err) {
        console.error('Error during checkout:', err);
    }
}
