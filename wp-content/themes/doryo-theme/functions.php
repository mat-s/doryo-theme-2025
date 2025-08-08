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
        // Enqueue parent theme styles
        wp_enqueue_style(
            'hello-elementor-style',
            get_template_directory_uri() . '/style.css',
            [],
            wp_get_theme()->get('Version')
        );
        
        if (defined('WP_DEBUG') && WP_DEBUG && $this->is_vite_dev_server_running()) {
            // Development mode with Vite HMR
            $this->enqueue_vite_dev_assets();
        } else {
            // Production mode with built assets
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
        // Vite client for HMR
        wp_enqueue_script(
            'vite-client',
            'http://localhost:3000/@vite/client',
            [],
            null,
            false
        );
        wp_script_add_data('vite-client', 'type', 'module');
        
        // Main TypeScript entry point
        wp_enqueue_script(
            'doryo-theme-main',
            'http://localhost:3000/assets/js/main.ts',
            [],
            null,
            true
        );
        wp_script_add_data('doryo-theme-main', 'type', 'module');
    }
    
    private function enqueue_vite_build_assets() {
        $main_js = $this->get_vite_asset('assets/js/main.ts');
        $main_css = $this->get_vite_asset('assets/scss/style.scss');
        
        if ($main_css) {
            wp_enqueue_style(
                'doryo-theme-style',
                get_stylesheet_directory_uri() . '/dist/' . $main_css['file'],
                ['hello-elementor-style'],
                null
            );
        }
        
        if ($main_js) {
            wp_enqueue_script(
                'doryo-theme-main',
                get_stylesheet_directory_uri() . '/dist/' . $main_js['file'],
                ['jquery'],
                null,
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
        $manifest_path = get_stylesheet_directory() . '/dist/manifest.json';
        
        if (!file_exists($manifest_path)) {
            return false;
        }
        
        $manifest = json_decode(file_get_contents($manifest_path), true);
        
        return isset($manifest[$entry]) ? $manifest[$entry] : false;
    }
    
    private function is_vite_dev_server_running() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $http_code === 200;
    }
}

// Initialize the theme
DoryoTheme::get_instance();
