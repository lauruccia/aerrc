import './bootstrap';

// ── Livewire v3 include Alpine.js internamente e lo avvia automaticamente.
// NON importare Alpine né chiamare Alpine.start() — rompe wire:click.
// Registra i componenti Alpine tramite l'evento alpine:init.

document.addEventListener('alpine:init', () => {

    // ── Language switcher ──
    Alpine.data('langSwitcher', () => ({
        open: false,
        toggle() { this.open = !this.open; },
        close() { this.open = false; },
    }));

    // ── Mobile menu ──
    Alpine.data('mobileMenu', () => ({
        open: false,
        toggle() { this.open = !this.open; },
    }));

    // ── Sticky nav shadow on scroll ──
    Alpine.data('stickyNav', () => ({
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        },
    }));

});
