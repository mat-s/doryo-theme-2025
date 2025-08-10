<?php
namespace DoryoTheme\Widgets;

/**
 * Widget Manager für Custom Elementor Widgets
 */
class WidgetManager {
    
    /**
     * Initialize widget manager
     */
    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);
    }
    
    /**
     * Register custom widget categories
     */
    public function register_widget_categories($elements_manager) {
        $elements_manager->add_category(
            'doryo-theme',
            [
                'title' => esc_html__('Doryo Theme', 'doryo-theme'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    
    /**
     * Register custom widgets
     */
    public function register_widgets($widgets_manager) {
        // Hero Unit Widget
        require_once __DIR__ . '/HeroUnit.php';
        $widgets_manager->register(new HeroUnit());
    }
}
