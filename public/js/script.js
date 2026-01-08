// Script JavaScript pour le site E-Commerce

document.addEventListener('DOMContentLoaded', function() {
    
    // Confirmation de suppression
    const deleteButtons = document.querySelectorAll('[onclick*="confirm"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ?')) {
                e.preventDefault();
            }
        });
    });
    
    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe les cartes de produits / catégories
    document.querySelectorAll('.product-card, .category-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        observer.observe(card);
    });

    // Gestion des quantités dans le panier
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function () {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });

    // Message flash auto-disparition
    const flash = document.querySelector('.flash-message');
    if (flash) {
        setTimeout(() => {
            flash.classList.add('fade-out');
        }, 3000);
    }
});