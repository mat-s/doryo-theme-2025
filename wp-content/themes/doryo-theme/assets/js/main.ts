import '../scss/style.scss';
import { initializeTheme } from './modules/theme';
import { setupNavigation } from './modules/navigation';
import { initializeElementor } from './modules/elementor';

declare global {
  interface Window {
    jQuery: JQueryStatic;
    $: JQueryStatic;
    wp: any;
    helloChild: {
      ajaxUrl: string;
      nonce: string;
      restUrl: string;
      restNonce: string;
    };
  }
}

class HelloChildApp {
  constructor() {
    this.init();
  }

  private init(): void {
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', () => {
      this.initializeComponents();
    });

    // Initialize components that need jQuery
    if (typeof window.jQuery !== 'undefined') {
      window.jQuery(document).ready(() => {
        this.initializeJQueryComponents();
      });
    }
  }

  private initializeComponents(): void {
    console.log('Hello Child Theme initialized');
    
    // Initialize theme components
    initializeTheme();
    setupNavigation();
  }

  private initializeJQueryComponents(): void {
    const $ = window.jQuery;
    
    if (typeof $ !== 'undefined') {
      // Initialize Elementor-related functionality
      initializeElementor();
      
      // Custom theme functionality
      this.setupCustomFeatures();
    }
  }

  private setupCustomFeatures(): void {
    // Add your custom JavaScript functionality here
    console.log('Custom features initialized');
  }
}

// Initialize the application
new HelloChildApp();
