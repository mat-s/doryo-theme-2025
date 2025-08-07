export {}; // Make this a module

declare global {
  interface Window {
    jQuery: any;
    $: any;
    wp: any;
    helloChild: {
      ajaxUrl: string;
      nonce: string;
      restUrl: string;
      restNonce: string;
    };
  }
}

class HelloChildAdmin {
  constructor() {
    this.init();
  }

  private init(): void {
    document.addEventListener('DOMContentLoaded', () => {
      this.initializeAdminFeatures();
    });
  }

  private initializeAdminFeatures(): void {
    console.log('Hello Child Admin initialized');
    
    // Add admin-specific functionality here
    this.setupCustomMetaBoxes();
    this.enhanceMediaLibrary();
  }

  private setupCustomMetaBoxes(): void {
    // Custom meta box functionality
    console.log('Custom meta boxes initialized');
  }

  private enhanceMediaLibrary(): void {
    // Media library enhancements
    console.log('Media library enhancements initialized');
  }
}

// Initialize admin functionality
new HelloChildAdmin();
