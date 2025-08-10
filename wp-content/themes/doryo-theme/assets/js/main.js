// Doryo Theme Main JavaScript File
(function() {
    'use strict';
    
    // Theme initialization functions
    function initializeTheme() {
        console.log('Theme initialized');
        
        // Add smooth scrolling
        setupSmoothScrolling();
        
        // Initialize responsive features  
        setupResponsiveFeatures();
    }
    
    function setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = anchor.getAttribute('href');
                const target = href ? document.querySelector(href) : null;
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    function setupResponsiveFeatures() {
        // Mobile menu handling
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                mobileMenuToggle.classList.toggle('active');
            });
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu && !mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenu.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            // Close mobile menu on resize to desktop
            if (window.innerWidth > 768) {
                if (mobileMenu) mobileMenu.classList.remove('active');
                if (mobileMenuToggle) mobileMenuToggle.classList.remove('active');
            }
        });
    }
    
    function setupNavigation() {
        console.log('Navigation initialized');
        
        // Mobile menu toggle
        setupMobileMenu();
        
        // Dropdown menus
        setupDropdownMenus();
    }
    
    function setupMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                menuToggle.classList.toggle('active');
            });
        }
    }
    
    function setupDropdownMenus() {
        const dropdownMenus = document.querySelectorAll('.menu-item-has-children');
        
        dropdownMenus.forEach(function(menu) {
            const link = menu.querySelector('a');
            const submenu = menu.querySelector('.sub-menu');
            
            if (link && submenu) {
                // Desktop hover behavior
                menu.addEventListener('mouseenter', function() {
                    submenu.classList.add('active');
                });
                
                menu.addEventListener('mouseleave', function() {
                    submenu.classList.remove('active');
                });
                
                // Mobile click behavior
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        submenu.classList.toggle('active');
                    }
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.menu-item-has-children')) {
                document.querySelectorAll('.sub-menu.active').forEach(function(submenu) {
                    submenu.classList.remove('active');
                });
            }
        });
    }
    
    function initializeElementor() {
        console.log('Elementor integration initialized');
        
        // Wait for Elementor to load
        if (typeof window.elementorFrontend !== 'undefined') {
            setupElementorHooks();
        } else {
            // Listen for Elementor initialization
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.elementorFrontend !== 'undefined') {
                    setupElementorHooks();
                }
            });
        }
    }
    
    function setupElementorHooks() {
        // Custom Elementor widget enhancements
        window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', function(scope) {
            enhanceElementorWidgets(scope);
        });
        
        // Specific widget handlers
        window.elementorFrontend.hooks.addAction('frontend/element_ready/doryo-hero-unit.default', function(scope) {
            initializeHeroUnit(scope);
        });
    }
    
    function enhanceElementorWidgets(scope) {
        // General widget enhancements
        const widgets = scope.find('[data-widget_type]');
        
        widgets.each(function() {
            const widget = this;
            const widgetType = widget.getAttribute('data-widget_type');
            
            // Add custom functionality based on widget type
            switch (widgetType) {
                case 'doryo-hero-unit.default':
                    initializeHeroUnit(widget);
                    break;
                // Add more widget types as needed
            }
        });
    }
    
    function initializeHeroUnit(scope) {
        console.log('Hero Unit widget initialized');
        
        // Hero unit specific functionality
        const heroButtons = scope.find ? scope.find('.doryo-hero-button') : scope.querySelectorAll('.doryo-hero-button');
        
        if (heroButtons.length) {
            heroButtons.forEach(function(button) {
                // Add smooth scroll if it's an anchor link
                if (button.getAttribute('href') && button.getAttribute('href').startsWith('#')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(button.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                }
            });
        }
    }
    
    // WordPress DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Doryo Theme loaded');
        
        // Initialize theme modules
        initializeTheme();
        setupNavigation();
        initializeElementor();
    });
    
    // Make functions available globally if needed
    window.doryoTheme = {
        initializeTheme: initializeTheme,
        setupNavigation: setupNavigation,
        initializeElementor: initializeElementor
    };
    
})();
