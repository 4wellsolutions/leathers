import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Wishlist functionality
document.addEventListener('DOMContentLoaded', function () {
    // Wishlist toggle buttons
    document.addEventListener('click', function (e) {
        if (e.target.closest('.wishlist-toggle')) {
            e.preventDefault();
            const button = e.target.closest('.wishlist-toggle');
            const productId = button.dataset.productId;

            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const svg = button.querySelector('svg');
                        if (data.inWishlist) {
                            button.classList.add('text-red-500');
                            button.classList.remove('text-neutral-500');
                            svg.setAttribute('fill', 'currentColor');
                        } else {
                            button.classList.remove('text-red-500');
                            button.classList.add('text-neutral-500');
                            svg.setAttribute('fill', 'none');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});
