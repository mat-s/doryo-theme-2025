<?php
/**
 * Theme Name: Doryo Theme
 * Description: Modern custom theme for Doryo website, built on Elementor Hello-Theme with TypeScript, SCSS and Vite
 * Template: hello-elementor
 * Version: 1.0.0
 * Author: Matthias Seidel
 * Author URI: https://doryo.de
 * Text Domain: doryo-theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class DoryoTheme {
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('after_setup_theme', [$this, 'theme_setup']);
    }
    
    public function theme_setup() {
        // Add theme support
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);
        
        // Load text domain
        load_child_theme_textdomain('doryo-theme', get_stylesheet_directory() . '/languages');
    }
    
    public function enqueue_assets() {
        // Debug: WordPress-Umgebung prüfen
        $wp_debug = defined('WP_DEBUG') && WP_DEBUG;
        $vite_running = $this->is_vite_dev_server_running();
        
        error_log('=== DORYO THEME ASSET LOADING ===');
        error_log('WP_DEBUG defined: ' . (defined('WP_DEBUG') ? 'YES' : 'NO'));
        error_log('WP_DEBUG value: ' . ($wp_debug ? 'TRUE' : 'FALSE'));
        error_log('Vite dev server: ' . ($vite_running ? 'RUNNING' : 'NOT RUNNING'));
        error_log('Mode: ' . ($wp_debug && $vite_running ? 'DEVELOPMENT' : 'PRODUCTION'));
        
        // Enqueue parent theme styles
        wp_enqueue_style(
            'hello-elementor-style',
            get_template_directory_uri() . '/style.css',
            [],
            wp_get_theme()->get('Version')
        );
        
        if ($wp_debug && $vite_running) {
            error_log('Loading DEVELOPMENT assets');
            $this->enqueue_vite_dev_assets();
        } else {
            error_log('Loading PRODUCTION assets');
            $this->enqueue_vite_build_assets();
        }
    }
    
    public function enqueue_admin_assets() {
        if (defined('WP_DEBUG') && WP_DEBUG && $this->is_vite_dev_server_running()) {
            wp_enqueue_script(
                'doryo-theme-admin',
                'http://localhost:3000/assets/js/admin.ts',
                ['jquery'],
                null,
                true
            );
            wp_script_add_data('doryo-theme-admin', 'type', 'module');
        } else {
            $admin_asset = $this->get_vite_asset('assets/js/admin.ts');
            if ($admin_asset) {
                wp_enqueue_script(
                    'doryo-theme-admin',
                    get_stylesheet_directory_uri() . '/dist/' . $admin_asset['file'],
                    ['jquery'],
                    null,
                    true
                );
            }
        }
    }
    
    private function enqueue_vite_dev_assets() {
        $vite_server = 'http://localhost:3000';
        
        // 1. Vite HMR Client laden
        wp_enqueue_script(
            'vite-hmr-client',
            $vite_server . '/@vite/client',
            [],
            null,
            false // Im Head laden
        );
        wp_script_add_data('vite-hmr-client', 'type', 'module');

        // 2. SCSS als JavaScript-Modul laden (wichtig für HMR!)
        wp_enqueue_script(
            'doryo-theme-style-hmr',
            $vite_server . '/assets/scss/style.scss',
            ['vite-hmr-client'],
            null,
            false // Im Head laden
        );
        wp_script_add_data('doryo-theme-style-hmr', 'type', 'module');

        // 3. Main JS Entry Point
        wp_enqueue_script(
            'doryo-theme-main-hmr',
            $vite_server . '/assets/js/main.ts',
            ['vite-hmr-client'],
            null,
            true
        );
        wp_script_add_data('doryo-theme-main-hmr', 'type', 'module');
        
        // Debug-Info
        error_log('Doryo Theme: HMR assets loaded:');
        error_log('- Vite Client: ' . $vite_server . '/@vite/client');
        error_log('- SCSS Entry: ' . $vite_server . '/assets/scss/style.scss');
        error_log('- JS Entry: ' . $vite_server . '/assets/js/main.ts');
    }
    
    private function enqueue_vite_build_assets() {
        $style_asset = $this->get_vite_asset('assets/scss/style.scss');
        $main_asset = $this->get_vite_asset('assets/js/main.ts');
        
        // Debug-Output
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Doryo Theme: Production mode');
            error_log('Style asset: ' . print_r($style_asset, true));
            error_log('Main asset: ' . print_r($main_asset, true));
        }
        
        if ($style_asset) {
            wp_enqueue_style(
                'doryo-theme-style',
                get_stylesheet_directory_uri() . '/dist/' . $style_asset['file'],
                ['hello-elementor-style'],
                wp_get_theme()->get('Version')
            );
        }
        
        if ($main_asset) {
            wp_enqueue_script(
                'doryo-theme-main',
                get_stylesheet_directory_uri() . '/dist/' . $main_asset['file'],
                ['jquery'],
                wp_get_theme()->get('Version'),
                true
            );
            
            // Localize script with WordPress data
            wp_localize_script('doryo-theme-main', 'doryoTheme', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('doryo_theme_nonce'),
                'restUrl' => rest_url('wp/v2/'),
                'restNonce' => wp_create_nonce('wp_rest'),
            ]);
        }
    }
    
    private function get_vite_asset($entry) {
        $manifest_path = get_stylesheet_directory() . '/dist/.vite/manifest.json';
        
        $manifest = json_decode(file_get_contents($manifest_path), true);
        
        return isset($manifest[$entry]) ? $manifest[$entry] : false;
    }
    
    private function is_vite_dev_server_running() {
        // Container-zu-Container URLs testen
        $vite_urls = [
            'http://vite:3000/@vite/client',      // Container-intern
            'http://localhost:3000/@vite/client'  // Fallback
        ];
        
        foreach ($vite_urls as $vite_server) {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 2,
                    'method' => 'GET',
                    'ignore_errors' => true
                ]
            ]);
            
            $result = @file_get_contents($vite_server, false, $context);
            
            // Debug-Log hinzufügen
            error_log('Doryo Theme: Testing ' . $vite_server . ' - ' . ($result !== false ? 'SUCCESS' : 'FAILED'));
            
            if ($result !== false) {
                error_log('Doryo Theme: Vite dev server found at ' . $vite_server);
                return true;
            }
        }
        
        error_log('Doryo Theme: No Vite dev server found - using production mode');
        return false;
    }
}

// Initialize the theme
DoryoTheme::get_instance();
