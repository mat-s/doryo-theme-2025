// Doryo Theme Admin JavaScript
(function() {
    'use strict';
    
    function initializeAdmin() {
        console.log('Doryo Theme Admin initialized');
        
        // Admin-specific functionality
        setupThemeCustomizer();
        setupMetaBoxes();
        setupInteractiveElements();
    }
    
    function setupThemeCustomizer() {
        // Theme customizer enhancements
        if (typeof wp !== 'undefined' && wp.customize) {
            console.log('WordPress Customizer available');
            
            // Add custom controls or behaviors here
            wp.customize.bind('ready', function() {
                console.log('Customizer ready');
            });
        }
    }
    
    function setupMetaBoxes() {
        // Custom meta box functionality
        const metaBoxes = document.querySelectorAll('.doryo-meta-box');
        metaBoxes.forEach(function(box) {
            // Add interactive features to meta boxes
            console.log('Meta box initialized:', box);
        });
    }
    
    function setupInteractiveElements() {
        // Tab functionality
        const tabLinks = document.querySelectorAll('.doryo-admin-tabs .tab-nav a');
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const tabId = link.getAttribute('href');
                const tabs = link.closest('.doryo-admin-tabs');
                
                if (tabs && tabId) {
                    // Remove active class from all tabs and content
                    tabs.querySelectorAll('.tab-nav a, .tab-content').forEach(function(el) {
                        el.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab and corresponding content
                    link.classList.add('active');
                    const targetContent = tabs.querySelector(tabId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                }
            });
        });
        
        // AJAX button functionality
        const ajaxButtons = document.querySelectorAll('.doryo-ajax-button');
        
        ajaxButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const data = new FormData();
                data.append('action', 'doryo_admin_action');
                data.append('nonce', window.doryoTheme ? window.doryoTheme.nonce : '');
                
                fetch(window.doryoTheme ? window.doryoTheme.ajaxUrl : '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: data
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    console.log('AJAX response:', data);
                })
                .catch(function(error) {
                    console.error('AJAX error:', error);
                });
            });
        });
    }
    
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeAdmin();
    });
    
    // Make functions available globally if needed
    window.doryoAdmin = {
        initializeAdmin: initializeAdmin
    };
    
})();
