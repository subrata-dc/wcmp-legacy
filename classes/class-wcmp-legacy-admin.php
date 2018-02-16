<?php

class WCMP_Legacy_Admin {

    public $legacy_settings;

    public function __construct() {
        $this->legacy_settings = get_option( 'wcmp_legacy_settings_name' );
        //admin script and style
        add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'));
        add_filter('wcmp_tabs', array($this, 'wcmp_tabs'));
        add_action('settings_page_legacy_tab_init', array(&$this, 'legacy_tab_init'));
        add_filter( 'woocommerce_product_data_tabs', array($this, 'wcmp_woocommerce_product_data_tabs'), 99, 1);
    }

    public function wcmp_tabs($tabs) {
        $tabs['legacy'] = __('Legacy', 'dc-woocommerce-multi-vendor');
        return $tabs;
    }

    public function legacy_tab_init($tab) {
        $this->load_class("settings-{$tab}");
        new WCMp_Settings_Legacy($tab);
    }

    public function load_class($class_name = '') {
        global $WCMP_Legacy;
        if ('' != $class_name) {
            require_once ($WCMP_Legacy->plugin_path . '/admin/class-' . esc_attr($WCMP_Legacy->token) . '-' . esc_attr($class_name) . '.php');
        } // End If Statement
    }
    
    public function wcmp_woocommerce_product_data_tabs($panels){
        if (is_user_wcmp_vendor(get_current_user_id())) {
            if(!isset($this->legacy_settings['inventory'])){
                unset($panels['inventory']);
            }
            if(!isset($this->legacy_settings['shipping'])){
                unset($panels['shipping']);
            }
            if(!isset($this->legacy_settings['linked_products'])){
                unset($panels['linked_products']);
            }
            if(!isset($this->legacy_settings['attribute'])){
                unset($panels['attribute']);
            }
            if(!isset($this->legacy_settings['advanced'])){
                unset($panels['advanced']);
            }
            
        }
        return $panels;
    }

    /**
     * Admin Scripts
     */
    public function enqueue_admin_script() {
        global $WCMP_Legacy;
        $screen = get_current_screen();
    }

}
