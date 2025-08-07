export function initializeElementor(): void {
  console.log('Elementor integration initialized');
  
  // Wait for Elementor to load
  if (typeof window.elementorFrontend !== 'undefined') {
    setupElementorHooks();
  } else {
    // Listen for Elementor initialization
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof window.elementorFrontend !== 'undefined') {
        setupElementorHooks();
      }
    });
  }
}

function setupElementorHooks(): void {
  // Custom Elementor widget enhancements
  window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', (scope: any) => {
    enhanceElementorWidgets(scope);
  });
}

function enhanceElementorWidgets(scope: any): void {
  // Add custom functionality to Elementor widgets
  const customButtons = scope.find('.custom-button');
  customButtons.each(function(this: HTMLElement) {
    // Add click animations or other enhancements
    this.addEventListener('click', () => {
      this.classList.add('clicked');
      setTimeout(() => {
        this.classList.remove('clicked');
      }, 300);
    });
  });
}

declare global {
  interface Window {
    elementorFrontend: any;
  }
}
