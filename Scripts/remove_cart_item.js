function updateTotal() {
    const cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.item-price').textContent);
        const quantity = parseInt(item.querySelector('.item-quantity').value);
        total += price * quantity;
    });

    document.querySelector('.total-price').textContent = 'Rs.' + total.toFixed(2);
}

function removeItem(itemId) {
    fetch('remove_cart_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `remove_item_id=${itemId}`
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Failed to remove item.');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.item-quantity').forEach(input => {
        input.addEventListener('input', updateTotal);
    });
    updateTotal();

    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const itemId = button.getAttribute('data-item-id');
            removeItem(itemId);
        });
    });
});