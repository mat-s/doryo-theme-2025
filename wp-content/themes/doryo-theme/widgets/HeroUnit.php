<?php
namespace DoryoTheme\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use function esc_html;
use function esc_html__;
use function wp_kses_post;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Doryo Hero Unit Widget
 */
class HeroUnit extends Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'doryo-hero-unit';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('Hero Unit', 'doryo-theme');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-banner';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['doryo-theme'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return ['hero', 'banner', 'header', 'doryo'];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'doryo-theme'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Welcome to Doryo', 'doryo-theme'),
                'placeholder' => esc_html__('Enter your title', 'doryo-theme'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // Subtitle
        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'doryo-theme'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Professional Web Development & Freelancing Services', 'doryo-theme'),
                'placeholder' => esc_html__('Enter your subtitle', 'doryo-theme'),
                'rows' => 3,
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // Button Label
        $this->add_control(
            'button_label',
            [
                'label' => esc_html__('Button Label', 'doryo-theme'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'doryo-theme'),
                'placeholder' => esc_html__('Enter button text', 'doryo-theme'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // Button Link
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'doryo-theme'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#contact',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // Button Icon
        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Button Icon', 'doryo-theme'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'button_label!' => '',
                ],
            ]
        );

        // Hero Image
        $this->add_control(
            'hero_image',
            [
                'label' => esc_html__('Hero Image', 'doryo-theme'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'hero_image',
                'default' => 'large',
                'separator' => 'none',
                'condition' => [
                    'hero_image[url]!' => '',
                ],
            ]
        );

        // Flag/Label Section
        $this->add_control(
            'flag_heading',
            [
                'label' => esc_html__('Flag/Label', 'doryo-theme'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Show Flag Toggle
        $this->add_control(
            'show_flag',
            [
                'label' => esc_html__('Show Flag', 'doryo-theme'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'doryo-theme'),
                'label_off' => esc_html__('Hide', 'doryo-theme'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // Flag Text
        $this->add_control(
            'flag_text',
            [
                'label' => esc_html__('Flag Text', 'doryo-theme'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('New', 'doryo-theme'),
                'placeholder' => esc_html__('Enter flag text', 'doryo-theme'),
                'condition' => [
                    'show_flag' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        // Blob Color
        $this->add_control(
            'blob_color',
            [
                'label' => esc_html__('Blob Background Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-blob::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Title
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title Style', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-title' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .doryo-hero-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'size' => 48,
                            'unit' => 'px',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Subtitle
        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle Style', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-subtitle' => 'color: {{VALUE}};',
                ],
                'default' => '#666666',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .doryo-hero-subtitle',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'size' => 18,
                            'unit' => 'px',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button Style', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-button' => 'background-color: {{VALUE}};',
                ],
                'default' => '#007cba',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-button' => 'color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-button:hover' => 'background-color: {{VALUE}};',
                ],
                'default' => '#005a87',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .doryo-hero-button',
                'fields_options' => [
                    'font_weight' => [
                        'default' => '600',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Image
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__('Image Style', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'hero_image[url]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'doryo-theme'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'doryo-theme'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 12,
                    'right' => 12,
                    'bottom' => 12,
                    'left' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Flag
        $this->start_controls_section(
            'flag_style_section',
            [
                'label' => esc_html__('Flag Style', 'doryo-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_flag' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'flag_background_color',
            [
                'label' => esc_html__('Background Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ff6b35',
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-flag' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flag_text_color',
            [
                'label' => esc_html__('Text Color', 'doryo-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .doryo-hero-flag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'flag_typography',
                'selector' => '{{WRAPPER}} .doryo-hero-flag',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'size' => 12,
                            'unit' => 'px',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output in the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['title']) && empty($settings['subtitle']) && empty($settings['button_label']) && empty($settings['hero_image']['url'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'doryo-hero-unit');
        
        if (!empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button_link', $settings['button_link']);
        }

        // Add blob if blob color is set
        if (!empty($settings['blob_color'])) {
            $this->add_render_attribute('wrapper', 'class', 'doryo-hero-blob');
        }
        ?>
        
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <?php if ('yes' === $settings['show_flag'] && !empty($settings['flag_text'])) : ?>
                <div class="doryo-hero-flag">
                    <?php echo esc_html($settings['flag_text']); ?>
                </div>
            <?php endif; ?>

            <div class="doryo-hero-content">
                <div class="doryo-hero-text">
                    <?php if (!empty($settings['title'])) : ?>
                        <h1 class="doryo-hero-title"><?php echo wp_kses_post($settings['title']); ?></h1>
                    <?php endif; ?>

                    <?php if (!empty($settings['subtitle'])) : ?>
                        <p class="doryo-hero-subtitle"><?php echo wp_kses_post($settings['subtitle']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($settings['button_label'])) : ?>
                        <div class="doryo-hero-button-wrapper">
                            <a class="doryo-hero-button" <?php $this->print_render_attribute_string('button_link'); ?>>
                                <?php if (!empty($settings['button_icon']['value'])) : ?>
                                    <span class="doryo-hero-button-icon">
                                        <?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="doryo-hero-button-text">
                                    <?php echo esc_html($settings['button_label']); ?>
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($settings['hero_image']['url'])) : ?>
                    <div class="doryo-hero-image">
                        <?php 
                        $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'hero_image');
                        echo $image_html; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <# 
        view.addRenderAttribute('wrapper', 'class', 'doryo-hero-unit');
        
        if (settings.blob_color) {
            view.addRenderAttribute('wrapper', 'class', 'doryo-hero-blob');
        }
        
        var buttonUrl = settings.button_link.url;
        var buttonTarget = settings.button_link.is_external ? ' target="_blank"' : '';
        var buttonNofollow = settings.button_link.nofollow ? ' rel="nofollow"' : '';
        #>
        
        <div {{{ view.getRenderAttributeString('wrapper') }}}>
            <# if (settings.show_flag === 'yes' && settings.flag_text) { #>
                <div class="doryo-hero-flag">
                    {{{ settings.flag_text }}}
                </div>
            <# } #>

            <div class="doryo-hero-content">
                <div class="doryo-hero-text">
                    <# if (settings.title) { #>
                        <h1 class="doryo-hero-title">{{{ settings.title }}}</h1>
                    <# } #>

                    <# if (settings.subtitle) { #>
                        <p class="doryo-hero-subtitle">{{{ settings.subtitle }}}</p>
                    <# } #>

                    <# if (settings.button_label) { #>
                        <div class="doryo-hero-button-wrapper">
                            <a class="doryo-hero-button" href="{{{ buttonUrl }}}" {{{ buttonTarget }}} {{{ buttonNofollow }}}>
                                <# if (settings.button_icon.value) { #>
                                    <span class="doryo-hero-button-icon">
                                        {{{ elementor.helpers.renderIcon(view, settings.button_icon, { 'aria-hidden': true }, 'i', 'object') }}}
                                    </span>
                                <# } #>
                                <span class="doryo-hero-button-text">
                                    {{{ settings.button_label }}}
                                </span>
                            </a>
                        </div>
                    <# } #>
                </div>

                <# if (settings.hero_image.url) { #>
                    <div class="doryo-hero-image">
                        <img src="{{{ settings.hero_image.url }}}" alt="">
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
}
