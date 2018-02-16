<?php

class WCMP_Legacy_Frontend {
    public $legacy_settings;
    public function __construct() {
        //enqueue scripts
        add_action('wp_enqueue_scripts', array(&$this, 'frontend_scripts'));
        //enqueue styles
        add_action('wp_enqueue_scripts', array(&$this, 'frontend_styles'));
        $this->legacy_settings = get_option( 'wcmp_legacy_settings_name' );
        // init legacy
        $this->init_legacy();
    }
    
    function init_legacy() {
        if(!isset($this->legacy_settings['enable_registration'])){
            add_filter( 'is_enable_wcmp_vendor_registration', '__return_false');
        }
        if(!isset($this->legacy_settings['is_university_on'])){
            add_filter( 'wcmp_vendor_dashboard_menu_vendor_knowledgebase_capability', '__return_false');
        }
        add_filter( 'woocommerce_product_tabs', array($this, 'wc_remove_product_tabs'));
        add_filter( 'wcmp_sold_by_text', array($this, 'wcmp_sold_by_text' ));
        add_filter( 'wcmp_show_report_abuse_link', array($this, 'wcmp_show_report_abuse_link'));
        add_filter( 'wcmp_report_abuse_text', array($this, 'wcmp_report_abuse_text'));
        add_filter( 'wcmp_blocked_vendor_text', array($this, 'wcmp_blocked_vendor_text'));
        
        if(!isset($this->legacy_settings['is_vendor_view_comment'])){
            add_filter( 'is_vendor_can_view_order_notes', '__return_false');
        }
        if(!isset($this->legacy_settings['is_vendor_submit_comment'])){
            add_filter( 'is_vendor_can_add_order_notes', '__return_false');
        }
        if(!isset($this->legacy_settings['is_order_csv_export'])){
            add_filter( 'can_wcmp_vendor_export_orders_csv', '__return_false');
        }
        if(!isset($this->legacy_settings['show_customer_dtl_export'])){
            add_filter( 'show_customer_details_in_export_orders', '__return_false');
        }
        if(!isset($this->legacy_settings['show_customer_billing_export'])){
            add_filter( 'show_customer_billing_address_in_export_orders', '__return_false');
        }
        if(!isset($this->legacy_settings['show_customer_shipping_export'])){
            add_filter( 'show_customer_shipping_address_in_export_orders', '__return_false');
        }
        if(!isset($this->legacy_settings['show_cust_dtl_email'])){
            add_filter( 'show_cust_address_field', '__return_false');
        }
        if(!isset($this->legacy_settings['show_cust_billing_email'])){
            add_filter( 'show_cust_billing_address_field', '__return_false');
        }
        if(!isset($this->legacy_settings['show_cust_shipping_email'])){
            add_filter( 'show_cust_shipping_address_field', '__return_false');
        }
        if(!isset($this->legacy_settings['can_vendor_add_message_on_email_and_thankyou_page'])){
            add_filter( 'can_vendor_add_message_on_email_and_thankyou_page', '__return_false');
        }
        if(isset($this->legacy_settings['is_vendor_add_external_url'])){
            add_filter( 'is_vendor_add_external_url_field', '__return_true');
        }
    }
    
    function wc_remove_product_tabs($tabs){
        if(!isset($this->legacy_settings['enable_vendor_tab'])){
            unset($tabs['vendor']);
        }
        return $tabs;
    }
    
    function wcmp_sold_by_text($sold_by){
        if(isset($this->legacy_settings['sold_by_text'])){
            $sold_by = get_wcmp_vendor_settings( 'sold_by_text', 'legacy');
        }
        return $sold_by;
    }
    
    function wcmp_show_report_abuse_link($bool){
        global $product;
        $report_abouse_for = get_wcmp_vendor_settings( 'show_report_abuse', 'legacy');
        if ($product && $report_abouse_for && $report_abouse_for == 'only_vendor_products'){
            $vendor = get_wcmp_product_vendors($product->get_id());
            if(!$vendor){
                $bool = false;
            }
        }elseif ($report_abouse_for && $report_abouse_for == 'disable') {
            $bool = false;
        }
        return $bool;
    }
    
    function wcmp_report_abuse_text($report_abuse_text){
        if(isset($this->legacy_settings['report_abuse_text'])){
            $report_abuse_text = get_wcmp_vendor_settings( 'report_abuse_text', 'legacy');
        }
        return $report_abuse_text;
    }
    
    function wcmp_blocked_vendor_text($blocked_text){
        if(isset($this->legacy_settings['block_vendor_desc']) && !empty($this->legacy_settings['block_vendor_desc'])){
            $blocked_text = get_wcmp_vendor_settings( 'block_vendor_desc', 'legacy');
        }
        return $blocked_text;
    }

    function frontend_scripts() {
        global $WCMP_Legacy;
        $frontend_script_path = $WCMP_Legacy->plugin_url . 'assets/frontend/js/';
        $frontend_script_path = str_replace(array('http:', 'https:'), '', $frontend_script_path);
        $pluginURL = str_replace(array('http:', 'https:'), '', $WCMP_Legacy->plugin_url);
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        // Enqueue your frontend javascript from here
    }

    function frontend_styles() {
        global $WCMP_Legacy;
        $frontend_style_path = $WCMP_Legacy->plugin_url . 'assets/frontend/css/';
        $frontend_style_path = str_replace(array('http:', 'https:'), '', $frontend_style_path);
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        // Enqueue your frontend stylesheet from here
    }

}
