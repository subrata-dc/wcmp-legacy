<?php

if (!function_exists('wcmp_inactive_notice')) {

    function wcmp_inactive_notice() {
        ?>
        <div id="message" class="error">
            <p><?php printf(__('%sWCMp Legacy Settings is inactive.%s The %sWC Marketplace%s must be active for the WCMp Legacy Settings to work. Please %sinstall, activate & make sure WC Marketplace%s is updated', 'wcmp-legacy'), '<strong>', '</strong>', '<a target="_blank" href="https://wordpress.org/plugins/dc-woocommerce-multi-vendor/">', '</a>', '<a href="' . admin_url('plugin-install.php?tab=search&s=wc+marketplace') . '">', '&nbsp;&raquo;</a>'); ?></p>
        </div>
        <?php
    }

}

if (!function_exists('activate_wcmp_legacy_plugin')) {
    /**
     * On activation, run it.
     *
     * @access public
     * @return void
     */
    function activate_wcmp_legacy_plugin() {
        if (!get_option('wcmp_legacy_plugin_installed')) {
            $legacy_settings = get_option('wcmp_legacy_settings_name');
            if (empty($legacy_settings)) {
                $legacy_settings = array(
                    'enable_registration' => 'Enable',
                    'is_university_on' => 'Enable',
                    'enable_vendor_tab' => 'Enable',
                    'sold_by_text' => 'Sold by',
                    'show_report_abuse' => 'only_vendor_products',
                    'report_abuse_text' => 'Report Abuse',
                    'inventory' => 'Enable',
                    'shipping' => 'Enable',
                    'linked_products' => 'Enable',
                    'attribute' => 'Enable',
                    'advanced' => 'Enable',
                    'is_vendor_view_comment' => 'Enable',
                    'is_vendor_submit_comment' => 'Enable',
                    'is_order_csv_export' => 'Enable',
                    'show_customer_dtl_export' => 'Enable',
                    'show_customer_billing_export' => 'Enable',
                    'show_customer_shipping_export' => 'Enable',
                    'show_cust_dtl_email' => 'Enable',
                    'show_cust_billing_email' => 'Enable',
                    'show_cust_shipping_email' => 'Enable',
                    'show_cust_order_calulations' => 'Enable',
                    'can_vendor_add_message_on_email_and_thankyou_page' => 'Enable',
                    'is_vendor_add_external_url' => 'Enable'
                );
                update_option('wcmp_legacy_settings_name', $legacy_settings);
            }
            update_option('wcmp_legacy_plugin_installed', 1);
        }
    }
}

if (!function_exists('deactivate_wcmp_legacy_plugin')) {
    /**
     * On deactivation run it
     */
    function deactivate_wcmp_legacy_plugin() {
        delete_option('wcmp_legacy_plugin_installed');
    }
}